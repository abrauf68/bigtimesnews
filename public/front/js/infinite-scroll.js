class InfiniteCategoryScroll {
    constructor() {
        this.loading = false;
        this.observers = new Map();
        this.init();
    }

    init() {
        // Initialize all category sections
        document.querySelectorAll('.category-section').forEach(section => {
            this.loadCategoryPosts(section);
            this.setupObserver(section);
        });
    }

    async loadCategoryPosts(section, page = 1) {
        const categorySlug = section.dataset.categorySlug;
        const categoryId = section.dataset.categoryId;
        const container = document.getElementById(`posts-container-${categoryId}`);
        const skeleton = document.getElementById(`skeleton-${categoryId}`);
        const trigger = section.querySelector('.infinite-scroll-trigger');

        if (this.loading) return;

        this.loading = true;

        try {
            // Show skeleton on first load
            if (page === 1) {
                skeleton.style.display = 'block';
                container.style.display = 'none';
            }

            const response = await fetch(`/api/category/${categorySlug}/infinite?page=${page}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                if (page === 1) {
                    // First load - replace content
                    container.innerHTML = data.html;
                    skeleton.style.display = 'none';
                    container.style.display = 'block';
                } else {
                    // Append more content
                    container.insertAdjacentHTML('beforeend', data.html);
                }

                // Update trigger attributes
                if (trigger) {
                    trigger.dataset.page = data.nextPage;
                    trigger.dataset.hasMore = data.hasMorePages;

                    // Remove trigger if no more pages
                    if (!data.hasMorePages) {
                        trigger.style.display = 'none';
                    }
                }

                // Reinitialize UIkit components for new images
                if (window.UIkit && window.UIkit.update) {
                    window.UIkit.update(container);
                }

                // Lazy load new images
                this.lazyLoadImages(container);
            }
        } catch (error) {
            console.error('Error loading category posts:', error);
        } finally {
            this.loading = false;
        }
    }

    setupObserver(section) {
        const trigger = section.querySelector('.infinite-scroll-trigger');
        if (!trigger) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !this.loading && trigger.dataset.hasMore === 'true') {
                    const nextPage = parseInt(trigger.dataset.page);
                    this.loadCategoryPosts(section, nextPage);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '100px' // Load when 100px before trigger becomes visible
        });

        observer.observe(trigger);
        this.observers.set(section, observer);
    }

    lazyLoadImages(container) {
        const images = container.querySelectorAll('img[data-src]');
        images.forEach(img => {
            if (img.dataset.src) {
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
            }
        });
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new InfiniteCategoryScroll();
});
