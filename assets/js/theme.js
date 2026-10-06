/**
 * Ember front-end interactions.
 * Vanilla JS: scroll reveals, back-to-top, reduced-motion aware.
 */
(function () {
	'use strict';

	var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	// Scroll reveal for .ember-reveal elements.
	function initReveals() {
		var items = document.querySelectorAll('.ember-reveal');
		if (!items.length) {
			return;
		}
		if (reduceMotion || !('IntersectionObserver' in window)) {
			items.forEach(function (el) { el.classList.add('ember-visible'); });
			return;
		}
		var observer = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('ember-visible');
					observer.unobserve(entry.target);
				}
			});
		}, { threshold: 0.12 });
		items.forEach(function (el) { observer.observe(el); });
	}

	// Back-to-top button.
	function initBackTop() {
		var btn = document.createElement('button');
		btn.className = 'ember-back-top';
		btn.setAttribute('aria-label', 'Back to top');
		btn.innerHTML = '&uarr;';
		document.body.appendChild(btn);

		window.addEventListener('scroll', function () {
			btn.classList.toggle('ember-show', window.scrollY > 600);
		}, { passive: true });

		btn.addEventListener('click', function () {
			window.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' });
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function () {
			initReveals();
			initBackTop();
		});
	} else {
		initReveals();
		initBackTop();
	}
})();
