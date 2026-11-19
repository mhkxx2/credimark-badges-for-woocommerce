/**
 * CrediMark Badges for WooCommerce & Reviews Auto-Init
 */
(function() {
	'use strict';

	function initTrustindexWidget() {
		var template = document.getElementById('trustindex-google-widget-html');
		var target = document.querySelector('[data-src*="loader.js?wp-widget"]');

		if (template && target && !target.querySelector('.ti-widget')) {
			var clone = template.content ? template.content.cloneNode(true) : null;
			if (clone && clone.children && clone.children.length > 0) {
				target.appendChild(clone);
			} else {
				target.innerHTML = template.innerHTML;
			}

			// Ensure Trustindex Widget CSS is attached
			var cssUrl = target.getAttribute('data-css-url');
			if (cssUrl && !document.querySelector('link[href*="trustindex-google-widget.css"]')) {
				var link = document.createElement('link');
				link.rel = 'stylesheet';
				link.href = cssUrl;
				document.head.appendChild(link);
			}
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initTrustindexWidget);
	} else {
		initTrustindexWidget();
	}

	window.addEventListener('load', initTrustindexWidget);
})();
