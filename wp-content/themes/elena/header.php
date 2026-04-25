<?php
/**
 * Elena Theme Header – Premium fashion storefront
 * Top info bar + main header (search, logo, cart) + category nav bar.
 *
 * @package Elena
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php bloginfo( 'description' ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="elena-site elena-masha-style">

	<!-- Top bar (black): Livraison + Contact -->
	<?php if ( get_theme_mod( 'elena_announcement_show', true ) ) : ?>
	<?php
	$elena_announce_default = 'Livraison 20 DH partout au Maroc';
	$elena_announce_text    = get_theme_mod( 'elena_announcement_text', $elena_announce_default );
	if ( function_exists( 'elena_is_arabic' ) && elena_is_arabic() ) {
		$elena_announce_text = function_exists( 'elena_ar' ) ? elena_ar( $elena_announce_text ) : $elena_announce_text;
	}
	$elena_contact_label = function_exists( 'elena_ar' ) ? elena_ar( 'Contactez-Nous:' ) : __( 'Contactez-Nous:', 'elena' );
	?>
	<div class="elena-topbar">
		<div class="elena-container elena-topbar-inner">
			<span class="elena-topbar-delivery"><?php echo esc_html( $elena_announce_text ); ?></span>
			<span class="elena-topbar-contact"><?php echo esc_html( $elena_contact_label ); ?> <?php echo esc_html( get_theme_mod( 'elena_footer_email', 'contact@elena.ma' ) ); ?> | <?php echo esc_html( get_theme_mod( 'elena_footer_phone', '+212 687873820' ) ); ?></span>
		</div>
	</div>
	<?php endif; ?>

	<!-- Main header: search, logo, login, wishlist, cart -->
	<header id="elena-header" class="elena-header elena-header-light">
		<div class="elena-container elena-header-inner">
			<div class="elena-header-search">
				<?php get_search_form(); ?>
			</div>

			<div class="elena-logo">
				<?php
				$custom_logo_id = get_theme_mod( 'custom_logo' );
				if ( $custom_logo_id && wp_get_attachment_image_src( $custom_logo_id ) ) {
					the_custom_logo();
				} else {
					?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="elena-logo-text">ELENA</a>
				<?php } ?>
			</div>

			<div class="elena-header-actions">
				<div class="elena-header-lang-flags" aria-label="<?php esc_attr_e( 'Language switch', 'elena' ); ?>">
					<?php
					if ( function_exists( 'elena_render_language_switcher' ) ) {
						elena_render_language_switcher( 'desktop' );
					}
					?>
				</div>
				<div class="elena-mobile-lang-flags" aria-label="<?php esc_attr_e( 'Language switch mobile', 'elena' ); ?>">
					<?php
					if ( function_exists( 'elena_render_language_switcher' ) ) {
						elena_render_language_switcher( 'mobile' );
					}
					?>
				</div>
				<a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : '#' ); ?>" class="elena-header-link" title="<?php esc_attr_e( 'Account', 'elena' ); ?>">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
					<span class="elena-action-label"><?php esc_html_e( 'Login', 'elena' ); ?></span>
				</a>
				<a href="#" class="elena-header-link elena-wishlist-link" title="<?php esc_attr_e( 'Wishlist', 'elena' ); ?>">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
					<span class="elena-wishlist-count">0</span>
				</a>
				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="elena-cart-btn" title="<?php esc_attr_e( 'Cart', 'elena' ); ?>">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
					<span class="elena-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
					<span class="elena-cart-total-value"><?php echo WC()->cart->get_cart_total(); ?></span>
				</a>
				<?php endif; ?>
				<button class="elena-mobile-toggle" id="elena-mobile-toggle" aria-label="<?php esc_attr_e( 'Menu', 'elena' ); ?>">
					<span></span><span></span><span></span>
					<strong class="elena-menu-label"><?php esc_html_e( 'Menu', 'elena' ); ?></strong>
				</button>
			</div>
		</div>

		<!-- Category navigation bar -->
		<nav id="elena-nav" class="elena-nav elena-nav-wrap">
			<div class="elena-container">
				<?php
				$current_lang = function_exists( 'elena_current_lang_slug' ) ? elena_current_lang_slug() : '';
				$menu_location = 'primary';
				if ( $current_lang && has_nav_menu( 'primary_' . $current_lang ) ) {
					$menu_location = 'primary_' . $current_lang;
				} elseif ( 'fr' === $current_lang && has_nav_menu( 'primary_fr_fr' ) ) {
					$menu_location = 'primary_fr_fr';
				} elseif ( 'en' === $current_lang && has_nav_menu( 'primary_en_us' ) ) {
					$menu_location = 'primary_en_us';
				} elseif ( 'ar_ar' === $current_lang && has_nav_menu( 'primary_ar_ar' ) ) {
					$menu_location = 'primary_ar_ar';
				} elseif ( 'ar_ar' === $current_lang && has_nav_menu( 'primary_ar' ) ) {
					$menu_location = 'primary_ar';
				}

				$manual_menu_id = function_exists( 'elena_get_menu_id_by_lang' ) ? elena_get_menu_id_by_lang( $current_lang ) : 0;

				if ( has_nav_menu( $menu_location ) || $manual_menu_id ) {
					$menu_args = array(
						'container'      => false,
						'menu_class'     => 'elena-nav-list',
						'fallback_cb'    => false,
					);
					if ( $manual_menu_id ) {
						$menu_args['menu'] = $manual_menu_id;
					} else {
						$menu_args['theme_location'] = $menu_location;
					}
					if ( class_exists( 'Elena_Nav_Walker' ) ) {
						$menu_args['walker'] = new Elena_Nav_Walker();
					}
					wp_nav_menu(
						$menu_args
					);
				} else {
					?>
					<ul class="elena-nav-list">
						<li><a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' ) ); ?>" class="elena-nav-link"><?php esc_html_e( 'Shop', 'elena' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="elena-nav-link"><?php esc_html_e( 'Home', 'elena' ); ?></a></li>
					</ul>
				<?php } ?>
			</div>
		</nav>
	</header>

	<main id="content" class="elena-main">
