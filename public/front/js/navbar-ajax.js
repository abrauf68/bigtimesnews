class NavbarDropdownManager {
    constructor() {
        this.loadedContent = new Map();
        this.init();
    }

    init() {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.setupDropdowns());
        } else {
            this.setupDropdowns();
        }
    }

    setupDropdowns() {
        const dropdownItems = document.querySelectorAll('.navbar-dropdown-item');

        if (dropdownItems.length === 0) {
            console.warn('No dropdown items found');
            return;
        }

        dropdownItems.forEach(item => {
            let hoverTimeout;
            let hideTimeout;

            item.addEventListener('mouseenter', () => {
                clearTimeout(hideTimeout);
                hoverTimeout = setTimeout(() => {
                    this.loadDropdownContent(item);
                }, 200);
            });

            item.addEventListener('mouseleave', () => {
                clearTimeout(hoverTimeout);
                hideTimeout = setTimeout(() => {
                    const dropdown = item.querySelector('.uc-navbar-dropdown');
                    if (dropdown && window.UIkit && dropdown._drop) {
                        dropdown._drop.hide(false);
                    }
                }, 300);
            });
        });

        console.log(`Setup ${dropdownItems.length} dropdowns`);
    }

    async loadDropdownContent(item) {
        const dropdown = item.querySelector('.uc-navbar-dropdown');
        if (!dropdown) return;

        const contentDiv = dropdown.querySelector('.dropdown-content');
        if (!contentDiv) return;

        if (contentDiv.dataset.loaded === 'true') return;

        const type = item.dataset.dropdownType;

        try {
            let url = '';
            if (type === 'latest') {
                url = '/navbar/latest';
            } else if (type === 'category') {
                const slug = item.dataset.categorySlug;
                if (!slug) return;
                url = `/navbar/category/${slug}`;
            } else {
                return;
            }

            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) throw new Error(`HTTP ${response.status}`);

            const data = await response.json();

            if (data.html) {
                contentDiv.style.transition = 'opacity 0.15s ease';
                contentDiv.style.opacity = '0';

                setTimeout(() => {
                    contentDiv.innerHTML = data.html;
                    contentDiv.dataset.loaded = 'true';
                    contentDiv.style.opacity = '1';

                    if (window.UIkit) {
                        window.UIkit.update(contentDiv);
                    }

                    if (type === 'latest') {
                        this.initSwitcherWithAjax(contentDiv);
                    }
                }, 150);
            }
        } catch (error) {
            console.error('Failed to load dropdown:', error);
            contentDiv.innerHTML = `
                <div class="text-center py-5">
                    <p class="text-danger">Failed to load content</p>
                    <button class="btn btn-sm btn-primary" onclick="location.reload()">Retry</button>
                </div>
            `;
        }
    }

    initSwitcherWithAjax(container) {
        // Get the switcher element
        const switcher = container.querySelector('.uc-switcher');
        if (!switcher) return;

        // Get all tabs
        const tabs = container.querySelectorAll('.uc-tab-left li a');
        if (tabs.length === 0) return;

        // Store loaded panels
        const loadedPanels = new Map();

        // Add click event to each tab
        tabs.forEach(tab => {
            tab.addEventListener('click', async (e) => {
                const categorySlug = tab.getAttribute('data-category') ||
                                    tab.innerText.toLowerCase().replace(/\s+/g, '-');

                // Find the target panel
                const targetPanel = switcher.querySelector(`[data-panel="${categorySlug}"]`);

                if (targetPanel && !loadedPanels.has(categorySlug) && categorySlug !== 'all') {
                    // Show loading state
                    targetPanel.innerHTML = `
                        <div class="col-12 text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Loading posts...</p>
                        </div>
                    `;

                    try {
                        const response = await fetch(`/navbar/switcher/${categorySlug}`);
                        const data = await response.json();

                        if (data.html) {
                            targetPanel.innerHTML = data.html;
                            loadedPanels.set(categorySlug, true);

                            if (window.UIkit) {
                                window.UIkit.update(targetPanel);
                            }
                        }
                    } catch (error) {
                        console.error('Failed to load category posts:', error);
                        targetPanel.innerHTML = `
                            <div class="col-12 text-center py-5">
                                <p class="text-danger">Failed to load posts</p>
                                <button class="btn btn-sm btn-primary" onclick="location.reload()">Retry</button>
                            </div>
                        `;
                    }
                }
            });
        });
    }
}

// Initialize
window.NavbarDropdownManager = NavbarDropdownManager;
const navbarManager = new NavbarDropdownManager();
