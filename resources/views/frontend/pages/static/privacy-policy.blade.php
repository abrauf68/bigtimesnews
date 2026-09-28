@extends('frontend.pages.static.layout')

@section('title', 'Privacy Policy')
@section('meta_title', 'Privacy Policy | Big Times News')
@section('meta_description', 'How Big Times News collects, uses and protects your personal data, including cookies, analytics, advertising, newsletters and your privacy rights.')
@section('meta_keywords', 'privacy policy, cookies policy, data protection, GDPR, Big Times News privacy')
@section('crumb', 'Privacy Policy')
@section('heading', 'Privacy Policy')
@section('lead', 'Your privacy matters to us. This policy explains what information we collect when you use ' . config('site.domain') . ', how we use it and the choices you have.')
@section('updated', 'Last updated: ' . \Illuminate\Support\Carbon::parse(config('site.policies_updated'))->format('F j, Y'))

@push('schema')
    @php
        $privacySchema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => 'Privacy Policy',
            'url' => route('frontend.privacy'),
            'dateModified' => config('site.policies_updated'),
            'isPartOf' => ['@type' => 'WebSite', 'name' => config('site.name'), 'url' => url('/')],
            'publisher' => ['@type' => 'Organization', 'name' => config('site.name'), 'url' => url('/')],
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($privacySchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('page_body')
    <div class="sp-toc">
        <strong>On this page</strong>
        <ol>
            <li><a href="#who-we-are">Who we are</a></li>
            <li><a href="#information-we-collect">Information we collect</a></li>
            <li><a href="#how-we-use">How we use information</a></li>
            <li><a href="#cookies">Cookies and similar technologies</a></li>
            <li><a href="#advertising">Advertising and third parties</a></li>
            <li><a href="#sharing">Who we share data with</a></li>
            <li><a href="#retention">How long we keep data</a></li>
            <li><a href="#security">Security</a></li>
            <li><a href="#your-rights">Your rights and choices</a></li>
            <li><a href="#children">Children's privacy</a></li>
            <li><a href="#transfers">International transfers</a></li>
            <li><a href="#links">Links to other websites</a></li>
            <li><a href="#changes">Changes to this policy</a></li>
            <li><a href="#contact-us">Contact us</a></li>
        </ol>
    </div>

    <p>This Privacy Policy applies to {{ config('site.name') }} ("we", "us", "our") and the website {{ config('site.domain') }} (the "Site"). By using the Site you acknowledge the practices described here. If you do not agree, please do not use the Site.</p>

    <h2 id="who-we-are">1. Who we are</h2>
    <p>{{ config('site.name') }} is a digital news publication and is the controller of the personal data described in this policy. You can reach us at <a href="mailto:{{ config('site.privacy_email') }}">{{ config('site.privacy_email') }}</a>@if (config('site.address')) or by post at {{ config('site.address') }}@endif.</p>

    <h2 id="information-we-collect">2. Information we collect</h2>
    <h3>Information you give us</h3>
    <ul>
        <li><strong>Contact form:</strong> your name, email address, subject and message when you write to us.</li>
        <li><strong>Newsletter:</strong> your email address when you subscribe to our newsletter.</li>
        <li><strong>Comments:</strong> the name and email address you enter and the comment you post. Your email address is not displayed publicly.</li>
        <li><strong>Accounts:</strong> if you register or sign in, we process your name, email address and password (stored in hashed form). If you sign in with Google or GitHub, we receive basic profile information such as your name and email address from that provider.</li>
    </ul>
    <h3>Information collected automatically</h3>
    <ul>
        <li><strong>Usage data:</strong> pages viewed, links clicked, referring website, date and time of visit and approximate location derived from your IP address.</li>
        <li><strong>Device data:</strong> IP address, browser type and version, operating system, screen size and language settings.</li>
        <li><strong>Interaction data:</strong> for example, article likes, which are linked to an anonymous session identifier rather than your name.</li>
    </ul>
    <p>We do not knowingly collect sensitive personal data (such as health, religion or political opinions) and ask that you do not include such data in messages or comments.</p>

    <h2 id="how-we-use">3. How we use information</h2>
    <ul>
        <li>To operate, maintain and secure the Site and to deliver the content you request.</li>
        <li>To respond to your messages, correction requests and enquiries.</li>
        <li>To send the newsletter you subscribed to (you can unsubscribe at any time).</li>
        <li>To publish and moderate comments and to prevent spam and abuse.</li>
        <li>To understand how readers use the Site so we can improve our content, performance and design.</li>
        <li>To show advertising and measure its performance.</li>
        <li>To comply with legal obligations and to establish, exercise or defend legal claims.</li>
    </ul>
    <p><strong>Legal bases (EEA/UK visitors).</strong> Depending on the activity, we rely on your consent (for example cookies and newsletters), our legitimate interests (running and securing the Site, understanding usage), performance of a contract (accounts) and compliance with legal obligations.</p>

    <h2 id="cookies">4. Cookies and similar technologies</h2>
    <p>Cookies are small text files stored on your device. We and our partners use cookies and similar technologies for the following purposes:</p>
    <ul>
        <li><strong>Essential cookies:</strong> needed for core functions such as security, form protection (CSRF tokens), login sessions and remembering your language or dark-mode preference.</li>
        <li><strong>Analytics cookies:</strong> we use Google Analytics to understand how visitors use the Site. Google Analytics collects information such as pages visited and approximate location, and uses cookies to distinguish visitors.</li>
        <li><strong>Advertising cookies:</strong> used by advertising partners to show and measure ads (see the next section).</li>
    </ul>
    <p>You can control cookies through your browser settings, including blocking or deleting them. Blocking some cookies may affect how parts of the Site work. To opt out of Google Analytics, you can install the <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener">Google Analytics Opt-out Browser Add-on</a>. Learn more about how Google uses data at <a href="https://policies.google.com/technologies/partner-sites" target="_blank" rel="noopener">policies.google.com/technologies/partner-sites</a>.</p>

    <h2 id="advertising">5. Advertising and third-party vendors</h2>
    <p>We may display advertisements on the Site through third-party advertising services, including Google AdSense. Third-party vendors, including Google, use cookies to serve ads based on your prior visits to this Site and other websites.</p>
    <ul>
        <li>Google's use of advertising cookies enables it and its partners to serve ads to you based on your visit to this Site and/or other sites on the internet.</li>
        <li>You can opt out of personalised advertising by visiting <a href="https://adssettings.google.com" target="_blank" rel="noopener">Google Ads Settings</a>.</li>
        <li>You can also opt out of some third-party vendors' use of cookies for personalised advertising at <a href="https://www.aboutads.info" target="_blank" rel="noopener">aboutads.info</a> or, for European users, <a href="https://www.youronlinechoices.com" target="_blank" rel="noopener">youronlinechoices.com</a>.</li>
    </ul>
    <p>Advertising partners may collect information such as your IP address, device identifiers and browsing activity under their own privacy policies, which we do not control.</p>

    <h2 id="sharing">6. Who we share data with</h2>
    <p>We do <strong>not</strong> sell your personal information for money. We share data only where necessary with:</p>
    <ul>
        <li><strong>Service providers</strong> that help us run the Site, such as hosting, email delivery, security and analytics providers, who may process data only on our instructions.</li>
        <li><strong>Advertising and analytics partners</strong> such as Google, as described above.</li>
        <li><strong>Authorities or advisers</strong> where required by law, court order or to protect our rights, users or the public.</li>
        <li><strong>A successor</strong> in the event of a merger, acquisition or sale of assets, subject to this policy.</li>
    </ul>

    <h2 id="retention">7. How long we keep data</h2>
    <p>We keep personal data only as long as needed for the purposes above. Contact messages are generally kept for as long as needed to resolve your request; newsletter details until you unsubscribe; comments until they are removed; and account data until you delete your account. Analytics data is retained according to our analytics settings. We may keep some information longer where the law requires or to resolve disputes.</p>

    <h2 id="security">8. Security</h2>
    <p>We use reasonable technical and organisational measures to protect your data, including encrypted connections (HTTPS), hashed passwords and access controls. However, no method of transmission or storage is completely secure, so we cannot guarantee absolute security.</p>

    <h2 id="your-rights">9. Your rights and choices</h2>
    <p>Depending on where you live (for example the EEA, the UK or certain US states such as California), you may have the right to:</p>
    <ul>
        <li>access the personal data we hold about you and receive a copy;</li>
        <li>correct inaccurate or incomplete data;</li>
        <li>request deletion of your data;</li>
        <li>object to or restrict certain processing, including direct marketing;</li>
        <li>withdraw consent at any time (this does not affect earlier processing);</li>
        <li>data portability where applicable;</li>
        <li>opt out of the "sale" or "sharing" of personal information for cross-context advertising, where applicable; and</li>
        <li>lodge a complaint with your local data-protection authority.</li>
    </ul>
    <p>To exercise these rights, email <a href="mailto:{{ config('site.privacy_email') }}">{{ config('site.privacy_email') }}</a> or use our <a href="{{ route('frontend.contact') }}">contact form</a> and choose "Privacy request". We may need to verify your identity before acting on a request, and we will respond within the time required by applicable law. You can unsubscribe from our newsletter at any time using the link in any email or by contacting us.</p>

    <h2 id="children">10. Children's privacy</h2>
    <p>The Site is a general-audience news website and is not directed to children under 13 (or under 16 where local law requires a higher age). We do not knowingly collect personal data from children. If you believe a child has provided us with personal data, please contact us and we will delete it.</p>

    <h2 id="transfers">11. International transfers</h2>
    <p>We and our service providers may process and store information in countries other than your own, including countries that may not have the same data-protection laws. Where required, we use appropriate safeguards for such transfers, such as standard contractual clauses.</p>

    <h2 id="links">12. Links to other websites</h2>
    <p>Our articles and pages may contain links to third-party websites. We are not responsible for the content or privacy practices of those sites and encourage you to read their policies.</p>

    <h2 id="changes">13. Changes to this policy</h2>
    <p>We may update this policy from time to time. When we do, we will change the "Last updated" date at the top of this page. If changes are significant, we will take reasonable steps to let you know, for example with a notice on the Site. Please review this page regularly.</p>

    <h2 id="contact-us">14. Contact us</h2>
    <p>Questions about this Privacy Policy or how we handle your data? Contact us at <a href="mailto:{{ config('site.privacy_email') }}">{{ config('site.privacy_email') }}</a> or through our <a href="{{ route('frontend.contact') }}">Contact page</a>.</p>
@endsection
