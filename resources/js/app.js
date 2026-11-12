import './bootstrap';
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import { initCourseFilters } from './public/course-filters';
import { initStatsCounter } from './public/stats-counter';
import { initLightbox } from './public/lightbox';
import { initCookieConsent, initCopyButtons } from './public/cookie-consent';

// Initialize tooltips, popovers, and public interactive modules on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    // Bootstrap Tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map((tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl));

    // Bootstrap Popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map((popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl));

    // Public Modules
    initCourseFilters();
    initStatsCounter();
    initLightbox();
    initCookieConsent();
    initCopyButtons();
});
