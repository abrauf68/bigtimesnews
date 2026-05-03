class NewInfiniteScroll {
    constructor() {
        this.loading = new Map();
        this.init();
    }

    init() {
        // Remove existing skeleton containers that will be replaced
        this.loadAllSections();
    }

    async loadAllSections() {
        const container = document.getElementById('new-category-sections-container');
        if (!container) return;

        try {
            const response = await fetch('/api/category-sections');
            const data = await response.json();

            if (data.success && data.html) {
                // Replace skeleton with actual category sections
                container.innerHTML = data.html;

                // Load first page of posts for each category
                const categoryWrappers = document.querySelectorAll('.new-category-wrapper');

                categoryWrappers.forEach(wrapper => {
                    const categorySlug = wrapper.dataset.categorySlug;
                    const categoryId = wrapper.dataset.categoryId;
                    const totalPosts = parseInt(wrapper.dataset.categoryPostsCount);

                    this.loadCategoryPosts(categorySlug, categoryId, 1);

                    // Only setup infinite scroll if category has more than 5 posts
                    if (totalPosts > 5) {
                        this.setupInfiniteScroll(wrapper, categorySlug, categoryId);
                    }
                });
            }
        } catch (error) {
            console.error('Error loading sections:', error);
        }
    }

    async loadCategoryPosts(categorySlug, categoryId, page) {
        if (this.loading.get(categorySlug)) return;

        const postsContainer = document.getElementById(`new-posts-${categoryId}`);
        const trigger = document.querySelector(`.infinite-trigger[data-category="${categorySlug}"]`);
        const seeAllBtn = document.querySelector(`.see-all-btn-${categoryId}`);

        if (!postsContainer) {
            console.error(`Posts container not found for category ${categorySlug}`);
            return;
        }

        this.loading.set(categorySlug, true);

        // Show loading trigger if this is not the first page
        if (page > 1 && trigger) {
            trigger.style.display = 'block';
        }

        try {
            const response = await fetch(`/api/category/${categorySlug}/posts-infinite?page=${page}`);
            const data = await response.json();

            if (data.success) {
                if (page === 1) {
                    // First load - replace skeleton with actual content
                    postsContainer.innerHTML = data.html;

                    // Show see all button
                    if (seeAllBtn) seeAllBtn.style.display = 'block';

                    // Initialize lazy loading for images
                    this.initLazyLoading(postsContainer);

                    // Re-initialize UIkit components if needed
                    if (window.UIkit) {
                        window.UIkit.update(postsContainer);
                    }

                } else {
                    // Append more posts to the side column only
                    this.appendMorePosts(postsContainer, data.html);
                }

                // Update trigger
                if (trigger) {
                    trigger.dataset.page = data.nextPage;
                    trigger.dataset.hasMore = data.hasMorePages;

                    // Hide trigger if no more posts
                    if (!data.hasMorePages) {
                        trigger.style.display = 'none';
                    }
                }
            }
        } catch (error) {
            console.error(`Error loading posts for ${categorySlug}:`, error);
        } finally {
            this.loading.set(categorySlug, false);
            if (trigger && page === 1) {
                trigger.style.display = 'none';
            }
        }
    }

    appendMorePosts(container, newHtml) {
        // Create temp div to parse new HTML
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = newHtml;

        // Get the new side posts from the loaded HTML
        const newSidePostsContainer = tempDiv.querySelector('.col-12.md\\:col-6.lg\\:col-5 .row.child-cols-12');

        if (newSidePostsContainer) {
            // Get existing side posts container
            const existingSideContainer = container.querySelector('.col-12.md\\:col-6.lg\\:col-5 .row.child-cols-12');

            if (existingSideContainer) {
                // Get all new post items
                const newPosts = newSidePostsContainer.children;

                // Append each new post to existing container
                for (let post of newPosts) {
                    existingSideContainer.appendChild(post.cloneNode(true));
                }
            }
        }

        // Initialize lazy loading for new images
        this.initLazyLoading(container);
    }

    initLazyLoading(container) {
        // Handle UIkit lazy loading
        const lazyImages = container.querySelectorAll('img[data-src]');
        lazyImages.forEach(img => {
            if (img.dataset.src) {
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
            }
        });

        // Re-trigger UIkit component if available
        if (window.UIkit && window.UIkit.lazyLoad) {
            window.UIkit.lazyLoad(container);
        }
    }

    setupInfiniteScroll(wrapper, categorySlug, categoryId) {
        const trigger = wrapper.querySelector(`.infinite-trigger[data-category="${categorySlug}"]`);
        if (!trigger) {
            return;
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && trigger.dataset.hasMore === 'true') {
                    const nextPage = parseInt(trigger.dataset.page);
                    this.loadCategoryPosts(categorySlug, categoryId, nextPage);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '100px'
        });

        observer.observe(trigger);
    }
}

// Start when DOM is fully loaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.newInfiniteScroll = new NewInfiniteScroll();
    });
} else {
    window.newInfiniteScroll = new NewInfiniteScroll();
}
