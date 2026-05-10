<!--  Search modal -->
<div id="uc-search-modal" class="uc-modal-full uc-modal" data-uc-modal="overlay: true">
    <div class="uc-modal-dialog d-flex justify-center bg-white text-dark dark:bg-gray-900 dark:text-white"
        data-uc-height-viewport="">
        <button
            class="uc-modal-close-default p-0 icon-3 btn border-0 dark:text-white dark:text-opacity-50 hover:text-primary hover:rotate-90 duration-150 transition-all"
            type="button">
            <i class="unicon-close"></i>
        </button>
        <div class="panel w-100 sm:w-500px px-2 py-10">
            <h3 class="h1 text-center">Search</h3>
            <form class="hstack gap-1 mt-4 border-bottom p-narrow dark:border-gray-700"
                action="{{ route('frontend.news.index') }}" method="GET">
                <span class="d-inline-flex justify-center items-center w-24px sm:w-40 h-24px sm:h-40px opacity-50"><i
                        class="unicon-search icon-3"></i></span>
                <input type="search" name="search"
                    class="form-control-plaintext ms-1 fs-6 sm:fs-5 w-full dark:text-white"
                    placeholder="Type your keyword.." aria-label="Search" autofocus>
            </form>
        </div>
    </div>
</div>

<!--  Menu panel -->
<div id="uc-menu-panel" data-uc-offcanvas="overlay: true;">
    <div class="uc-offcanvas-bar bg-white text-dark dark:bg-gray-900 dark:text-white">
        <header class="uc-offcanvas-header hstack justify-between items-center pb-4 bg-white dark:bg-gray-900">
            <div class="uc-logo">
                <a href="{{ route('frontend.home') }}" class="h5 text-none text-gray-900 dark:text-white">
                    {{-- <img class="h-40px" src="{{ asset(\App\Helpers\Helper::getLogoLight()) }}" alt="News5" data-uc-svg> --}}
                    <img class="logo-light h-40px" src="{{ asset(\App\Helpers\Helper::getLogoLight()) }}"
                        alt="Logo Light">

                    <img class="logo-dark h-40px" src="{{ asset(\App\Helpers\Helper::getLogoDark()) }}" alt="Logo Dark"
                        style="display: none;">
                </a>
            </div>
            <button
                class="uc-offcanvas-close p-0 icon-3 btn border-0 dark:text-white dark:text-opacity-50 hover:text-primary hover:rotate-90 duration-150 transition-all"
                type="button">
                <i class="unicon-close"></i>
            </button>
        </header>

        <div class="panel">
            <form id="search-panel" action="{{ route('frontend.news.index') }}" method="GET"
                class="form-icon-group vstack gap-1 mb-3" data-uc-sticky="">
                <input type="search" name="search" class="form-control form-control-md fs-6" placeholder="Search..">
                <span class="form-icon text-gray">
                    <i class="unicon-search icon-1"></i>
                </span>
            </form>

            <!-- About Paragraph Section -->
            <div class="about-section mb-4">
                <p class="text-gray-700 dark:text-gray-300 fs-6 leading-relaxed">
                    Welcome to {{ \App\Helpers\Helper::getCompanyName() }} — your trusted source for the latest
                    headlines, trending stories, and in-depth coverage
                    on technology, business, and global affairs. We are dedicated to delivering accurate, timely, and
                    insightful
                    journalism to keep you informed and engaged with the world around you.
                </p>
            </div>

            <ul class="social-icons nav-x mt-4">
                <li>
                    <a href="#"><i class="unicon-logo-medium icon-2"></i></a>
                    <a href="#"><i class="unicon-logo-x-filled icon-2"></i></a>
                    <a href="#"><i class="unicon-logo-instagram icon-2"></i></a>
                    <a href="#"><i class="unicon-logo-pinterest icon-2"></i></a>
                </li>
            </ul>
            <div class="py-2 hstack gap-2 mt-4 bg-white dark:bg-gray-900" data-uc-sticky="position: bottom">
                <div class="vstack gap-1">
                    <div class="darkmode-trigger" data-darkmode-switch="">
                        <label class="switch">
                            <input type="checkbox">
                            <span class="slider fs-5"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--  Favorites modal -->
<div id="uc-favorites-modal" data-uc-modal="overlay: true">
    <div class="uc-modal-dialog lg:max-w-500px bg-white text-dark dark:bg-gray-800 dark:text-white rounded">
        <button
            class="uc-modal-close-default p-0 icon-3 btn border-0 dark:text-white dark:text-opacity-50 hover:text-primary hover:rotate-90 duration-150 transition-all"
            type="button">
            <i class="unicon-close"></i>
        </button>
        <div class="panel vstack justify-center items-center gap-2 text-center px-3 py-8">
            <i class="icon icon-4 unicon-bookmark mb-2 text-primary dark:text-white"></i>
            <h2 class="h4 md:h3 m-0">Saved articles</h2>
            <p class="fs-5 opacity-60">You have not yet added any article to your bookmarks!</p>
            <a href="{{ route('frontend.home') }}" class="btn btn-sm btn-primary mt-2 uc-modal-close">Browse
                articles</a>
        </div>
    </div>
</div>

<!--  Account modal -->
<div id="uc-account-modal" data-uc-modal="overlay: true">
    <div class="uc-modal-dialog lg:max-w-500px bg-white text-dark dark:bg-gray-800 dark:text-white rounded">
        <button
            class="uc-modal-close-default p-0 icon-3 btn border-0 dark:text-white dark:text-opacity-50 hover:text-primary hover:rotate-90 duration-150 transition-all"
            type="button">
            <i class="unicon-close"></i>
        </button>
        <div class="panel vstack gap-2 md:gap-4 text-center">
            <ul class="account-tabs-nav nav-x justify-center h6 py-2 border-bottom d-none"
                data-uc-switcher="animation: uc-animation-slide-bottom-small, uc-animation-slide-top-small">
                <li><a href="#">Sign in</a></li>
                <li><a href="#">Sign up</a></li>
                <li><a href="#">Reset password</a></li>
                <li><a href="#">Terms of use</a></li>
            </ul>
            <div
                class="account-tabs-content uc-switcher px-3 lg:px-4 py-4 lg:py-8 m-0 lg:mx-auto vstack justify-center items-center">
                <div class="w-100">
                    <div class="panel vstack justify-center items-center gap-2 sm:gap-4 text-center">
                        <h4 class="h5 lg:h4 m-0">Log in</h4>
                        <div class="panel vstack gap-2 w-100 sm:w-350px mx-auto">
                            <form action="{{ route('login.attempt') }}" method="POST" class="vstack gap-2">
                                @csrf
                                <input
                                    class="form-control form-control-sm h-40px w-full fs-6 bg-white dark:bg-gray-800 dark:bg-gray-800 dark:border-white dark:border-opacity-15 dark:border-opacity-15"
                                    type="text" placeholder="Your email or username" name="email_username"
                                    required>
                                <input
                                    class="form-control form-control-sm h-40px w-full fs-6 bg-white dark:bg-gray-800 dark:bg-gray-800 dark:border-white dark:border-opacity-15 dark:border-opacity-15"
                                    type="password" placeholder="Password" name="password"
                                    autocomplete="new-password" required>
                                <div class="hstack justify-between items-start text-start">
                                    <div class="form-check text-start">
                                        <input
                                            class="form-check-input rounded-0 dark:bg-gray-800 dark:bg-gray-800 dark:border-white dark:border-opacity-15 dark:border-opacity-15"
                                            type="checkbox" id="inputCheckRemember">
                                        <label class="hstack justify-between form-check-label fs-7 sm:fs-6"
                                            for="inputCheckRemember">Remember me?</label>
                                    </div>
                                    {{-- <a href="#" class="uc-link fs-6" data-uc-switcher-item="2">Forgot
                                        password</a> --}}
                                </div>
                                <button class="btn btn-primary btn-sm lg:mt-1" type="submit">Log in</button>
                            </form>
                            {{-- <div class="panel h-24px">
                                <hr class="position-absolute top-50 start-50 translate-middle hr m-0 w-100">
                                <span
                                    class="position-absolute top-50 start-50 translate-middle px-1 fs-7 text-uppercase bg-white dark:bg-gray-800">Or</span>
                            </div>
                            <div class="hstack gap-2">
                                <a href="#google"
                                    class="hstack items-center justify-center flex-1 gap-1 h-40px text-none rounded border border-gray-900 dark:bg-gray-800 dark:border-white dark:border-opacity-15 border-opacity-10">
                                    <i class="icon icon-1 unicon-logo-google"></i>
                                </a>
                                <a href="#facebook"
                                    class="hstack items-center justify-center flex-1 gap-1 h-40px text-none rounded border border-gray-900 dark:bg-gray-800 dark:border-white dark:border-opacity-15 border-opacity-10">
                                    <i class="icon icon-1 unicon-logo-facebook"></i>
                                </a>
                                <a href="#twitter"
                                    class="hstack items-center justify-center flex-1 gap-1 h-40px text-none rounded border border-gray-900 dark:bg-gray-800 dark:border-white dark:border-opacity-15 border-opacity-10">
                                    <i class="icon icon-1 unicon-logo-x-filled"></i>
                                </a>
                            </div> --}}
                        </div>
                        <p class="fs-7 sm:fs-6">Have no account yet? <a class="uc-link" href="#"
                                data-uc-switcher-item="1">Sign up</a></p>
                    </div>
                </div>
                <div class="w-100">
                    <div class="panel vstack justify-center items-center gap-2 sm:gap-4 text-center">
                        <h4 class="h5 lg:h4 m-0">Create an account</h4>
                        <div class="panel vstack gap-2 w-100 sm:w-350px mx-auto">
                            <form action="{{ route('register.attempt') }}" method="POST" class="vstack gap-2">
                                @csrf
                                <input
                                    class="form-control form-control-sm h-40px w-full fs-6 bg-white dark:bg-gray-800 dark:border-white dark:border-opacity-15"
                                    type="text" placeholder="Full name" name="name" required>
                                <input
                                    class="form-control form-control-sm h-40px w-full fs-6 bg-white dark:bg-gray-800 dark:border-white dark:border-opacity-15"
                                    type="email" placeholder="Your email" name="email" required>
                                <input
                                    class="form-control form-control-sm h-40px w-full fs-6 bg-white dark:bg-gray-800 dark:border-white dark:border-opacity-15"
                                    type="password" placeholder="Password" name="password"
                                    autocomplete="new-password" required>
                                <input
                                    class="form-control form-control-sm h-40px w-full fs-6 bg-white dark:bg-gray-800 dark:border-white dark:border-opacity-15"
                                    type="password" placeholder="Re-enter Password" name="password_confirmation"
                                    autocomplete="new-password" required>
                                <div class="hstack text-start">
                                    <div class="form-check text-start">
                                        <input id="input_checkbox_accept_terms" name="terms"
                                            class="form-check-input rounded-0 dark:bg-gray-800 dark:border-white dark:border-opacity-15"
                                            type="checkbox" required>
                                        <label for="input_checkbox_accept_terms"
                                            class="hstack justify-between form-check-label fs-7 sm:fs-6">I read and
                                            accept the <a href="#" class="uc-link ms-narrow"
                                                data-uc-switcher-item="3">terms of use</a>. </label>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-sm lg:mt-1" type="submit">Sign up</button>
                            </form>
                            {{-- <div class="panel h-24px">
                                <hr class="position-absolute top-50 start-50 translate-middle hr m-0 w-100">
                                <span
                                    class="position-absolute top-50 start-50 translate-middle px-1 fs-7 text-uppercase bg-white dark:bg-gray-800">Or</span>
                            </div>
                            <div class="hstack gap-2">
                                <a href="#google"
                                    class="hstack items-center justify-center flex-1 gap-1 h-40px text-none rounded border border-gray-900 dark:bg-gray-800 dark:border-white dark:border-opacity-15 border-opacity-10">
                                    <i class="icon icon-1 unicon-logo-google"></i>
                                </a>
                                <a href="#facebook"
                                    class="hstack items-center justify-center flex-1 gap-1 h-40px text-none rounded border border-gray-900 dark:bg-gray-800 dark:border-white dark:border-opacity-15 border-opacity-10">
                                    <i class="icon icon-1 unicon-logo-facebook"></i>
                                </a>
                                <a href="#twitter"
                                    class="hstack items-center justify-center flex-1 gap-1 h-40px text-none rounded border border-gray-900 dark:bg-gray-800 dark:border-white dark:border-opacity-15 border-opacity-10">
                                    <i class="icon icon-1 unicon-logo-x-filled"></i>
                                </a>
                            </div> --}}
                        </div>
                        <p class="fs-7 sm:fs-6">Already have an account? <a class="uc-link" href="#"
                                data-uc-switcher-item="0">Log in</a></p>
                    </div>
                </div>
                <div class="w-100">
                    <div class="panel vstack justify-center items-center gap-2 sm:gap-4 text-center">
                        <h4 class="h5 lg:h4 m-0">Reset password</h4>
                        <div class="panel w-100 sm:w-350px">
                            <form class="vstack gap-2">
                                <input
                                    class="form-control form-control-sm h-40px w-full fs-6 bg-white dark:bg-gray-800 dark:border-white dark:border-opacity-15"
                                    type="email" placeholder="Your email" required>
                                <div class="form-check text-start">
                                    <input
                                        class="form-check-input rounded-0 dark:bg-gray-800 dark:border-white dark:border-opacity-15"
                                        type="checkbox" id="inputCheckVerify" required>
                                    <label class="form-check-label fs-7 sm:fs-6" for="inputCheckVerify"> <span>I'm not
                                            a robot</span>. </label>
                                </div>
                                <button class="btn btn-primary btn-sm lg:mt-1" type="submit">Reset a
                                    password</button>
                            </form>
                        </div>
                        <p class="fs-7 sm:fs-6 mt-2 sm:m-0">Remember your password? <a class="uc-link" href="#"
                                data-uc-switcher-item="0">Log in</a></p>
                    </div>
                </div>
                <div class="w-100">
                    <div class="panel vstack justify-center items-center gap-2 sm:gap-4">
                        <h4 class="h5 lg:h4 m-0">Terms of Use</h4>

                        <div class="page-content panel fs-6 text-start max-h-400px overflow-scroll">

                            <p>
                                Welcome to <strong>BigTimesNews.com</strong>. By accessing and using our website,
                                you agree to comply with and be bound by these Terms of Use. These terms govern
                                your use of our digital news platform, including all content, articles, features,
                                services, newsletters, media, and updates provided by Big Times News.
                            </p>

                            <p>
                                If you do not agree with any part of these terms, please discontinue using
                                BigTimesNews.com immediately. Your continued use of the website signifies your
                                acceptance of these legally binding terms and conditions.
                            </p>

                            <h5 class="h6 md:h5 mt-3 mb-1">Use of Website</h5>

                            <p>
                                BigTimesNews.com provides breaking news, business news, politics, entertainment,
                                sports, technology updates, lifestyle articles, opinions, and other informational
                                content for educational and informational purposes only.
                            </p>

                            <p>
                                Users agree to use the website lawfully and ethically. You may not misuse,
                                disrupt, hack, damage, copy, reproduce, or exploit any part of the website or
                                its services without prior written permission from Big Times News.
                            </p>

                            <h5 class="h6 md:h5 mt-3 mb-1">Intellectual Property Rights</h5>

                            <p>
                                All content published on BigTimesNews.com, including articles, logos, graphics,
                                images, videos, website design, branding, and text content, is the intellectual
                                property of Big Times News unless otherwise stated.
                            </p>

                            <p>
                                Unauthorized reproduction, redistribution, modification, republication, or
                                commercial use of our content is strictly prohibited and may result in legal
                                action under applicable copyright and intellectual property laws.
                            </p>

                            <h5 class="h6 md:h5 mt-3 mb-1">User Content & Comments</h5>

                            <p>
                                Users may have opportunities to submit comments, feedback, opinions, or other
                                content on BigTimesNews.com. By submitting content, you grant us a non-exclusive,
                                royalty-free, worldwide license to use, display, reproduce, and distribute such
                                content on our platform.
                            </p>

                            <p>
                                You agree not to post unlawful, abusive, defamatory, hateful, misleading,
                                spammy, or offensive material. Big Times News reserves the right to remove
                                comments or user-generated content at its sole discretion without prior notice.
                            </p>

                            <h5 class="h6 md:h5 mt-3 mb-1">News Accuracy Disclaimer</h5>

                            <p>
                                While BigTimesNews.com strives to provide accurate, timely, and reliable news
                                coverage, we do not guarantee the completeness, accuracy, or reliability of any
                                information published on the website.
                            </p>

                            <p>
                                News articles, opinions, and reports may change over time. Readers are encouraged
                                to independently verify important information before relying on it for personal,
                                legal, financial, medical, or professional decisions.
                            </p>

                            <h5 class="h6 md:h5 mt-3 mb-1">Third-Party Links</h5>

                            <p>
                                BigTimesNews.com may contain links to third-party websites, advertisers,
                                affiliate partners, or external services for user convenience and informational
                                purposes.
                            </p>

                            <p>
                                We are not responsible for the content, policies, practices, accuracy, or
                                availability of third-party websites. Visiting external links is done entirely
                                at your own risk.
                            </p>

                            <h5 class="h6 md:h5 mt-3 mb-1">Advertising & Sponsored Content</h5>

                            <p>
                                Our website may display advertisements, sponsored articles, affiliate links,
                                promotional content, and branded partnerships. Sponsored or paid content may be
                                clearly identified where applicable.
                            </p>

                            <p>
                                Big Times News is not responsible for products, services, offers, or claims made
                                by advertisers or third-party sponsors appearing on the website.
                            </p>

                            <h5 class="h6 md:h5 mt-3 mb-1">Privacy & Data Collection</h5>

                            <p>
                                By using BigTimesNews.com, you acknowledge that we may collect certain user data,
                                cookies, analytics information, and usage statistics to improve website
                                performance and user experience.
                            </p>

                            <p>
                                Please review our Privacy Policy to understand how your personal information is
                                collected, stored, and protected.
                            </p>

                            <h5 class="h6 md:h5 mt-3 mb-1">Limitation of Liability</h5>

                            <p>
                                Big Times News, its owners, employees, affiliates, writers, and partners shall
                                not be held liable for any direct, indirect, incidental, consequential, or
                                special damages arising from your use of or inability to use the website.
                            </p>

                            <p>
                                This includes but is not limited to loss of data, business interruption,
                                misinformation, technical issues, viruses, or financial losses resulting from the
                                use of our content or services.
                            </p>

                            <h5 class="h6 md:h5 mt-3 mb-1">Termination of Access</h5>

                            <p>
                                We reserve the right to suspend, restrict, or terminate access to BigTimesNews.com
                                for users who violate these Terms of Use or engage in harmful, illegal, or abusive
                                activities on the platform.
                            </p>

                            <h5 class="h6 md:h5 mt-3 mb-1">Changes to Terms</h5>

                            <p>
                                Big Times News may update or modify these Terms of Use at any time without prior
                                notice. Changes become effective immediately upon publication on this page.
                            </p>

                            <p>
                                Users are encouraged to review this page regularly to stay informed about updated
                                terms and conditions.
                            </p>

                            <h5 class="h6 md:h5 mt-3 mb-1">Governing Law</h5>

                            <p>
                                These Terms of Use shall be governed and interpreted in accordance with applicable
                                laws and regulations. Any disputes arising from the use of BigTimesNews.com shall
                                be subject to the jurisdiction of the appropriate courts.
                            </p>

                            <h5 class="h6 md:h5 mt-3 mb-1">Contact Information</h5>

                            <p>
                                If you have questions regarding these Terms of Use, copyright concerns, or legal
                                matters, please contact Big Times News through our official contact page or email
                                support available on BigTimesNews.com.
                            </p>

                        </div>

                        <p class="fs-7 sm:fs-6">
                            By using BigTimesNews.com, you acknowledge that you have read, understood,
                            and agreed to these Terms of Use.
                        </p>
                        <p class="fs-7 sm:fs-6">
                            Do you agree to our terms?
                            <a class="uc-link" href="#" data-uc-switcher-item="1">Sign up</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--  GDPR modal -->
<div id="uc-gdpr-notification" class="uc-gdpr-notification uc-notification uc-notification-bottom-left lg:m-2">
    <div class="uc-notification-message">
        <a id="uc-close-gdpr-notification" class="uc-notification-close" data-uc-close></a>
        <h2 class="h5 ft-primary fw-bold -ls-1 m-0">GDPR Compliance</h2>
        <p class="fs-7 mt-1 mb-2">We use cookies to ensure you get the best experience on our website. By continuing to
            use our site, you accept our use of cookies, <a href="page-privacy.html"
                class="uc-link text-underline">Privacy Policy</a>, and <a href="page-terms.html"
                class="uc-link text-underline">Terms of Service</a>.</p>
        <button class="btn btn-sm btn-primary" id="uc-accept-gdpr">Accept</button>
    </div>
</div>

<!--  Bottom Actions Sticky -->
<div class="backtotop-wrap position-fixed bottom-0 end-0 z-99 m-2 vstack">
    <div class="darkmode-trigger cstack w-40px h-40px rounded-circle text-none bg-gray-100 dark:bg-gray-700 dark:text-white"
        data-darkmode-toggle="">
        <label class="switch">
            <span class="sr-only">Dark mode toggle</span>
            <input type="checkbox">
            <span class="slider fs-5"></span>
        </label>
    </div>
    <a class="btn btn-sm bg-primary text-white w-40px h-40px rounded-circle" href="to_top" data-uc-backtotop>
        <i class="icon-2 unicon-chevron-up"></i>
    </a>
</div>

<!-- Header start -->
<header class="uc-header header-seven uc-navbar-sticky-wrap z-999">
    <nav class="uc-navbar-container text-gray-900 dark:text-white fs-6 z-1">
        <div class="uc-top-navbar panel z-3 overflow-hidden bg-primary-600 swiper-parent"
            style="--uc-nav-height: 32px" data-uc-navbar=" animation: uc-animation-slide-top-small; duration: 150;">
            <div class="container container-full">
                <div class="uc-navbar-item">
                    <div class="swiper swiper-ticker swiper-ticker-sep px-2" style="--uc-ticker-gap: 32px"
                        data-uc-swiper="items: auto; gap: 32; center: true; center-bounds: true; autoplay: 10000; speed: 10000; autoplay-delay: 0.1; loop: true; allowTouchMove: true; freeMode: true; autoplay-disableOnInteraction: true;">
                        <div class="swiper-wrapper">
                            @foreach ($tickerPosts as $post)
                                <div class="swiper-slide text-white">
                                    <div class="type-post post panel">
                                        <a href="{{ route('frontend.news.show', ['category' => $post->category->slug, 'post' => $post->slug]) }}"
                                            class="fs-7 fw-normal text-none text-inherit">
                                            {{ $post->title }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="uc-center-navbar panel hstack z-2 min-h-48px d-none lg:d-flex"
            data-uc-navbar=" animation: uc-animation-slide-top-small; duration: 150;">
            <div class="container max-w-xl">
                <div class="navbar-container hstack border-bottom">
                    <div class="uc-navbar-center gap-2 lg:gap-3 flex-1">
                        <ul class="uc-navbar-nav gap-3 justify-between flex-1 fs-6 fw-bold"
                            style="--uc-nav-height: 48px">

                            <!-- Latest Dropdown (WITH sidebar) -->
                            <li class="navbar-dropdown-item" data-dropdown-type="latest">
                                <a href="#">Latest <span data-uc-navbar-parent-icon></span></a>
                                <div class="uc-navbar-dropdown ft-primary text-unset p-3 pb-4 rounded-0 hide-scrollbar"
                                    data-uc-drop="offset: 0; boundary: !.navbar-container; stretch: x; animation: uc-animation-slide-top-small; duration: 150;">
                                    <div class="dropdown-content">
                                        @include('frontend.components.dropdown-skeleton')
                                    </div>
                                </div>
                            </li>

                            <!-- Other Categories Dropdowns (WITHOUT sidebar - Simple grid) -->
                            @foreach ($navbarCategories as $category)
                                <li class="navbar-dropdown-item" data-dropdown-type="category"
                                    data-category-slug="{{ $category->slug }}">
                                    <a href="#">{{ $category->name }} <span
                                            data-uc-navbar-parent-icon></span></a>
                                    <div class="uc-navbar-dropdown ft-primary text-unset p-3 pb-4 rounded-0 hide-scrollbar"
                                        data-uc-drop="offset: 0; boundary: !.navbar-container; stretch: x; animation: uc-animation-slide-top-small; duration: 150;">
                                        <div class="dropdown-content">
                                            <div class="skeleton-wrapper">
                                                <div class="row child-cols g-3">
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        <div class="col-6 col-md-3">
                                                            <div class="skeleton-card"
                                                                style="background: #f0f0f0; border-radius: 8px; padding: 10px;">
                                                                <div
                                                                    style="height: 120px; background: #e0e0e0; border-radius: 6px; margin-bottom: 10px;">
                                                                </div>
                                                                <div
                                                                    style="height: 18px; background: #e0e0e0; border-radius: 4px; margin-bottom: 8px; width: 90%;">
                                                                </div>
                                                                <div
                                                                    style="height: 14px; background: #e0e0e0; border-radius: 4px; width: 60%;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="uc-bottom-navbar panel z-1">
            <div class="container max-w-xl">
                <div class="uc-navbar min-h-72px lg:min-h-80px"
                    data-uc-navbar=" animation: uc-animation-slide-top-small; duration: 150;">
                    <div class="uc-navbar-left">
                        <div>
                            <a class="uc-menu-trigger icon-2" href="#uc-menu-panel" data-uc-toggle></a>
                        </div>
                        <div class="uc-navbar-item d-none lg:d-inline-flex">
                            <a class="btn btn-xs gap-narrow ps-1 border rounded-pill fw-bold dark:text-white hover:bg-gray-25 dark:hover:bg-gray-900"
                                href="#live_now" data-uc-scroll="offset: 128">
                                <i class="icon icon-narrow unicon-dot-mark text-red" data-uc-animate="flash"></i>
                                <span>Live</span>
                            </a>
                        </div>
                        <div class="uc-logo d-block md:d-none">
                            <a href="{{ route('frontend.home') }}">
                                {{-- <img class="w-100px text-dark dark:text-white"
                                    src="{{ asset(\App\Helpers\Helper::getLogoLight()) }}" alt="News5" data-uc-svg> --}}

                                <img class="logo-light w-100px text-dark dark:text-white"
                                    src="{{ asset(\App\Helpers\Helper::getLogoLight()) }}" alt="Logo Light">

                                <img class="logo-dark w-100px text-dark dark:text-white"
                                    src="{{ asset(\App\Helpers\Helper::getLogoDark()) }}" alt="Logo Dark"
                                    style="display: none;">
                            </a>
                        </div>
                    </div>
                    <div class="uc-navbar-center">
                        <div class="uc-logo d-none md:d-block">
                            <a href="{{ route('frontend.home') }}">
                                {{-- <img class="w-150px text-dark dark:text-white"
                                    src="{{ asset(\App\Helpers\Helper::getLogoLight()) }}" alt="News5" data-uc-svg> --}}

                                <img class="logo-light w-150px text-dark dark:text-white"
                                    src="{{ asset(\App\Helpers\Helper::getLogoLight()) }}" alt="Logo Light">

                                <img class="logo-dark w-150px text-dark dark:text-white"
                                    src="{{ asset(\App\Helpers\Helper::getLogoDark()) }}" alt="Logo Dark"
                                    style="display: none;">
                            </a>
                        </div>
                    </div>
                    <div class="uc-navbar-right gap-2 lg:gap-3">
                        <div class="uc-navbar-item d-inline-flex lg:d-none">
                            <a class="btn btn-xs gap-narrow ps-1 border rounded-pill fw-bold dark:text-white hover:bg-gray-25 dark:hover:bg-gray-900"
                                href="#live_now" data-uc-scroll="offset: 128">
                                <i class="icon icon-narrow unicon-dot-mark text-red" data-uc-animate="flash"></i>
                                <span>Live</span>
                            </a>
                        </div>
                        <div class="uc-navbar-item d-none lg:d-inline-flex">
                            @if (Auth::user())
                                <a class="position-relative btn btn-sm border-0 p-0 gap-narrow duration-0 dark:text-white"
                                    href="#">
                                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=random"
                                        alt="{{ Auth::user()->name }}" class="rounded-circle"
                                        style="width: 32px; height: 32px;">
                                </a>
                            @else
                                <a class="uc-account-trigger position-relative btn btn-sm border-0 p-0 gap-narrow duration-0 dark:text-white"
                                    href="#uc-account-modal" data-uc-toggle>
                                    <i class="icon icon-2 fw-medium unicon-user-avatar"></i>
                                </a>
                            @endif
                        </div>
                        <div class="uc-navbar-item d-none lg:d-inline-flex">
                            <a class="uc-search-trigger cstack text-none text-dark dark:text-white"
                                href="#uc-search-modal" data-uc-toggle>
                                <i class="icon icon-2 fw-medium unicon-search"></i>
                            </a>
                        </div>
                        {{-- <div class="uc-navbar-item d-none lg:d-inline-flex">
                            <div class="uc-modes-trigger btn btn-xs w-32px h-32px p-0 border fw-normal rounded-circle dark:text-white hover:bg-gray-25 dark:hover:bg-gray-900"
                                data-darkmode-toggle="">
                                <label class="switch">
                                    <span class="sr-only">Dark toggle</span>
                                    <input type="checkbox">
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<!-- Header end -->
