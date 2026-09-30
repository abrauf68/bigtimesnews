<?php

namespace App\Support\Social\Drivers;

use App\Exceptions\Social\InvalidTokenSocialException;
use App\Exceptions\Social\TemporarySocialException;
use App\Models\Post;
use App\Support\Social\PlatformCredentials;
use Illuminate\Http\Client\Response;
use RuntimeException;

abstract class AbstractHttpPublisher
{
    public function __construct(protected PlatformCredentials $credentials)
    {
    }

    protected function imageUrl(Post $post): string
    {
        return asset($post->meta_image);
    }

    protected function postLink(Post $post): string
    {
        return $post->category ? route('frontend.news.show', [$post->category->slug, $post->slug]) : url('/');
    }

    protected function assertSuccessful(Response $response, string $platformLabel): void
    {
        if ($response->successful()) {
            return;
        }

        $status = $response->status();

        if (in_array($status, [401, 403], true)) {
            throw new InvalidTokenSocialException($platformLabel . ' rejected the access token (HTTP ' . $status . '): ' . $response->body());
        }

        if ($status === 429 || $status >= 500) {
            throw new TemporarySocialException($platformLabel . ' returned a temporary error (HTTP ' . $status . '): ' . $response->body());
        }

        throw new RuntimeException($platformLabel . ' request failed (HTTP ' . $status . '): ' . $response->body());
    }
}
