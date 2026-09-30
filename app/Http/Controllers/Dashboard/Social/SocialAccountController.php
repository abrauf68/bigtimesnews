<?php

namespace App\Http\Controllers\Dashboard\Social;

use App\Enums\SocialPlatform;
use App\Http\Controllers\Controller;
use App\Models\SocialPlatformAccount;
use App\Support\Social\OAuthClientManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class SocialAccountController extends Controller
{
    public function index()
    {
        $accounts = SocialPlatformAccount::all()->keyBy('platform');
        $platforms = SocialPlatform::cases();

        return view('dashboard.social.accounts', compact('accounts', 'platforms'));
    }

    public function connect(string $platform, OAuthClientManager $manager)
    {
        $platformEnum = SocialPlatform::from($platform);
        $account = SocialPlatformAccount::where('platform', $platformEnum->value)->first();

        $effectiveAccount = $account;
        if ($platformEnum === SocialPlatform::Instagram && (!$account || !$account->hasCredentials())) {
            $effectiveAccount = SocialPlatformAccount::where('platform', SocialPlatform::Facebook->value)->first();
        }

        if (!$effectiveAccount || !$effectiveAccount->hasCredentials()) {
            return redirect()->route('dashboard.social.index')->with('error', 'Please save the Client ID and Client Secret for ' . $platformEnum->label() . ' first.');
        }

        $state = Str::random(40);
        session(['social_oauth_state' => $state]);

        try {
            $url = $manager->forPlatform($platformEnum)->authorizeUrl($state);
        } catch (Throwable $e) {
            return redirect()->route('dashboard.social.index')->with('error', 'Could not start ' . $platformEnum->label() . ' connection: ' . $e->getMessage());
        }

        return redirect()->away($url);
    }

    public function callback(string $platform, Request $request, OAuthClientManager $manager)
    {
        $platformEnum = SocialPlatform::from($platform);

        if ($request->filled('error')) {
            return redirect()->route('dashboard.social.index')->with('error', $platformEnum->label() . ' connection was cancelled or denied.');
        }

        if (!$request->filled('state') || $request->query('state') !== session('social_oauth_state')) {
            return redirect()->route('dashboard.social.index')->with('error', 'Invalid OAuth state, please try connecting again.');
        }

        try {
            $result = $manager->forPlatform($platformEnum)->exchangeCode($request->query('code', ''));

            SocialPlatformAccount::updateOrCreate(
                ['platform' => $platformEnum->value],
                [
                    'display_name' => $result['display_name'] ?? null,
                    'external_account_id' => $result['external_account_id'] ?? null,
                    'access_token' => $result['access_token'],
                    'refresh_token' => $result['refresh_token'] ?? null,
                    'token_expires_at' => !empty($result['expires_in']) ? now()->addSeconds((int) $result['expires_in']) : null,
                    'meta' => $result['meta'] ?? [],
                    'status' => 'connected',
                    'health' => 'healthy',
                    'health_message' => null,
                    'is_enabled' => true,
                    'last_checked_at' => now(),
                    'last_health_notified_at' => null,
                    'connected_by' => auth()->id(),
                ]
            );

            return redirect()->route('dashboard.social.index')->with('success', $platformEnum->label() . ' connected successfully.');
        } catch (Throwable $e) {
            Log::error('Social OAuth callback failed', ['platform' => $platform, 'error' => $e->getMessage()]);

            return redirect()->route('dashboard.social.index')->with('error', 'Could not connect ' . $platformEnum->label() . ': ' . $e->getMessage());
        }
    }

    public function disconnect(SocialPlatformAccount $account)
    {
        $account->update([
            'access_token' => null,
            'refresh_token' => null,
            'token_expires_at' => null,
            'status' => 'disconnected',
            'is_enabled' => false,
        ]);

        return redirect()->route('dashboard.social.index')->with('success', $account->platformEnum()->label() . ' disconnected.');
    }

    public function toggle(SocialPlatformAccount $account)
    {
        $account->update(['is_enabled' => !$account->is_enabled]);

        return redirect()->route('dashboard.social.index')->with('success', $account->platformEnum()->label() . ' updated.');
    }

    public function updateCredentials(Request $request, string $platform)
    {
        $platformEnum = SocialPlatform::from($platform);

        $request->validate([
            'client_id' => 'nullable|string|max:255',
            'client_secret' => 'nullable|string|max:1000',
            'settings' => 'nullable|array',
        ]);

        $account = SocialPlatformAccount::firstOrNew(['platform' => $platformEnum->value]);

        if ($request->filled('client_id')) {
            $account->client_id = $request->input('client_id');
        }

        if ($request->filled('client_secret')) {
            $account->client_secret = $request->input('client_secret');
        }

        $account->settings = array_filter((array) $request->input('settings', []), fn ($value) => $value !== null && $value !== '');

        if (!$account->exists) {
            $account->status = 'disconnected';
            $account->health = 'healthy';
            $account->is_enabled = false;
        }

        $account->save();

        return redirect()->route('dashboard.social.index')->with('success', $platformEnum->label() . ' credentials saved.');
    }
}
