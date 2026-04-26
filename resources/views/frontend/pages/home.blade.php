@extends('frontend.layouts.master')

@section('title', $page->title)
@section('meta_title', $page->meta_title)
@section('meta_description', $page->meta_description)
@section('meta_keywords', $page->meta_keywords)
@section('author', $page->author)

@section('css')

@endsection

@section('breadcrumb-items')
@endsection

@section('content')
    @include('frontend.sections.top-posts')

    <!-- Featured Slider Section -->
    @include('frontend.sections.featured-slider')

    <!-- Featured Slider Section -->
    @include('frontend.sections.hot-now')

    @include('frontend.sections.category-sections')

    @include('frontend.sections.latest-news')

    {{-- <!-- Section start -->
    <div id="latest_news" class="latest-news section panel">
        <div class="section-outer panel py-4 lg:py-6">
            <div class="container max-w-xl">
                <div class="section-inner">
                    <div class="content-wrap row child-cols-12 g-4 lg:g-6" data-uc-grid>
                        <div class="md:col-9">
                            <div class="main-wrap panel vstack gap-3 lg:gap-6">
                                <div class="block-layout grid-layout vstack gap-2 panel overflow-hidden">
                                    <div class="block-header panel pt-1 border-top">
                                        <h2
                                            class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">
                                            Latest</h2>
                                    </div>
                                    <div class="block-content">
                                        <div class="row child-cols-12 g-2 lg:g-4 sep-x">
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div class="col-auto">
                                                            <div
                                                                class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                                                                <div
                                                                    class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                        src="../assets/images/common/img-fallback.png"
                                                                        data-src="../assets/images/demo-seven/posts/img-01.jpg"
                                                                        alt="The Rise of AI-Powered Personal Assistants: How They Manage"
                                                                        data-uc-img="loading: lazy">
                                                                </div>
                                                                <a href="blog-details.html" class="position-cover"></a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150"
                                                                        href="blog-details.html">The Rise of AI-Powered
                                                                        Personal Assistants: How They Manage</a>
                                                                </h3>
                                                            </div>
                                                            <p
                                                                class="post-excrept ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-2 my-1">
                                                                Law enforcement officers have been accused of sexually
                                                                abusing children over the past two decades, a Post
                                                                investigation found. Nisi dignissim tortor sed quam sed
                                                                ipsum ut. Dolor sit amet, consectetur adipiscing elit.</p>
                                                            <div class="post-link">
                                                                <a href="blog-details.html"
                                                                    class="link fs-7 fw-bold text-uppercase text-none mt-1 pb-narrow p-0 border-bottom dark:text-white">
                                                                    <span>Read more</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div class="col-auto">
                                                            <div
                                                                class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                                                                <div
                                                                    class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                        src="../assets/images/common/img-fallback.png"
                                                                        data-src="../assets/images/demo-seven/posts/img-02.jpg"
                                                                        alt="Tech Innovations Reshaping the Retail Landscape: AI Payments"
                                                                        data-uc-img="loading: lazy">
                                                                </div>
                                                                <a href="blog-details.html" class="position-cover"></a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150"
                                                                        href="blog-details.html">Tech Innovations
                                                                        Reshaping the Retail Landscape: AI Payments</a>
                                                                </h3>
                                                            </div>
                                                            <p
                                                                class="post-excrept ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-2 my-1">
                                                                Officers have been accused of sexually abusing children over
                                                                the past two decades, a Post investigation found. Nisi
                                                                dignissim tortor sed quam sed ipsum ut. Dolor sit amet,
                                                                consectetur adipiscing elit.</p>
                                                            <div class="post-link">
                                                                <a href="blog-details.html"
                                                                    class="link fs-7 fw-bold text-uppercase text-none mt-1 pb-narrow p-0 border-bottom dark:text-white">
                                                                    <span>Read more</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div class="col-auto">
                                                            <div
                                                                class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                                                                <div
                                                                    class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                        src="../assets/images/common/img-fallback.png"
                                                                        data-src="../assets/images/demo-seven/posts/img-03.jpg"
                                                                        alt="Balancing Work and Wellness: Tech Solutions for Healthy"
                                                                        data-uc-img="loading: lazy">
                                                                </div>
                                                                <a href="blog-details.html" class="position-cover"></a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150"
                                                                        href="blog-details.html">Balancing Work and
                                                                        Wellness: Tech Solutions for Healthy</a>
                                                                </h3>
                                                            </div>
                                                            <p
                                                                class="post-excrept ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-2 my-1">
                                                                Children over the past two decades, a Post investigation
                                                                found. Nisi dignissim tortor sed quam sed ipsum ut. Dolor
                                                                sit amet, consectetur adipiscing elit.</p>
                                                            <div class="post-link">
                                                                <a href="blog-details.html"
                                                                    class="link fs-7 fw-bold text-uppercase text-none mt-1 pb-narrow p-0 border-bottom dark:text-white">
                                                                    <span>Read more</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div class="col-auto">
                                                            <div
                                                                class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                                                                <div
                                                                    class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                        src="../assets/images/common/img-fallback.png"
                                                                        data-src="../assets/images/demo-seven/posts/img-04.jpg"
                                                                        alt="The Importance of Sleep: Tips for Better Rest and Recovery"
                                                                        data-uc-img="loading: lazy">
                                                                </div>
                                                                <a href="blog-details.html" class="position-cover"></a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150"
                                                                        href="blog-details.html">The Importance of Sleep:
                                                                        Tips for Better Rest and Recovery</a>
                                                                </h3>
                                                            </div>
                                                            <p
                                                                class="post-excrept ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-2 my-1">
                                                                Post investigation found. Nisi dignissim tortor sed quam sed
                                                                ipsum ut. Dolor sit amet, consectetur adipiscing elit.</p>
                                                            <div class="post-link">
                                                                <a href="blog-details.html"
                                                                    class="link fs-7 fw-bold text-uppercase text-none mt-1 pb-narrow p-0 border-bottom dark:text-white">
                                                                    <span>Read more</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div class="col-auto">
                                                            <div
                                                                class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                                                                <div
                                                                    class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                        src="../assets/images/common/img-fallback.png"
                                                                        data-src="../assets/images/demo-seven/posts/img-05.jpg"
                                                                        alt="The Future of Sustainable Living: Driving Eco-Friendly Lifestyles"
                                                                        data-uc-img="loading: lazy">
                                                                </div>
                                                                <a href="blog-details.html" class="position-cover"></a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150"
                                                                        href="blog-details.html">The Future of Sustainable
                                                                        Living: Driving Eco-Friendly Lifestyles</a>
                                                                </h3>
                                                            </div>
                                                            <p
                                                                class="post-excrept ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-2 my-1">
                                                                Nisi dignissim tortor sed quam sed ipsum ut. Dolor sit amet,
                                                                consectetur adipiscing elit To spread the word, the company
                                                                embarked on a mass marketing drive. TV campaigns launched in
                                                                the platform’s key markets.</p>
                                                            <div class="post-link">
                                                                <a href="blog-details.html"
                                                                    class="link fs-7 fw-bold text-uppercase text-none mt-1 pb-narrow p-0 border-bottom dark:text-white">
                                                                    <span>Read more</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div class="col-auto">
                                                            <div
                                                                class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                                                                <div
                                                                    class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                        src="../assets/images/common/img-fallback.png"
                                                                        data-src="../assets/images/demo-seven/posts/img-06.jpg"
                                                                        alt="Business Agility the Digital Age: Leveraging AI and Automation"
                                                                        data-uc-img="loading: lazy">
                                                                </div>
                                                                <a href="blog-details.html" class="position-cover"></a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150"
                                                                        href="blog-details.html">Business Agility the
                                                                        Digital Age: Leveraging AI and Automation</a>
                                                                </h3>
                                                            </div>
                                                            <p
                                                                class="post-excrept ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-2 my-1">
                                                                To spread the word, the company embarked on a mass marketing
                                                                drive. TV campaigns launched in the platform’s key markets.
                                                                Nisi dignissim tortor sed quam sed ipsum ut. Dolor sit amet,
                                                                consectetur adipiscing elit.</p>
                                                            <div class="post-link">
                                                                <a href="blog-details.html"
                                                                    class="link fs-7 fw-bold text-uppercase text-none mt-1 pb-narrow p-0 border-bottom dark:text-white">
                                                                    <span>Read more</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div class="col-auto">
                                                            <div
                                                                class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                                                                <div
                                                                    class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                        src="../assets/images/common/img-fallback.png"
                                                                        data-src="../assets/images/demo-seven/posts/img-07.jpg"
                                                                        alt="The Art of Baking: From Classic Bread to Artisan Pastries"
                                                                        data-uc-img="loading: lazy">
                                                                </div>
                                                                <a href="blog-details.html" class="position-cover"></a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150"
                                                                        href="blog-details.html">The Art of Baking: From
                                                                        Classic Bread to Artisan Pastries</a>
                                                                </h3>
                                                            </div>
                                                            <p
                                                                class="post-excrept ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-2 my-1">
                                                                To spread the word, the company embarked on a mass marketing
                                                                drive. TV campaigns launched in the platform’s key markets.
                                                                Nisi dignissim tortor sed quam sed ipsum ut. Dolor sit amet,
                                                                consectetur adipiscing elit.</p>
                                                            <div class="post-link">
                                                                <a href="blog-details.html"
                                                                    class="link fs-7 fw-bold text-uppercase text-none mt-1 pb-narrow p-0 border-bottom dark:text-white">
                                                                    <span>Read more</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div class="col-auto">
                                                            <div
                                                                class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                                                                <div
                                                                    class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                        src="../assets/images/common/img-fallback.png"
                                                                        data-src="../assets/images/demo-seven/posts/img-08.jpg"
                                                                        alt="AI and Marketing: Unlocking Customer Insights"
                                                                        data-uc-img="loading: lazy">
                                                                </div>
                                                                <a href="blog-details.html" class="position-cover"></a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150"
                                                                        href="blog-details.html">AI and Marketing:
                                                                        Unlocking Customer Insights</a>
                                                                </h3>
                                                            </div>
                                                            <p
                                                                class="post-excrept ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-2 my-1">
                                                                To spread the word, the company embarked on a mass marketing
                                                                drive. TV campaigns launched in the platform’s key markets.
                                                                Nisi dignissim tortor sed quam sed ipsum ut. Dolor sit amet,
                                                                consectetur adipiscing elit.</p>
                                                            <div class="post-link">
                                                                <a href="blog-details.html"
                                                                    class="link fs-7 fw-bold text-uppercase text-none mt-1 pb-narrow p-0 border-bottom dark:text-white">
                                                                    <span>Read more</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div class="col-auto">
                                                            <div
                                                                class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                                                                <div
                                                                    class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                        src="../assets/images/common/img-fallback.png"
                                                                        data-src="../assets/images/demo-seven/posts/img-09.jpg"
                                                                        alt="Hidden Gems: Underrated Travel Destinations Around the World"
                                                                        data-uc-img="loading: lazy">
                                                                </div>
                                                                <a href="blog-details.html" class="position-cover"></a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150"
                                                                        href="blog-details.html">Hidden Gems: Underrated
                                                                        Travel Destinations Around the World</a>
                                                                </h3>
                                                            </div>
                                                            <p
                                                                class="post-excrept ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-2 my-1">
                                                                To spread the word, the company embarked on a mass marketing
                                                                drive. TV campaigns launched in the platform’s key markets.
                                                                Nisi dignissim tortor sed quam sed ipsum ut. Dolor sit amet,
                                                                consectetur adipiscing elit.</p>
                                                            <div class="post-link">
                                                                <a href="blog-details.html"
                                                                    class="link fs-7 fw-bold text-uppercase text-none mt-1 pb-narrow p-0 border-bottom dark:text-white">
                                                                    <span>Read more</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div class="col-auto">
                                                            <div
                                                                class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                                                                <div
                                                                    class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                        src="../assets/images/common/img-fallback.png"
                                                                        data-src="../assets/images/demo-seven/posts/img-10.jpg"
                                                                        alt="Eco-Tourism: Traveling Responsibly and Sustainably"
                                                                        data-uc-img="loading: lazy">
                                                                </div>
                                                                <a href="blog-details.html" class="position-cover"></a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150"
                                                                        href="blog-details.html">Eco-Tourism: Traveling
                                                                        Responsibly and Sustainably</a>
                                                                </h3>
                                                            </div>
                                                            <p
                                                                class="post-excrept ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-2 my-1">
                                                                To spread the word, the company embarked on a mass marketing
                                                                drive. TV campaigns launched in the platform’s key markets.
                                                                Nisi dignissim tortor sed quam sed ipsum ut. Dolor sit amet,
                                                                consectetur adipiscing elit.</p>
                                                            <div class="post-link">
                                                                <a href="blog-details.html"
                                                                    class="link fs-7 fw-bold text-uppercase text-none mt-1 pb-narrow p-0 border-bottom dark:text-white">
                                                                    <span>Read more</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div class="col-auto">
                                                            <div
                                                                class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                                                                <div
                                                                    class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                        src="../assets/images/common/img-fallback.png"
                                                                        data-src="../assets/images/demo-seven/posts/img-11.jpg"
                                                                        alt="Solo Travel: Some Tips and Destinations for the Adventurous Explorer"
                                                                        data-uc-img="loading: lazy">
                                                                </div>
                                                                <a href="blog-details.html" class="position-cover"></a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150"
                                                                        href="blog-details.html">Solo Travel: Some Tips
                                                                        and Destinations for the Adventurous Explorer</a>
                                                                </h3>
                                                            </div>
                                                            <p
                                                                class="post-excrept ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-2 my-1">
                                                                To spread the word, the company embarked on a mass marketing
                                                                drive. TV campaigns launched in the platform’s key markets.
                                                                Nisi dignissim tortor sed quam sed ipsum ut. Dolor sit amet,
                                                                consectetur adipiscing elit.</p>
                                                            <div class="post-link">
                                                                <a href="blog-details.html"
                                                                    class="link fs-7 fw-bold text-uppercase text-none mt-1 pb-narrow p-0 border-bottom dark:text-white">
                                                                    <span>Read more</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div class="col-auto">
                                                            <div
                                                                class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                                                                <div
                                                                    class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                        src="../assets/images/common/img-fallback.png"
                                                                        data-src="../assets/images/demo-seven/posts/img-12.jpg"
                                                                        alt="AI-Powered Financial Planning: How Algorithms Revolutionizing"
                                                                        data-uc-img="loading: lazy">
                                                                </div>
                                                                <a href="blog-details.html" class="position-cover"></a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150"
                                                                        href="blog-details.html">AI-Powered Financial
                                                                        Planning: How Algorithms Revolutionizing</a>
                                                                </h3>
                                                            </div>
                                                            <p
                                                                class="post-excrept ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-2 my-1">
                                                                To spread the word, the company embarked on a mass marketing
                                                                drive. TV campaigns launched in the platform’s key markets.
                                                                Nisi dignissim tortor sed quam sed ipsum ut. Dolor sit amet,
                                                                consectetur adipiscing elit.</p>
                                                            <div class="post-link">
                                                                <a href="blog-details.html"
                                                                    class="link fs-7 fw-bold text-uppercase text-none mt-1 pb-narrow p-0 border-bottom dark:text-white">
                                                                    <span>Read more</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="block-footer cstack lg:mt-2">
                                        <a href="#"
                                            class="animate-btn gap-0 btn btn-sm btn-alt-primary bg-transparent text-black dark:text-white border w-100">
                                            <span>Load more posts</span>
                                            <i class="icon icon-1 unicon-chevron-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="md:col-3">
                            <div class="sidebar-wrap panel vstack gap-2 pb-2"
                                data-uc-sticky="end: .content-wrap; offset: 150; media: @m;">
                                <div class="widget ad-widget vstack gap-2 text-center p-2 border">
                                    <div class="widgt-content">
                                        <a class="cstack max-w-300px mx-auto text-none"
                                            href="https://themeforest.net/user/reacthemes/portfolio" target="_blank"
                                            rel="nofollow">
                                            <img class="d-block dark:d-none"
                                                src="../assets/images/common/ad-slot-aside.jpg" alt="Ad slot">
                                            <img class="d-none dark:d-block"
                                                src="../assets/images/common/ad-slot-aside-2.jpg" alt="Ad slot">
                                        </a>
                                    </div>
                                </div>
                                <div class="widget popular-widget vstack gap-2 p-2 border">
                                    <div class="widget-title text-center">
                                        <h5 class="fs-7 ft-tertiary text-uppercase m-0">Popular now</h5>
                                    </div>
                                    <div class="widget-content">
                                        <div class="row child-cols-12 gx-4 gy-3 sep-x" data-uc-grid>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div>
                                                            <div class="hstack items-start gap-3">
                                                                <span
                                                                    class="h3 lg:h2 ft-tertiary fst-italic text-center text-primary m-0 min-w-24px">1</span>
                                                                <div
                                                                    class="post-header panel vstack justify-between gap-1">
                                                                    <h3 class="post-title h6 m-0">
                                                                        <a class="text-none hover:text-primary duration-150"
                                                                            href="blog-details.html">Virtual Reality and
                                                                            Mental Health: Exploring the Therapeutic</a>
                                                                    </h3>
                                                                    <div
                                                                        class="post-meta panel hstack justify-between fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                        <div class="meta">
                                                                            <div class="hstack gap-2">
                                                                                <div>
                                                                                    <div
                                                                                        class="post-date hstack gap-narrow">
                                                                                        <span>2mo ago</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div>
                                                                                    <a href="#post_comment"
                                                                                        class="post-comments text-none hstack gap-narrow">
                                                                                        <i
                                                                                            class="icon-narrow unicon-chat"></i>
                                                                                        <span>290</span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="actions">
                                                                            <div class="hstack gap-1"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div>
                                                            <div class="hstack items-start gap-3">
                                                                <span
                                                                    class="h3 lg:h2 ft-tertiary fst-italic text-center text-primary m-0 min-w-24px">2</span>
                                                                <div
                                                                    class="post-header panel vstack justify-between gap-1">
                                                                    <h3 class="post-title h6 m-0">
                                                                        <a class="text-none hover:text-primary duration-150"
                                                                            href="blog-details.html">The Future of
                                                                            Sustainable Living: Driving Eco-Friendly
                                                                            Lifestyles</a>
                                                                    </h3>
                                                                    <div
                                                                        class="post-meta panel hstack justify-between fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                        <div class="meta">
                                                                            <div class="hstack gap-2">
                                                                                <div>
                                                                                    <div
                                                                                        class="post-date hstack gap-narrow">
                                                                                        <span>2mo ago</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div>
                                                                                    <a href="#post_comment"
                                                                                        class="post-comments text-none hstack gap-narrow">
                                                                                        <i
                                                                                            class="icon-narrow unicon-chat"></i>
                                                                                        <span>1</span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="actions">
                                                                            <div class="hstack gap-1"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div>
                                                            <div class="hstack items-start gap-3">
                                                                <span
                                                                    class="h3 lg:h2 ft-tertiary fst-italic text-center text-primary m-0 min-w-24px">3</span>
                                                                <div
                                                                    class="post-header panel vstack justify-between gap-1">
                                                                    <h3 class="post-title h6 m-0">
                                                                        <a class="text-none hover:text-primary duration-150"
                                                                            href="blog-details.html">Smart Homes, Smarter
                                                                            Living: Exploring IoT and AI</a>
                                                                    </h3>
                                                                    <div
                                                                        class="post-meta panel hstack justify-between fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                        <div class="meta">
                                                                            <div class="hstack gap-2">
                                                                                <div>
                                                                                    <div
                                                                                        class="post-date hstack gap-narrow">
                                                                                        <span>23d ago</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div>
                                                                                    <a href="#post_comment"
                                                                                        class="post-comments text-none hstack gap-narrow">
                                                                                        <i
                                                                                            class="icon-narrow unicon-chat"></i>
                                                                                        <span>15</span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="actions">
                                                                            <div class="hstack gap-1"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div>
                                                            <div class="hstack items-start gap-3">
                                                                <span
                                                                    class="h3 lg:h2 ft-tertiary fst-italic text-center text-primary m-0 min-w-24px">4</span>
                                                                <div
                                                                    class="post-header panel vstack justify-between gap-1">
                                                                    <h3 class="post-title h6 m-0">
                                                                        <a class="text-none hover:text-primary duration-150"
                                                                            href="blog-details.html">How Businesses Are
                                                                            Adapting to E-Commerce and AI Integration</a>
                                                                    </h3>
                                                                    <div
                                                                        class="post-meta panel hstack justify-between fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                        <div class="meta">
                                                                            <div class="hstack gap-2">
                                                                                <div>
                                                                                    <div
                                                                                        class="post-date hstack gap-narrow">
                                                                                        <span>29d ago</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div>
                                                                                    <a href="#post_comment"
                                                                                        class="post-comments text-none hstack gap-narrow">
                                                                                        <i
                                                                                            class="icon-narrow unicon-chat"></i>
                                                                                        <span>20</span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="actions">
                                                                            <div class="hstack gap-1"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget social-widget vstack gap-2 text-center p-2 border">
                                    <div class="widgt-title">
                                        <h4 class="fs-7 ft-tertiary text-uppercase m-0">Follow @News5</h4>
                                    </div>
                                    <div class="widgt-content">
                                        <form class="vstack gap-1">
                                            <input
                                                class="form-control form-control-sm fs-6 fw-medium h-40px w-full bg-white dark:bg-gray-800 dark:bg-gray-800 dark:border-white dark:border-opacity-15 dark:border-opacity-15"
                                                type="email" placeholder="Your email" required="">
                                            <button class="btn btn-sm btn-primary" type="submit">Sign up</button>
                                        </form>
                                        <ul class="nav-x justify-center gap-1 mt-3">
                                            <li>
                                                <a href="#fb"
                                                    class="cstack w-32px h-32px border rounded-circle hover:text-black dark:hover:text-white hover:scale-110 transition-all duration-150"><i
                                                        class="icon icon-1 unicon-logo-facebook"></i></a>
                                            </li>
                                            <li>
                                                <a href="#x"
                                                    class="cstack w-32px h-32px border rounded-circle hover:text-black dark:hover:text-white hover:scale-110 transition-all duration-150"><i
                                                        class="icon icon-1 unicon-logo-x-filled"></i></a>
                                            </li>
                                            <li>
                                                <a href="#in"
                                                    class="cstack w-32px h-32px border rounded-circle hover:text-black dark:hover:text-white hover:scale-110 transition-all duration-150"><i
                                                        class="icon icon-1 unicon-logo-instagram"></i></a>
                                            </li>
                                            <li>
                                                <a href="#yt"
                                                    class="cstack w-32px h-32px border rounded-circle hover:text-black dark:hover:text-white hover:scale-110 transition-all duration-150"><i
                                                        class="icon icon-1 unicon-logo-youtube"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Section end --> --}}
@endsection

@section('script')

@endsection
