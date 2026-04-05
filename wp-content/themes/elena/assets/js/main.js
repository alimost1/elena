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
            
            if ($parent.find('.elena-swatches-wrap').length) return;

            // Add the label below the attribute name
            var $tableRow = $select.closest('tr');
            var $labelHeader = $tableRow.find('.label label');
            var currentLabel = $labelHeader.text().trim();
            
            // Create selection text container
            var $selectionDisplay = jQuery('<div class="elena-selected-val"></div>');
            $tableRow.find('.label').append($selectionDisplay);

            var $wrapper = jQuery('<div class="elena-swatches-wrap"></div>');
            if (isColor) {
                $wrapper.addClass('couleur-swatches');
            } else {
                $wrapper.addClass('pointure-swatches');
            }

            var variationsData = $select.closest('form.variations_form').data('product_variations');

            $select.find('option').each(function() {
                var $opt = jQuery(this);
                if (!$opt.val()) return;

                var label = $opt.text();
                var isOutOfStock = label.toLowerCase().indexOf('out of stock') !== -1 || label.toLowerCase().indexOf('rupture') !== -1;
                var cleanLabel = label.split(' (')[0];

                var $item = jQuery('<div class="elena-swatch-item" data-value="'+$opt.val()+'"></div>');
                
                // If it's color, try to find an image in the variations data
                var hasImage = false;
                if (isColor && variationsData) {
                    var attrName = $select.attr('data-attribute_name');
                    var match = variationsData.find(function(v) {
                        return v.attributes[attrName] === $opt.val();
                    });
                    if (match && match.image && match.image.thumb_src) {
                        $item.append('<img src="'+match.image.thumb_src+'" alt="'+cleanLabel+'" style="width:100%; height:100%; object-fit:cover; border-radius:4px;">');
                        hasImage = true;
                    }
                }

                if (!hasImage) {
                    $item.text(cleanLabel);
                }
                
                if (isOutOfStock) {
                    $item.addClass('out-of-stock');
                    // Add the 'X' SVG for out of stock
                    $item.append('<svg class="elena-out-of-stock-x" viewBox="0 0 24 24"><line x1="2" y1="2" x2="22" y2="22" stroke="red" stroke-width="2"/><line x1="22" y1="2" x2="2" y2="22" stroke="red" stroke-width="2"/></svg>');
                }

                if ($opt.is(':selected')) {
                    $item.addClass('active');
                    $selectionDisplay.text(cleanLabel);
                }

                $item.on('click', function() {
                    if (jQuery(this).hasClass('out-of-stock')) return;
                    $select.val(jQuery(this).data('value')).trigger('change');
                    $wrapper.find('.elena-swatch-item').removeClass('active');
                    jQuery(this).addClass('active');
                    $selectionDisplay.text(cleanLabel);
                });

                $wrapper.append($item);
            });

            $select.hide();
            $parent.append($wrapper);
            
            $select.on('change', function() {
                var val = jQuery(this).val();
                var selectedText = $select.find('option:selected').text().split(' (')[0];
                $selectionDisplay.text(selectedText || '');
                $wrapper.find('.elena-swatch-item').removeClass('active');
                $wrapper.find('.elena-swatch-item[data-value="'+val+'"]').addClass('active');
            });
        });

        // Add "BUY NOW" button if not already there
        if (jQuery('form.cart .single_add_to_cart_button').length && !jQuery('.elena-buy-now-btn').length) {
            var $addToCart = jQuery('form.cart .single_add_to_cart_button');
            var $buyNow = jQuery('<button type="button" class="elena-buy-now-btn">BUY NOW</button>');
            $addToCart.after($buyNow);
            
            $buyNow.on('click', function() {
                $addToCart.trigger('click');
            });
        }

        // Add quantity buttons if not already there
        jQuery('div.quantity:not(.elena-qty-ready)').each(function() {
            var $qty = jQuery(this);
            var $input = $qty.find('input.qty');
            $qty.addClass('elena-qty-ready');
            $input.before('<button type="button" class="minus">-</button>');
            $input.after('<button type="button" class="plus">+</button>');
            
            $qty.find('.minus').on('click', function() {
                var val = parseInt($input.val()) || 1;
                if (val > 1) $input.val(val - 1).trigger('change');
            });
            
            $qty.find('.plus').on('click', function() {
                var val = parseInt($input.val()) || 1;
                $input.val(val + 1).trigger('change');
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
        initVariationSwatches();
    });

})();
