@extends('frontend.pages.static.layout')

@section('title', 'Contact Us')
@section('meta_title', 'Contact Big Times News | Send a Tip, Correction or Enquiry')
@section('meta_description', 'Contact the Big Times News team to send a news tip, request a correction, ask about advertising or partnerships, or raise a copyright or privacy concern.')
@section('meta_keywords', 'contact Big Times News, news tip, correction request, advertise with us, editorial contact')
@section('crumb', 'Contact')
@section('heading', 'Contact Us')
@section('lead', 'We read every message. Whether you have a news tip, spotted an error, or want to work with us, use the form below or email us directly.')

@push('schema')
    @php
        $contactSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'ContactPage',
            'name' => 'Contact ' . config('site.name'),
            'url' => route('frontend.contact'),
            'mainEntity' => array_filter([
                '@type' => 'NewsMediaOrganization',
                'name' => config('site.name'),
                'url' => url('/'),
                'email' => config('site.contact_email'),
                'address' => config('site.address') ?: null,
                'contactPoint' => [
                    [
                        '@type' => 'ContactPoint',
                        'contactType' => 'customer support',
                        'email' => config('site.contact_email'),
                        'availableLanguage' => ['English'],
                    ],
                    [
                        '@type' => 'ContactPoint',
                        'contactType' => 'editorial corrections',
                        'email' => config('site.corrections_email'),
                    ],
                ],
            ]),
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($contactSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('page_css')
<style>
    .static-page .cf-row { display:grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .static-page .cf-field { margin-bottom: 1rem; }
    .static-page .cf-field label { display:block; font-weight:600; margin-bottom:.35rem; color: var(--sp-head); font-size:.95rem; }
    .static-page .cf-field input, .static-page .cf-field select, .static-page .cf-field textarea {
        width:100%; padding:.7rem .9rem; border:1px solid var(--sp-border); border-radius:8px;
        background: var(--sp-soft); color: var(--sp-head); font-size:1rem; font-family:inherit;
    }
    .static-page .cf-field textarea { min-height: 170px; resize: vertical; }
    .static-page .cf-field input:focus, .static-page .cf-field select:focus, .static-page .cf-field textarea:focus { outline:2px solid #2757fd; outline-offset:0; }
    .static-page .cf-error { color:#dc2626; font-size:.875rem; margin-top:.3rem; }
    .static-page .cf-alert { padding:.9rem 1.1rem; border-radius:8px; margin-bottom:1.25rem; font-size:.98rem; }
    .static-page .cf-alert.ok { background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; }
    .static-page .cf-alert.err { background:#fef2f2; color:#991b1b; border:1px solid #fecaca; }
    .static-page .cf-hp { position:absolute !important; left:-9999px !important; height:0; width:0; overflow:hidden; }
    .static-page .cf-submit { background:#2757fd; color:#fff; border:0; border-radius:8px; padding:.8rem 1.6rem; font-weight:600; font-size:1rem; cursor:pointer; }
    .static-page .cf-submit:hover { background:#1e47d6; }
    @media (max-width: 640px) { .static-page .cf-row { grid-template-columns: 1fr; } }
</style>
@endsection

@section('page_body')
    <h2 id="how-can-we-help">How can we help?</h2>
    <ul>
        <li><strong>News tips and story ideas:</strong> tell us what you think we should be covering.</li>
        <li><strong>Corrections:</strong> spotted a factual error? Share the article link and we will review it.</li>
        <li><strong>Advertising and partnerships:</strong> enquiries about working with {{ config('site.name') }}.</li>
        <li><strong>Copyright and content removal:</strong> see the copyright section of our <a href="{{ route('frontend.terms') }}#copyright">Terms of Service</a>.</li>
        <li><strong>Privacy requests:</strong> access, correction or deletion of your personal data. See our <a href="{{ route('frontend.privacy') }}#your-rights">Privacy Policy</a>.</li>
    </ul>

    <div class="sp-card">
        <p style="margin:0 0 .35rem;"><strong>General email:</strong> <a href="mailto:{{ config('site.contact_email') }}">{{ config('site.contact_email') }}</a></p>
        @if (config('site.corrections_email') !== config('site.contact_email'))
            <p style="margin:0 0 .35rem;"><strong>Corrections:</strong> <a href="mailto:{{ config('site.corrections_email') }}">{{ config('site.corrections_email') }}</a></p>
        @endif
        @if (config('site.privacy_email') !== config('site.contact_email'))
            <p style="margin:0 0 .35rem;"><strong>Privacy:</strong> <a href="mailto:{{ config('site.privacy_email') }}">{{ config('site.privacy_email') }}</a></p>
        @endif
        @if (config('site.address'))
            <p style="margin:0 0 .35rem;"><strong>Address:</strong> {{ config('site.address') }}</p>
        @endif
        <p style="margin:0;"><strong>Response time:</strong> we aim to reply within 2 business days.</p>
    </div>

    <h2 id="contact-form">Send us a message</h2>

    @if (session('contact_success'))
        <div class="cf-alert ok" role="status">{{ session('contact_success') }}</div>
    @endif
    @if (session('contact_error'))
        <div class="cf-alert err" role="alert">{{ session('contact_error') }}</div>
    @endif

    <form action="{{ route('frontend.contact.submit') }}" method="POST" novalidate>
        @csrf

        {{-- Honeypot (spam bots fill this, humans never see it) --}}
        <div class="cf-hp" aria-hidden="true">
            <label for="website">Leave this field empty</label>
            <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
        </div>

        <div class="cf-row">
            <div class="cf-field">
                <label for="cf-name">Your name</label>
                <input type="text" id="cf-name" name="name" value="{{ old('name') }}" maxlength="100" required autocomplete="name">
                @error('name') <div class="cf-error">{{ $message }}</div> @enderror
            </div>
            <div class="cf-field">
                <label for="cf-email">Your email</label>
                <input type="email" id="cf-email" name="email" value="{{ old('email') }}" maxlength="150" required autocomplete="email">
                @error('email') <div class="cf-error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="cf-row">
            <div class="cf-field">
                <label for="cf-topic">Topic</label>
                <select id="cf-topic" name="topic" required>
                    @foreach ([
                        'general' => 'General question',
                        'news-tip' => 'News tip / story idea',
                        'correction' => 'Correction request',
                        'advertising' => 'Advertising / partnership',
                        'copyright' => 'Copyright / content removal',
                        'privacy' => 'Privacy request',
                    ] as $value => $label)
                        <option value="{{ $value }}" @selected(old('topic', 'general') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('topic') <div class="cf-error">{{ $message }}</div> @enderror
            </div>
            <div class="cf-field">
                <label for="cf-subject">Subject</label>
                <input type="text" id="cf-subject" name="subject" value="{{ old('subject') }}" maxlength="150" required>
                @error('subject') <div class="cf-error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="cf-field">
            <label for="cf-message">Message</label>
            <textarea id="cf-message" name="message" maxlength="3000" required>{{ old('message') }}</textarea>
            @error('message') <div class="cf-error">{{ $message }}</div> @enderror
        </div>

        <p style="font-size:.9rem;">By sending this form you agree to our <a href="{{ route('frontend.privacy') }}">Privacy Policy</a>. We use your details only to respond to your message.</p>
        <button type="submit" class="cf-submit">Send message</button>
    </form>
@endsection
