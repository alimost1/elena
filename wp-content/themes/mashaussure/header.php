<?php
/**
 * Machaussure Theme Header
 * Top bar (black) + main header (white) with search, logo, nav, cart.
 *
 * @package Mashaussure
 */

if (!defined('ABSPATH')) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="elena-site masha-site">

	<!-- Top bar (black): Livraison + Contact -->
	<?php if (get_theme_mod('elena_announcement_show', true)): ?>
	<div class="masha-topbar">
		<div class="elena-container masha-topbar-inner">
			<span class="masha-topbar-delivery"><?php echo esc_html(get_theme_mod('elena_announcement_text', 'Livraison 20 DH partout au Maroc')); ?></span>
			<span class="masha-topbar-contact"><?php esc_html_e('Contactez-Nous:', 'mashaussure'); ?> <?php echo esc_html(get_theme_mod('elena_footer_email', 'info@elena.com')); ?> | <?php echo esc_html(get_theme_mod('elena_footer_phone', '+212 667-631578')); ?></span>
		</div>
	</div>
	<?php
endif; ?>

	<!-- Main header (white): search, logo, actions -->
	<header id="elena-header" class="elena-header masha-header">
		<div class="elena-container masha-header-inner">
			<!-- Search -->
			<div class="masha-header-search">
				<?php get_search_form(); ?>
			</div>

			<!-- Logo -->
			<div class="elena-logo masha-logo">
				<?php
$custom_logo_id = get_theme_mod('custom_logo');
if ($custom_logo_id && wp_get_attachment_image_src($custom_logo_id)) {
	the_custom_logo();
}
else {
?>
					<a href="<?php echo esc_url(home_url('/')); ?>" class="elena-logo-text">MACHAUSSURE</a>
				<?php
}?>
			</div>

			<!-- Actions: Login, Wishlist, Cart -->
			<div class="elena-header-actions masha-header-actions">
				<a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="masha-header-link"><?php esc_html_e('Login / Register', 'mashaussure'); ?></a>
				<?php if (function_exists('YITH_WCWL')): ?>
					<a href="<?php echo esc_url(YITH_WCWL()->get_wishlist_url()); ?>" class="masha-header-link masha-wishlist" title="<?php esc_attr_e('Wishlist', 'mashaussure'); ?>">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
						<span class="masha-wishlist-count">0</span> <?php esc_html_e('items', 'mashaussure'); ?> د.م. 0,00
					</a>
				<?php
else: ?>
					<a href="#" class="masha-header-link masha-wishlist"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg> <?php esc_html_e('Wishlist', 'mashaussure'); ?></a>
				<?php
endif; ?>
				<?php if (class_exists('WooCommerce')): ?>
				<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="elena-cart-btn masha-cart" title="<?php esc_attr_e('Cart', 'mashaussure'); ?>">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
					<span class="elena-cart-count masha-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span> <?php esc_html_e('items', 'mashaussure'); ?> <?php echo WC()->cart->get_cart_total(); ?>
				</a>
				<?php
endif; ?>
				<button class="elena-mobile-toggle" id="elena-mobile-toggle" aria-label="<?php esc_attr_e('Menu', 'mashaussure'); ?>">
					<span></span><span></span><span></span>
				</button>
			</div>
		</div>

		<!-- Primary nav (Femmes, Hommes, Enfants, etc.) -->
		<nav id="elena-nav" class="elena-nav masha-nav-wrap">
			<div class="elena-container">
				<?php
wp_nav_menu(array(
	'theme_location' => 'primary',
	'container' => false,
	'menu_class' => 'elena-nav-list masha-nav-list',
	'walker' => class_exists('Elena_Nav_Walker') ? new Elena_Nav_Walker() : null,
	'fallback_cb' => function () {
	    echo '<ul class="elena-nav-list masha-nav-list">';
	    echo '<li><a href="' . esc_url(home_url('/')) . '" class="elena-nav-link">' . esc_html__('Accueil', 'mashaussure') . '</a></li>';
	    if (function_exists('wc_get_page_permalink')) {
		    echo '<li><a href="' . esc_url(wc_get_page_permalink('shop')) . '" class="elena-nav-link">' . esc_html__('Boutique', 'mashaussure') . '</a></li>';
	    }
	    echo '</ul>';
    },
));
?>
			</div>
		</nav>
	</header>

	<!-- Promo banner (green) - optional, show on front or all pages -->
	<?php if (get_theme_mod('masha_promo_show', true) && (is_front_page() || get_theme_mod('masha_promo_all_pages', false))): ?>
	<div class="masha-promo-banner">
		<div class="elena-container masha-promo-inner">
			<span class="masha-promo-title"><?php echo esc_html(get_theme_mod('masha_promo_title', 'رمضان كريم')); ?></span>
			<span class="masha-promo-text"><?php echo esc_html(get_theme_mod('masha_promo_text', 'Nouvelle Collection')); ?> <strong><?php echo esc_html(get_theme_mod('masha_promo_discount', '-30%')); ?></strong></span>
			<?php
	$promo_url = get_theme_mod('masha_promo_url', '');
	if (!$promo_url && function_exists('wc_get_page_permalink')) {
		$promo_url = wc_get_page_permalink('shop');
	}
	if (!$promo_url) {
		$promo_url = '#';
	}
?>
<a href="<?php echo esc_url($promo_url); ?>" class="masha-promo-btn"><?php echo esc_html(get_theme_mod('masha_promo_btn', 'Découvrir')); ?></a>
		</div>
	</div>
	<?php
endif; ?>

	<main id="content" class="elena-main">
