<!DOCTYPE html>
<html lang="zxx" dir="ltr">
    <head>
        <title>@yield('title') - {{ \App\Helpers\Helper::getCompanyName() }}</title>
        @include('frontend.layouts.meta')
        @include('frontend.layouts.css')
        @yield('css')
    </head>
    <body class="uni-body panel bg-white text-gray-900 dark:bg-black dark:text-white text-opacity-50 overflow-x-hidden">

        @include('frontend.layouts.header')

        <!-- Wrapper start -->
        <div id="wrapper" class="wrap overflow-hidden-x">
            @yield('content')
        </div>

        <!-- Wrapper end -->

        <!-- Footer start -->
        @include('frontend.layouts.footer')
        <!-- Footer end -->

        @include('frontend.layouts.script')
    </body>
</html>
