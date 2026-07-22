/*!
 * Rasamala theme - footer helpers.
 */
'use strict';

(function () {
    const readJsonTemplate = (id, fallback = null) => {
        const element = document.getElementById(id);
        if (!element) return fallback;

        const text = (element.content ? element.content.textContent : element.textContent) || '';
        if (!text.trim()) return fallback;

        try {
            return JSON.parse(text);
        } catch (error) {
            return fallback;
        }
    };

    const stripModalInert = () => {
        document.querySelectorAll('.modal[inert]').forEach((modal) => {
            modal.removeAttribute('inert');
        });
    };

    const applySearchHighlight = () => {
        const keywords = readJsonTemplate('rasamala-highlight-keywords', null);
        if (!keywords || !window.jQuery || !window.jQuery.fn || typeof window.jQuery.fn.highlight !== 'function') {
            return;
        }

        window.jQuery('.card-body > *').highlight(keywords);
    };

    if (document.readyState !== 'loading') {
        stripModalInert();
        applySearchHighlight();
    } else {
        document.addEventListener('DOMContentLoaded', () => {
            stripModalInert();
            applySearchHighlight();
        });
    }

    if (window.jQuery) {
        window.jQuery(document).on('show.bs.modal hidden.bs.modal', '.modal', (event) => {
            event.target.removeAttribute('inert');
        });
    }
}());
