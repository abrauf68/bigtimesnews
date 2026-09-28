@extends('frontend.pages.static.layout')

@section('title', 'About Us')
@section('meta_title', 'About Big Times News | Independent Digital News Platform')
@section('meta_description', 'Learn who we are, what Big Times News covers, and the editorial standards, corrections policy and transparency principles behind every story we publish.')
@section('meta_keywords', 'about Big Times News, editorial standards, news website, corrections policy, who we are')
@section('crumb', 'About Us')
@section('heading', 'About Big Times News')
@section('lead', 'Big Times News is an independent digital news platform that brings readers clear, timely and well-sourced reporting on the stories shaping the United States and the world.')

@push('schema')
    @php
        $sameAs = array_values(array_filter(config('site.social')));
        $aboutSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'AboutPage',
            'name' => 'About ' . config('site.name'),
            'url' => route('frontend.about'),
            'description' => 'Who we are, what we cover and the editorial standards behind ' . config('site.name') . '.',
            'mainEntity' => array_filter([
                '@type' => 'NewsMediaOrganization',
                'name' => config('site.name'),
                'url' => url('/'),
                'logo' => \App\Helpers\Helper::getLogoLight(),
                'email' => config('site.contact_email'),
                'sameAs' => $sameAs ?: null,
                'publishingPrinciples' => route('frontend.about') . '#editorial-standards',
                'correctionsPolicy' => route('frontend.about') . '#corrections',
                'contactPoint' => [
                    '@type' => 'ContactPoint',
                    'contactType' => 'customer support',
                    'email' => config('site.contact_email'),
                    'url' => route('frontend.contact'),
                ],
            ]),
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($aboutSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('page_body')
    <h2 id="who-we-are">Who we are</h2>
    <p>{{ config('site.name') }} ({{ config('site.domain') }}) is a digital-only news publication. We report on breaking developments and explain the context behind them, so readers can understand what happened, why it matters and what may come next. Our goal is simple: be a reliable place to catch up on the day's most important news without noise, clickbait or confusion.</p>

    <h2 id="what-we-cover">What we cover</h2>
    <p>Our newsroom organises its coverage into clear sections so you can go straight to the topics you care about:</p>
    @if ($categories->count())
        <div class="sp-grid">
            @foreach ($categories as $category)
                <a href="{{ route('frontend.news.category', $category->slug) }}">{{ $category->name }}</a>
            @endforeach
        </div>
    @else
        <p>US news, world news, politics, business and economy, finance, technology, health, sports, entertainment and trending stories.</p>
    @endif
    <p>You can also browse everything in one place on our <a href="{{ route('frontend.news.index') }}">Latest News</a> page.</p>

    <h2 id="mission">Our mission</h2>
    <p>We believe good journalism should be accurate, fair and easy to read. We aim to give people the facts they need to form their own opinions, to explain complicated subjects in plain language, and to treat readers with respect, not as clicks.</p>

    <h2 id="editorial-standards">Editorial standards</h2>
    <p>Every article published on {{ config('site.name') }} is guided by the following principles:</p>
    <ul>
        <li><strong>Accuracy first.</strong> We check names, numbers, dates and quotes against reliable sources before publishing, and we prefer primary sources such as official statements, court filings, company reports and government data.</li>
        <li><strong>Clear sourcing.</strong> When we rely on other reporting or public documents, we say so and link to the source wherever possible.</li>
        <li><strong>Fairness and balance.</strong> We present relevant viewpoints on contested issues and avoid presenting speculation as fact.</li>
        <li><strong>Independence.</strong> Advertising, partnerships and affiliations never decide what we report or how we report it.</li>
        <li><strong>Clear labelling.</strong> News, analysis and opinion are kept distinct. Any sponsored or promotional content is clearly labelled as such.</li>
        <li><strong>Respect for privacy and dignity.</strong> We take particular care with stories involving minors, victims of crime and people in vulnerable situations.</li>
    </ul>

    @if (config('site.ai_disclosure'))
        <h2 id="how-we-work">How we create content</h2>
        <p>In the interest of transparency: we use modern software tools, including artificial-intelligence (AI) assistants, to help with research, trend discovery, drafting and editing. AI-assisted material is subject to our editorial standards above and to review before it is presented to readers. AI tools can make mistakes, so if you spot an error in any article, please tell us and we will fix it promptly.</p>
    @endif

    <h2 id="corrections">Corrections and feedback</h2>
    <p>We make mistakes sometimes, and when we do we want to correct them quickly and openly. If you believe an article contains a factual error, a misleading statement or outdated information, please write to <a href="mailto:{{ config('site.corrections_email') }}">{{ config('site.corrections_email') }}</a> or use our <a href="{{ route('frontend.contact') }}">contact form</a> and choose "Correction request". Please include the link to the article and describe the issue. Where a story is materially changed after publication, we will update it and note the change.</p>

    <h2 id="advertising">Advertising and revenue</h2>
    <p>{{ config('site.name') }} is supported by advertising and other commercial partnerships that help us keep our content free to read. Advertisers do not influence our editorial decisions. You can read more about how ads and cookies work in our <a href="{{ route('frontend.privacy') }}">Privacy Policy</a>.</p>

    <h2 id="get-in-touch">Get in touch</h2>
    <p>Have a news tip, a question or feedback? We would love to hear from you.</p>
    <div class="sp-card">
        <p style="margin:0 0 .35rem;"><strong>Email:</strong> <a href="mailto:{{ config('site.contact_email') }}">{{ config('site.contact_email') }}</a></p>
        @if (config('site.address'))
            <p style="margin:0 0 .35rem;"><strong>Address:</strong> {{ config('site.address') }}</p>
        @endif
        <p style="margin:0;"><a href="{{ route('frontend.contact') }}">Visit our Contact page &rarr;</a></p>
    </div>
@endsection
