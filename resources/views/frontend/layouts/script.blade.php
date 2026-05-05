<!-- include jquery & bootstrap js -->
<script defer src="{{ asset('front/js/libs/jquery.min.js') }}"></script>
<script defer src="{{ asset('front/js/libs/bootstrap.min.js') }}"></script>

<!-- include scripts -->
<script defer src="{{ asset('front/js/libs/anime.min.js') }}"></script>
<script defer src="{{ asset('front/js/libs/swiper-bundle.min.js') }}"></script>
<script defer src="{{ asset('front/js/libs/scrollmagic.min.js') }}"></script>
<script defer src="{{ asset('front/js/helpers/data-attr-helper.js') }}"></script>
<script defer src="{{ asset('front/js/helpers/swiper-helper.js') }}"></script>
<script defer src="{{ asset('front/js/helpers/anime-helper.js') }}"></script>
<script defer src="{{ asset('front/js/helpers/anime-helper-defined-timelines.js') }}"></script>
<script defer src="{{ asset('front/js/uikit-components-bs.js') }}"></script>

<!-- include app script -->
<script defer src="{{ asset('front/js/app.js') }}"></script>
<script defer src="{{ asset('front/js/navbar-ajax.js') }}"></script>
<script defer src="{{ asset('front/js/infinite-scroll.js') }}"></script>

<script>
    // Fix for UIkit dropdown close on second click
    document.addEventListener('DOMContentLoaded', function() {
        if (window.UIkit) {
            document.querySelectorAll('.uc-navbar-dropdown').forEach(dropdown => {
                dropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });
        }
    });
</script>

<script>
    // Schema toggle via URL
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const getSchema = urlParams.get("schema");
    if (getSchema === "dark") {
        setDarkMode(1);
    } else if (getSchema === "light") {
        setDarkMode(0);
    }
</script>

<script>
function showCustomToast(type, message) {
    let toast = document.createElement('div');

    toast.style.position = 'fixed';
    toast.style.top = '20px';
    toast.style.right = '20px';
    toast.style.maxWidth = '320px';
    toast.style.padding = '14px 16px';
    toast.style.zIndex = 9999;

    const colors = {
        success: '#2e7d32',
        error: '#c62828',
        info: '#1565c0'
    };

    const titles = {
        success: '✓ Success',
        error: '⚠ Error',
        info: 'ℹ Info'
    };

    // Style
    toast.style.background = '#f9f9f9';
    toast.style.border = '1px solid #ddd';
    toast.style.borderLeft = '5px solid ' + colors[type];
    toast.style.boxShadow = '0 4px 12px rgba(0,0,0,0.08)';
    toast.style.fontFamily = 'Georgia, serif';
    toast.style.color = '#222';
    toast.style.borderRadius = '4px';
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(20px)';

    toast.innerHTML = `
        <div style="font-size: 13px; font-weight: bold; letter-spacing: 0.5px; margin-bottom: 4px; text-transform: uppercase; color:${colors[type]}">
            ${titles[type]}
        </div>
        <div style="font-size: 14px; line-height: 1.4;">
            ${message}
        </div>
    `;

    document.body.appendChild(toast);

    // Animate in
    setTimeout(() => {
        toast.style.transition = 'all 0.3s ease';
        toast.style.opacity = '1';
        toast.style.transform = 'translateY(0)';
    }, 50);

    // Auto remove
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(10px)';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>

<script>
    @if(session('success'))
        showCustomToast('success', "{{ session('success') }}");
    @endif

    @if(session('error'))
        showCustomToast('error', "{{ session('error') }}");
    @endif

    @if(session('message'))
        showCustomToast('info', "{{ session('message') }}");
    @endif
</script>
