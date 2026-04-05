/**
 * Machaussure Theme - Main JavaScript
 * Matching machaussure.ma reference design
 *
 * @package Mashaussure
 * @version 3.0.0
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
     * Scroll to Top Button
     * ───────────────────────────────────────────── */
    function initScrollToTop() {
        var btn = document.getElementById('masha-scroll-top');
        if (!btn) return;

        window.addEventListener('scroll', function () {
            if (window.scrollY > 400) {
                btn.classList.add('visible');
            } else {
                btn.classList.remove('visible');
            }
        }, { passive: true });

        btn.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    /* ─────────────────────────────────────────────
     * Hero Slider (auto-play + arrows)
     * ───────────────────────────────────────────── */
    function initHeroSlider() {
        var slides = document.querySelectorAll('.masha-slide');
        var prevBtn = document.querySelector('.masha-slider-prev');
        var nextBtn = document.querySelector('.masha-slider-next');
        if (!slides.length) return;

        var current = 0;
        var total = slides.length;
        var autoInterval;

        function showSlide(index) {
            slides.forEach(function (s) { s.classList.remove('active'); });
            current = (index + total) % total;
            slides[current].classList.add('active');
        }

        function nextSlide() {
            showSlide(current + 1);
        }

        function prevSlide() {
            showSlide(current - 1);
        }

        if (nextBtn) nextBtn.addEventListener('click', function () {
            nextSlide();
            resetAutoplay();
        });

        if (prevBtn) prevBtn.addEventListener('click', function () {
            prevSlide();
            resetAutoplay();
        });

        function startAutoplay() {
            autoInterval = setInterval(nextSlide, 5000);
        }

        function resetAutoplay() {
            clearInterval(autoInterval);
            startAutoplay();
        }

        if (total > 1) {
            startAutoplay();
        }
    }

    /* ─────────────────────────────────────────────
     * Coups de Coeur Tabs
     * ───────────────────────────────────────────── */
    function initCoupsTabs() {
        document.querySelectorAll('.masha-coups-tabs').forEach(function (tabList) {
            var tabs = tabList.querySelectorAll('li');
            tabs.forEach(function (tab) {
                tab.addEventListener('click', function () {
                    tabs.forEach(function (t) { t.classList.remove('active'); });
                    tab.classList.add('active');
                });
            });
        });
    }

    /* ─────────────────────────────────────────────
     * Quantity +/- Buttons
     * ───────────────────────────────────────────── */
    function initQuantityButtons() {
        document.addEventListener('click', function(e) {
            var target = e.target;
            
            // Handle minus button
            if (target.classList.contains('masha-qty-minus')) {
                var input = target.parentElement.querySelector('.qty');
                if (input) {
                    var val = parseInt(input.value, 10) || 1;
                    var min = parseInt(input.getAttribute('min'), 10) || 1;
                    if (val > min) {
                        input.value = val - 1;
                        input.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                }
            }
            
            // Handle plus button
            if (target.classList.contains('masha-qty-plus')) {
                var input = target.parentElement.querySelector('.qty');
                if (input) {
                    var val = parseInt(input.value, 10) || 1;
                    var max = parseInt(input.getAttribute('max'), 10) || Infinity;
                    if (val < max) {
                        input.value = val + 1;
                        input.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                }
            }
        });
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
            
            if ($parent.find('.elena-swatches-wrap').length) return;

            var $wrapper = jQuery('<div class="elena-swatches-wrap"></div>');
            if (isColor) {
                $wrapper.addClass('couleur-swatches');
            } else {
                $wrapper.addClass('pointure-swatches');
            }

            $select.find('option').each(function() {
                var $opt = jQuery(this);
                if (!$opt.val()) return;

                var label = $opt.text();
                var isOutOfStock = label.toLowerCase().indexOf('out of stock') !== -1 || label.toLowerCase().indexOf('rupture') !== -1;
                var cleanLabel = label.split(' (')[0];

                var $item;
                if (isColor) {
                    // Color swatches: try to find the product image for this variation
                    $item = jQuery('<div class="elena-swatch-item elena-color-swatch" data-value="'+$opt.val()+'"><span class="swatch-label">'+cleanLabel+'</span></div>');
                } else {
                    // Size swatches: text-based
                    $item = jQuery('<div class="elena-swatch-item elena-size-swatch" data-value="'+$opt.val()+'">'+cleanLabel+'</div>');
                }
                
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

            $select.hide();
            $parent.append($wrapper);
            
            $select.on('change', function() {
                var val = jQuery(this).val();
                $wrapper.find('.elena-swatch-item').removeClass('active');
                $wrapper.find('.elena-swatch-item[data-value="'+val+'"]').addClass('active');
            });
        });
    }

    /* ─────────────────────────────────────────────
     * Product Tabs Enhancement
     * ───────────────────────────────────────────── */
    function initProductTabs() {
        var tabList = document.querySelector('.woocommerce-tabs .tabs');
        if (!tabList) return;
        
        // Add center alignment class
        tabList.classList.add('masha-tabs-centered');
    }

    /* ─────────────────────────────────────────────
     * Initialize All
     * ───────────────────────────────────────────── */
    document.addEventListener('DOMContentLoaded', function () {
        initScrollAnimations();
        initStickyHeader();
        initMobileMenu();
        initSmoothScroll();
        initScrollToTop();
        initHeroSlider();
        initCoupsTabs();
        initQuantityButtons();
        initVariationSwatches();
        initProductTabs();
    });

})();
