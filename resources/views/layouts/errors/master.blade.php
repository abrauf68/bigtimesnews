<!doctype html>

<html>

<head>
    <title>{{ \App\Helpers\Helper::getCompanyName() }} - @yield('title')</title>
    @include('frontend.layouts.meta')
    @include('frontend.layouts.css')
    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}" />
</head>

<body class="uni-body panel bg-white text-gray-900 dark:bg-black dark:text-gray-200 overflow-x-hidden">

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
                <form class="hstack gap-1 mt-4 border-bottom p-narrow dark:border-gray-700" action="{{ route('frontend.news.index') }}" method="GET">
                    <span
                        class="d-inline-flex justify-center items-center w-24px sm:w-40 h-24px sm:h-40px opacity-50"><i
                            class="unicon-search icon-3"></i></span>
                    <input type="search" name="search"
                        class="form-control-plaintext ms-1 fs-6 sm:fs-5 w-full dark:text-white"
                        placeholder="Type your keyword.." aria-label="Search" autofocus>
                </form>
            </div>
        </div>
    </div>

    <!-- Wrapper start -->
    <div id="wrapper" class="wrap overflow-x-hidden">
        @yield('content')
    </div>
    <!-- Wrapper end -->

    <!-- Core JS -->
    @include('frontend.layouts.script')
</body>

</html>
