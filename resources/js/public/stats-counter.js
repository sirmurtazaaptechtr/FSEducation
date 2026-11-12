/**
 * Vanilla JS Stats Counter Animation using IntersectionObserver
 */
export function initStatsCounter() {
    const counterElements = document.querySelectorAll('.stat-counter');
    if (!counterElements.length) return;

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const rawValue = el.dataset.value;
                const target = parseFloat(rawValue);

                if (!isNaN(target)) {
                    animateValue(el, 0, target, 1500);
                }
                obs.unobserve(el);
            }
        });
    }, {
        threshold: 0.2
    });

    counterElements.forEach((el) => observer.observe(el));
}

function animateValue(element, start, end, duration) {
    let startTimestamp = null;
    const isInteger = Number.isInteger(end);

    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        // Easing out cubic
        const easeOut = 1 - Math.pow(1 - progress, 3);
        const current = start + (end - start) * easeOut;

        element.textContent = isInteger ? Math.floor(current).toLocaleString() : current.toFixed(1);

        if (progress < 1) {
            window.requestAnimationFrame(step);
        } else {
            element.textContent = isInteger ? end.toLocaleString() : end.toString();
        }
    };

    window.requestAnimationFrame(step);
}

