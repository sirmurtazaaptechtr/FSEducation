/**
 * Vanilla JS Client-side Filtering for Course Catalog
 */
export function initCourseFilters() {
    const filterForm = document.getElementById('course-filters-form');
    const coursesContainer = document.getElementById('courses-grid');
    const countDisplay = document.getElementById('course-results-count');
    const emptyState = document.getElementById('course-empty-state');

    if (!coursesContainer) return;

    const courseItems = Array.from(coursesContainer.querySelectorAll('.course-item'));
    if (!courseItems.length) return;

    const searchInput = document.getElementById('filter-search');
    const brandSelect = document.getElementById('filter-brand');
    const categorySelect = document.getElementById('filter-category');
    const centreSelect = document.getElementById('filter-centre');
    const affiliationSelect = document.getElementById('filter-affiliation');
    const resetBtn = document.getElementById('filter-reset');

    function applyFilters() {
        const query = searchInput ? searchInput.value.trim().toLowerCase() : '';
        const selectedBrand = brandSelect ? brandSelect.value : '';
        const selectedCategory = categorySelect ? categorySelect.value : '';
        const selectedCentre = centreSelect ? centreSelect.value : '';
        const selectedAffiliation = affiliationSelect ? affiliationSelect.value : '';

        let visibleCount = 0;

        courseItems.forEach((item) => {
            const itemBrand = item.dataset.brand || '';
            const itemCategory = item.dataset.category || '';
            const itemAffiliation = item.dataset.affiliation || '';
            const itemTitle = item.dataset.title || '';
            const itemCentres = (item.dataset.centres || '').split(',').filter(Boolean);

            let matches = true;

            // Brand match
            if (selectedBrand && itemBrand !== selectedBrand) {
                matches = false;
            }

            // Category match
            if (selectedCategory && itemCategory !== selectedCategory) {
                matches = false;
            }

            // Centre match
            if (selectedCentre && !itemCentres.includes(selectedCentre)) {
                matches = false;
            }

            // Affiliation match
            if (selectedAffiliation && itemAffiliation !== selectedAffiliation) {
                matches = false;
            }

            // Search query match
            if (query && !itemTitle.includes(query) && !item.textContent.toLowerCase().includes(query)) {
                matches = false;
            }

            // Toggle wrapper column visibility
            const col = item.closest('.course-col') || item;
            if (matches) {
                col.classList.remove('d-none');
                visibleCount++;
            } else {
                col.classList.add('d-none');
            }
        });

        // Update count display
        if (countDisplay) {
            countDisplay.textContent = visibleCount.toString();
        }

        // Show/hide empty state
        if (emptyState) {
            if (visibleCount === 0) {
                emptyState.classList.remove('d-none');
            } else {
                emptyState.classList.add('d-none');
            }
        }
    }

    // Attach event listeners
    if (searchInput) {
        searchInput.addEventListener('input', debounce(applyFilters, 200));
    }
    if (brandSelect) {
        brandSelect.addEventListener('change', applyFilters);
    }
    if (categorySelect) {
        categorySelect.addEventListener('change', applyFilters);
    }
    if (centreSelect) {
        centreSelect.addEventListener('change', applyFilters);
    }
    if (affiliationSelect) {
        affiliationSelect.addEventListener('change', applyFilters);
    }
    if (resetBtn) {
        resetBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (searchInput) searchInput.value = '';
            if (brandSelect) brandSelect.value = '';
            if (categorySelect) categorySelect.value = '';
            if (centreSelect) centreSelect.value = '';
            if (affiliationSelect) affiliationSelect.value = '';
            applyFilters();
        });
    }

    // Initial check (in case URL parameters pre-populated inputs)
    applyFilters();
}

function debounce(func, wait) {
    let timeout;
    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

