<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessageMail;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function about()
    {
        try {
            $categories = Category::where('is_active', 'active')->orderBy('name')->get(['name', 'slug']);
        } catch (\Throwable $th) {
            $categories = collect();
        }

        return view('frontend.pages.static.about', compact('categories'));
    }

    public function contact()
    {
        return view('frontend.pages.static.contact');
    }

    public function contactSubmit(Request $request)
    {
        // Honeypot: real users kabhi ye hidden field nahi bharte
        if ($request->filled('website')) {
            return redirect()->route('frontend.contact')
                ->with('contact_success', 'Thank you! Your message has been received.');
        }

        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:100',
            'email'   => 'required|email:rfc|max:150',
            'topic'   => 'required|in:general,news-tip,correction,advertising,copyright,privacy',
            'subject' => 'required|string|max:150',
            'message' => 'required|string|min:20|max:3000',
        ], [
            'message.min' => 'Please write at least 20 characters so we can understand your message.',
        ]);

        if ($validator->fails()) {
            return redirect()->to(route('frontend.contact') . '#contact-form')
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        try {
            Mail::to(config('site.contact_email'))->send(new ContactMessageMail($data, $request->ip()));
        } catch (\Throwable $th) {
            Log::error('Contact form mail failed', ['error' => $th->getMessage()]);

            return redirect()->to(route('frontend.contact') . '#contact-form')
                ->withInput()
                ->with('contact_error', 'Sorry, we could not send your message right now. Please email us directly at ' . config('site.contact_email') . '.');
        }

        return redirect()->to(route('frontend.contact') . '#contact-form')
            ->with('contact_success', 'Thank you! Your message has been sent. We aim to reply within 2 business days.');
    }

    public function privacy()
    {
        return view('frontend.pages.static.privacy-policy');
    }

    public function terms()
    {
        return view('frontend.pages.static.terms-of-service');
    }
}
