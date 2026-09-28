@extends('frontend.pages.static.layout')

@section('title', 'Terms of Service')
@section('meta_title', 'Terms of Service | Big Times News')
@section('meta_description', 'Read the Terms of Service for Big Times News: rules for using our website, comments, intellectual property, disclaimers, copyright complaints and governing law.')
@section('meta_keywords', 'terms of service, terms and conditions, website terms, user agreement, Big Times News terms')
@section('crumb', 'Terms of Service')
@section('heading', 'Terms of Service')
@section('lead', 'Please read these terms carefully. They set out the rules for using ' . config('site.domain') . ' and the relationship between you and ' . config('site.name') . '.')
@section('updated', 'Last updated: ' . \Illuminate\Support\Carbon::parse(config('site.policies_updated'))->format('F j, Y'))

@push('schema')
    @php
        $termsSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => 'Terms of Service',
            'url' => route('frontend.terms'),
            'dateModified' => config('site.policies_updated'),
            'isPartOf' => ['@type' => 'WebSite', 'name' => config('site.name'), 'url' => url('/')],
            'publisher' => ['@type' => 'Organization', 'name' => config('site.name'), 'url' => url('/')],
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($termsSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('page_body')
    <div class="sp-toc">
        <strong>On this page</strong>
        <ol>
            <li><a href="#acceptance">Acceptance of terms</a></li>
            <li><a href="#use-of-site">Use of the Site</a></li>
            <li><a href="#accounts">Accounts</a></li>
            <li><a href="#user-content">Comments and user content</a></li>
            <li><a href="#intellectual-property">Intellectual property</a></li>
            <li><a href="#copyright">Copyright complaints</a></li>
            <li><a href="#news-content">News content, AI and no professional advice</a></li>
            <li><a href="#third-parties">Third-party links and ads</a></li>
            <li><a href="#prohibited">Prohibited conduct</a></li>
            <li><a href="#disclaimer">Disclaimer of warranties</a></li>
            <li><a href="#liability">Limitation of liability</a></li>
            <li><a href="#indemnity">Indemnification</a></li>
            <li><a href="#termination">Termination</a></li>
            <li><a href="#governing-law">Governing law</a></li>
            <li><a href="#changes">Changes to these terms</a></li>
            <li><a href="#contact-us">Contact</a></li>
        </ol>
    </div>

    <h2 id="acceptance">1. Acceptance of terms</h2>
    <p>By accessing or using {{ config('site.domain') }} (the "Site"), including reading articles, subscribing to newsletters, posting comments or using any related service, you agree to be bound by these Terms of Service and our <a href="{{ route('frontend.privacy') }}">Privacy Policy</a>. If you do not agree, please do not use the Site.</p>

    <h2 id="use-of-site">2. Use of the Site</h2>
    <p>You may use the Site for lawful, personal and non-commercial purposes in accordance with these terms. You are responsible for ensuring that your use of the Site complies with all applicable laws and regulations. You must be at least 13 years old (or the minimum age in your country) to use the Site.</p>

    <h2 id="accounts">3. Accounts</h2>
    <p>Some features may require an account. You agree to provide accurate information, keep your login details confidential and be responsible for all activity under your account. Notify us immediately if you suspect unauthorised use. We may suspend or delete accounts that breach these terms.</p>

    <h2 id="user-content">4. Comments and user content</h2>
    <p>You are solely responsible for comments, messages and other material you submit ("User Content"). By submitting User Content you confirm that you own it or have the right to share it, and you grant {{ config('site.name') }} a non-exclusive, worldwide, royalty-free licence to host, display, reproduce and distribute it on the Site in connection with our services.</p>
    <p>We may moderate, edit, refuse or remove any User Content at our discretion, particularly content that:</p>
    <ul>
        <li>is unlawful, defamatory, harassing, hateful, threatening or discriminatory;</li>
        <li>infringes intellectual property or privacy rights;</li>
        <li>contains spam, advertising, malware or misleading information; or</li>
        <li>is sexually explicit, or exploits or endangers minors.</li>
    </ul>
    <p>Opinions expressed in comments belong to their authors and do not represent the views of {{ config('site.name') }}.</p>

    <h2 id="intellectual-property">5. Intellectual property</h2>
    <p>The Site and its content, including articles, text, graphics, logos, layout and software, are owned by or licensed to {{ config('site.name') }} and are protected by copyright, trademark and other laws. Unless we give written permission you may not copy, republish, sell, modify or create derivative works from our content, except for:</p>
    <ul>
        <li>personal, non-commercial reading; and</li>
        <li>brief quotations with clear attribution and a link back to the original article, as permitted by fair use or fair dealing.</li>
    </ul>
    <p>Some images on the Site are supplied by third-party providers under their own licences and remain the property of their respective owners.</p>

    <h2 id="copyright">6. Copyright complaints</h2>
    <p>We respect the intellectual property rights of others. If you believe material on the Site infringes your copyright, please contact us at <a href="mailto:{{ config('site.contact_email') }}">{{ config('site.contact_email') }}</a> with:</p>
    <ol>
        <li>a description of the copyrighted work and the URL of the allegedly infringing material on our Site;</li>
        <li>your name, address, email address and phone number;</li>
        <li>a statement that you have a good-faith belief the use is not authorised by the owner, its agent or the law; and</li>
        <li>a statement, under penalty of perjury, that the information is accurate and that you are the owner or authorised to act on the owner's behalf, with your signature (physical or electronic).</li>
    </ol>
    <p>We will review valid notices promptly and may remove or disable access to the material. We may terminate accounts of repeat infringers.</p>

    <h2 id="news-content">7. News content, AI assistance and no professional advice</h2>
    <p>We work to keep our reporting accurate and up to date, but news develops quickly and information may change after publication. Content on the Site is provided for general informational purposes only.</p>
    <p>Some content may be prepared with the assistance of AI and other software tools. Although we aim to apply editorial standards, errors and omissions can occur. Please verify important information with official sources.</p>
    <p><strong>No professional advice.</strong> Nothing on the Site, including our Finance, Business, Health and Politics coverage, is financial, investment, legal, medical or other professional advice. Do not rely on it as a substitute for advice from a qualified professional. Always consult a licensed professional before making decisions about your health, money or legal position. Past performance and forecasts mentioned in articles are not guarantees of future results.</p>

    <h2 id="third-parties">8. Third-party links, ads and services</h2>
    <p>The Site may contain links to third-party websites and display advertisements from third parties. These are provided for convenience only. We do not control or endorse them and are not responsible for their content, products, services or privacy practices. Any dealings you have with third parties are solely between you and them.</p>

    <h2 id="prohibited">9. Prohibited conduct</h2>
    <p>When using the Site you agree not to:</p>
    <ul>
        <li>break any law or infringe the rights of others;</li>
        <li>attempt to gain unauthorised access to the Site, other accounts, servers or networks;</li>
        <li>introduce viruses, malware or other harmful code;</li>
        <li>use bots, scrapers or other automated tools to copy or harvest content or data without our written permission, or in a way that overloads or disrupts the Site;</li>
        <li>impersonate any person or misrepresent your affiliation;</li>
        <li>post spam, artificially inflate views, likes or comments, or manipulate advertising in any way, including clicking on ads for the purpose of generating revenue; or</li>
        <li>circumvent security or access-control features.</li>
    </ul>

    <h2 id="disclaimer">10. Disclaimer of warranties</h2>
    <p>The Site and all content are provided "as is" and "as available" without warranties of any kind, whether express or implied, including warranties of accuracy, completeness, merchantability, fitness for a particular purpose and non-infringement. We do not warrant that the Site will be uninterrupted, secure or error-free.</p>

    <h2 id="liability">11. Limitation of liability</h2>
    <p>To the fullest extent permitted by law, {{ config('site.name') }} and its owners, editors, contributors and partners will not be liable for any indirect, incidental, special, consequential or punitive damages, or for any loss of profits, data or goodwill, arising from your use of, or inability to use, the Site or from reliance on its content. Nothing in these terms excludes liability that cannot be excluded under applicable law.</p>

    <h2 id="indemnity">12. Indemnification</h2>
    <p>You agree to indemnify and hold harmless {{ config('site.name') }} and its owners, editors and contributors from any claims, losses, liabilities and expenses (including reasonable legal fees) arising from your User Content, your breach of these terms or your violation of any law or third-party right.</p>

    <h2 id="termination">13. Termination</h2>
    <p>We may suspend or terminate your access to the Site at any time, with or without notice, if we believe you have breached these terms or for any other legitimate reason. Sections that by their nature should survive termination (including intellectual property, disclaimers, limitation of liability and governing law) will continue to apply.</p>

    <h2 id="governing-law">14. Governing law</h2>
    <p>These terms are governed by the laws of {{ config('site.governing_law') }}, without regard to conflict-of-law principles. Any dispute arising from these terms or your use of the Site will be subject to the exclusive jurisdiction of the competent courts of {{ config('site.governing_law') }}, unless mandatory consumer-protection laws in your country of residence provide otherwise.</p>

    <h2 id="changes">15. Changes to these terms</h2>
    <p>We may revise these terms from time to time. The updated version will be posted on this page with a new "Last updated" date. Your continued use of the Site after changes take effect means you accept the revised terms.</p>

    <h2 id="contact-us">16. Contact</h2>
    <p>If you have questions about these Terms of Service, please email <a href="mailto:{{ config('site.contact_email') }}">{{ config('site.contact_email') }}</a> or visit our <a href="{{ route('frontend.contact') }}">Contact page</a>.</p>
@endsection
