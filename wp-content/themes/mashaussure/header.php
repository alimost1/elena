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

	<!-- Top bar (green): Livraison -->
	<?php if (get_theme_mod('elena_announcement_show', true)): ?>
	<div class="masha-topbar">
		<div class="elena-container masha-topbar-inner">
			<span class="masha-topbar-delivery">Livraison 20 DH partout au Maroc</span>
			<span class="masha-topbar-contact">Contactez-Nous: info@elena.com | +212 667-631578</span>
		</div>
	</div>
	<?php
endif; ?>

	<!-- Main header: hamburger+menu left, logo center, cart right -->
	<header id="elena-header" class="elena-header masha-header">
		<div class="elena-container masha-header-inner">
			<!-- Mobile: Hamburger + MENU label -->
			<div class="masha-header-left">
				<button class="elena-mobile-toggle" id="elena-mobile-toggle" aria-label="<?php esc_attr_e('Menu', 'mashaussure'); ?>">
					<span></span><span></span><span></span>
				</button>
				<span class="masha-menu-label"><?php esc_html_e('MENU', 'mashaussure'); ?></span>
			</div>

			<!-- Desktop: Search -->
			<div class="masha-header-search masha-desktop-only">
				<?php get_search_form(); ?>
			</div>

			<!-- Logo -->
			<div class="elena-logo masha-logo">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<a href="<?php echo esc_url(home_url('/')); ?>" class="elena-logo-text"><?php bloginfo( 'name' ); ?></a>
				<?php endif; ?>
			</div>

			<!-- Actions: Login, Wishlist, Cart -->
			<div class="elena-header-actions masha-header-actions">
				<a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="masha-header-link masha-desktop-only"><?php esc_html_e('Login / Register', 'mashaussure'); ?></a>
				<?php if (function_exists('YITH_WCWL')): ?>
					<a href="<?php echo esc_url(YITH_WCWL()->get_wishlist_url()); ?>" class="masha-header-link masha-wishlist masha-desktop-only" title="<?php esc_attr_e('Wishlist', 'mashaussure'); ?>">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
						<span class="masha-wishlist-count">0</span> <?php esc_html_e('items', 'mashaussure'); ?> د.م. 0,00
					</a>
				<?php
else: ?>
					<a href="#" class="masha-header-link masha-wishlist masha-desktop-only"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg> <?php esc_html_e('Wishlist', 'mashaussure'); ?></a>
				<?php
endif; ?>
				<?php if (class_exists('WooCommerce')): ?>
				<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="elena-cart-btn masha-cart" title="<?php esc_attr_e('Cart', 'mashaussure'); ?>">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
					<span class="elena-cart-count masha-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
					<span class="masha-desktop-only"> <?php esc_html_e('items', 'mashaussure'); ?> <?php echo WC()->cart->get_cart_total(); ?></span>
				</a>
				<?php
endif; ?>
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

	<!-- Mobile search bar (below header) -->
	<div class="masha-mobile-search masha-mobile-only">
		<div class="elena-container">
			<?php get_search_form(); ?>
		</div>
	</div>



	<main id="content" class="elena-main">
