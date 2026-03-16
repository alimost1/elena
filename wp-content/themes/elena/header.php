<?php
/**
 * Elena Theme Header – Machaussure.ma style
 * Black top bar + black main header (search, logo, cart) + white nav bar.
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
	<div class="elena-topbar">
		<div class="elena-container elena-topbar-inner">
			<span class="elena-topbar-delivery"><?php echo esc_html( get_theme_mod( 'elena_announcement_text', 'Livraison 20 DH partout au Maroc' ) ); ?></span>
			<span class="elena-topbar-contact"><?php esc_html_e( 'Contactez-Nous:', 'elena' ); ?> <?php echo esc_html( get_theme_mod( 'elena_footer_email', 'sav.machaussure@gmail.com' ) ); ?> | <?php echo esc_html( get_theme_mod( 'elena_footer_phone', '+212 687873820' ) ); ?></span>
		</div>
	</div>
	<?php endif; ?>

	<!-- Main header (black): search, logo, login, wishlist, cart -->
	<header id="elena-header" class="elena-header elena-header-dark">
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
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="elena-logo-text">MACHAUSSURE</a>
				<?php } ?>
			</div>

			<div class="elena-header-actions">
				<a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : '#' ); ?>" class="elena-header-link"><?php esc_html_e( 'Login / Register', 'elena' ); ?></a>
				<a href="#" class="elena-header-link elena-wishlist-link">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
					<span class="elena-wishlist-count">0</span> <?php esc_html_e( 'items', 'elena' ); ?> د.م. 0,00
				</a>
				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="elena-cart-btn" title="<?php esc_attr_e( 'Cart', 'elena' ); ?>">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
					<span class="elena-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span> <?php esc_html_e( 'items', 'elena' ); ?> <?php echo WC()->cart->get_cart_total(); ?>
				</a>
				<?php endif; ?>
				<button class="elena-mobile-toggle" id="elena-mobile-toggle" aria-label="<?php esc_attr_e( 'Menu', 'elena' ); ?>">
					<span></span><span></span><span></span>
				</button>
			</div>
		</div>

		<!-- Nav bar (white background, below header) -->
		<nav id="elena-nav" class="elena-nav elena-nav-wrap">
			<div class="elena-container">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'elena-nav-list',
					'walker'         => class_exists( 'Elena_Nav_Walker' ) ? new Elena_Nav_Walker() : null,
					'fallback_cb'    => function() {
						echo '<ul class="elena-nav-list">';
						echo '<li><a href="' . esc_url( home_url( '/' ) ) . '" class="elena-nav-link">' . esc_html__( 'Accueil', 'elena' ) . '</a></li>';
						if ( function_exists( 'wc_get_page_permalink' ) ) {
							echo '<li><a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '" class="elena-nav-link">' . esc_html__( 'Boutique', 'elena' ) . '</a></li>';
						}
						echo '</ul>';
					},
				) );
				?>
			</div>
		</nav>
	</header>

	<!-- Promo banner (green) -->
	<?php if ( get_theme_mod( 'elena_promo_show', true ) && ( is_front_page() || get_theme_mod( 'elena_promo_all_pages', false ) ) ) : ?>
	<?php
		$promo_url = get_theme_mod( 'elena_promo_url', '' );
		if ( ! $promo_url && function_exists( 'wc_get_page_permalink' ) ) {
			$promo_url = wc_get_page_permalink( 'shop' );
		}
		if ( ! $promo_url ) {
			$promo_url = '#';
		}
	?>
	<div class="elena-promo-banner">
		<div class="elena-container elena-promo-inner">
			<span class="elena-promo-title"><?php echo esc_html( get_theme_mod( 'elena_promo_title', 'رمضان كريم' ) ); ?></span>
			<span class="elena-promo-text"><?php echo esc_html( get_theme_mod( 'elena_promo_text', 'Nouvelle Collection' ) ); ?> <strong><?php echo esc_html( get_theme_mod( 'elena_promo_discount', '-30%' ) ); ?></strong></span>
			<a href="<?php echo esc_url( $promo_url ); ?>" class="elena-promo-btn"><?php echo esc_html( get_theme_mod( 'elena_promo_btn', 'Découvrir' ) ); ?></a>
		</div>
	</div>
	<?php endif; ?>

	<main id="content" class="elena-main">
