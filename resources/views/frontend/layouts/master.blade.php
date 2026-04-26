<!DOCTYPE html>
<html lang="zxx" dir="ltr">
    <head>
        <title>@yield('title') - {{ \App\Helpers\Helper::getCompanyName() }}</title>
        @include('frontend.layouts.meta')
        @include('frontend.layouts.css')
        @yield('css')
        <style>
            /* Sticky sidebar with proper spacing */
            @media (min-width: 768px) {
                .sidebar-wrap {
                    position: sticky;
                    top: 100px; /* Adjust based on your header height */
                    align-self: start;
                    max-height: calc(100vh - 120px);
                    overflow-y: auto;
                    scrollbar-width: thin;
                }
                
                /* Custom scrollbar for sidebar */
                .sidebar-wrap::-webkit-scrollbar {
                    width: 4px;
                }
                
                .sidebar-wrap::-webkit-scrollbar-track {
                    background: #f1f1f1;
                    border-radius: 10px;
                }
                
                .sidebar-wrap::-webkit-scrollbar-thumb {
                    background: #888;
                    border-radius: 10px;
                }
                
                .sidebar-wrap::-webkit-scrollbar-thumb:hover {
                    background: #555;
                }
            }

            /* For mobile devices - no sticky */
            @media (max-width: 767px) {
                .sidebar-wrap {
                    position: static;
                    margin-top: 30px;
                }
            }

            /* Default (Light Mode) */
            .logo-dark {
                display: none;
            }

            /* Dark Mode Active */
            .uc-dark .logo-light {
                display: none;
            }

            .uc-dark .logo-dark {
                display: block;
            }
        </style>
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
        <script>
document.addEventListener("DOMContentLoaded", function () {

    function updateLogos() {
        const isDark = document.documentElement.classList.contains("uc-dark");

        document.querySelectorAll('.logo-light').forEach(el => {
            el.style.display = isDark ? 'none' : 'block';
        });

        document.querySelectorAll('.logo-dark').forEach(el => {
            el.style.display = isDark ? 'block' : 'none';
        });
    }

    // Run on load
    updateLogos();

    // Watch for dark mode toggle
    const observer = new MutationObserver(updateLogos);
    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ["class"]
    });

});
</script>
    </body>
</html>
