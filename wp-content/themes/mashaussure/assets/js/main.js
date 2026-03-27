/**
 * Elena Theme - Main JavaScript
 *
 * @package Elena
 * @version 1.0.0
 */

(function () {
    'use strict';

    /* ─────────────────────────────────────────────
     * Scroll Animations (Intersection Observer)
     * ───────────────────────────────────────────── */
    function initScrollAnimations() {
        var targets = document.querySelectorAll('.elena-animate');
        if (!targets.length) return;

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('elena-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.15,
            rootMargin: '0px 0px -40px 0px'
        });

        targets.forEach(function (el) {
            observer.observe(el);
        });
    }

    /* ─────────────────────────────────────────────
     * Sticky Header
     * ───────────────────────────────────────────── */
    function initStickyHeader() {
        var header = document.getElementById('elena-header');
        if (!header) return;

        var scrollThreshold = 80;

        function handleScroll() {
            if (window.scrollY > scrollThreshold) {
                header.classList.add('elena-header-scrolled');
            } else {
                header.classList.remove('elena-header-scrolled');
            }
        }

        window.addEventListener('scroll', handleScroll, { passive: true });
        handleScroll();
    }

    /* ─────────────────────────────────────────────
     * Mobile Menu Toggle
     * ───────────────────────────────────────────── */
    function initMobileMenu() {
        var toggle = document.getElementById('elena-mobile-toggle');
        var nav = document.getElementById('elena-nav');
        if (!toggle || !nav) return;

        toggle.addEventListener('click', function () {
            var isOpen = nav.classList.toggle('elena-nav-open');
            toggle.classList.toggle('elena-toggle-active', isOpen);
            document.body.classList.toggle('elena-menu-open', isOpen);
        });

        // Close on nav link click
        nav.querySelectorAll('.elena-nav-link').forEach(function (link) {
            link.addEventListener('click', function () {
                nav.classList.remove('elena-nav-open');
                toggle.classList.remove('elena-toggle-active');
                document.body.classList.remove('elena-menu-open');
            });
        });
    }

    /* ─────────────────────────────────────────────
     * Smooth Scroll for Anchor Links
     * ───────────────────────────────────────────── */
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(function (link) {
            link.addEventListener('click', function (e) {
                var targetId = this.getAttribute('href');
                if (targetId === '#') return;

                var target = document.querySelector(targetId);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    }

    /* ─────────────────────────────────────────────
     * Parallax-lite on Hero
     * ───────────────────────────────────────────── */
    function initHeroParallax() {
        var hero = document.querySelector('.elena-hero');
        if (!hero) return;

        window.addEventListener('scroll', function () {
            var scrolled = window.scrollY;
            if (scrolled < hero.offsetHeight) {
                hero.style.backgroundPositionY = (scrolled * 0.4) + 'px';
            }
        }, { passive: true });
    }

    /* ─────────────────────────────────────────────
     * Variation Swatches (JS replacement for selects)
     * ───────────────────────────────────────────── */
    function initVariationSwatches() {
        if (typeof jQuery === 'undefined') return;

        jQuery('.variations_form select').each(function() {
            var $select = jQuery(this);
            var $parent = $select.parent();
            var attributeName = $select.attr('name') || '';
            var isColor = attributeName.toLowerCase().indexOf('color') !== -1 || attributeName.toLowerCase().indexOf('couleur') !== -1;
            
            // Check if swatches already exist
            if ($parent.find('.elena-swatches-wrap').length) return;

            var $wrapper = jQuery('<div class="elena-swatches-wrap"></div>');
            if (isColor) {
                $wrapper.addClass('couleur-swatches');
            } else {
                $wrapper.addClass('pointure-swatches');
            }

            $select.find('option').each(function() {
                var $opt = jQuery(this);
                if (!$opt.val()) return; // Skip "Choose an option"

                var label = $opt.text();
                var isOutOfStock = label.toLowerCase().indexOf('out of stock') !== -1 || label.toLowerCase().indexOf('rupture') !== -1;
                
                // Clean label from WooCommerce stock status if present
                var cleanLabel = label.split(' (')[0];

                var $item = jQuery('<div class="elena-swatch-item" data-value="'+$opt.val()+'">'+cleanLabel+'</div>');
                
                if (isOutOfStock) {
                    $item.addClass('out-of-stock');
                }

                if ($opt.is(':selected')) {
                    $item.addClass('active');
                }

                $item.on('click', function() {
                    if (jQuery(this).hasClass('out-of-stock')) return;
                    $select.val(jQuery(this).data('value')).trigger('change');
                    $wrapper.find('.elena-swatch-item').removeClass('active');
                    jQuery(this).addClass('active');
                });

                $wrapper.append($item);
            });

            // Hide the original select and add swatches
            $select.hide();
            $parent.append($wrapper);
            
            // Sync if select changes elsewhere (e.g. clear button)
            $select.on('change', function() {
                var val = jQuery(this).val();
                $wrapper.find('.elena-swatch-item').removeClass('active');
                $wrapper.find('.elena-swatch-item[data-value="'+val+'"]').addClass('active');
            });
        });
    }

    /* ─────────────────────────────────────────────
     * Initialize All
     * ───────────────────────────────────────────── */
    document.addEventListener('DOMContentLoaded', function () {
        initScrollAnimations();
        initStickyHeader();
        initMobileMenu();
        initSmoothScroll();
        initHeroParallax();
        initWooCommerceGallery();
        initVariationSwatches();
    });



})();
