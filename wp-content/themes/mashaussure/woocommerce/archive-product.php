<?php
/**
 * Machaussure - WooCommerce Archive / Category
 * Layout: sidebar left (filters), products grid right.
 *
 * @package Mashaussure
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="elena-shop-page elena-section masha-shop-page">
	<div class="elena-container masha-shop-layout">
		<aside class="masha-shop-sidebar-wrap">
			<?php get_sidebar( 'shop' ); ?>
		</aside>

		<div class="masha-shop-main">
			<header class="elena-shop-header">
				<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
					<h1 class="elena-page-title"><?php woocommerce_page_title(); ?></h1>
				<?php endif; ?>
				<?php do_action( 'woocommerce_archive_description' ); ?>
			</header>

			<div class="elena-shop-toolbar">
				<?php do_action( 'woocommerce_before_shop_loop' ); ?>
			</div>

			<?php
			if ( woocommerce_product_loop() ) {
				woocommerce_product_loop_start();

				if ( wc_get_loop_prop( 'total' ) ) {
					while ( have_posts() ) {
						the_post();
						do_action( 'woocommerce_shop_loop' );
						wc_get_template_part( 'content', 'product' );
					}
				}

				woocommerce_product_loop_end();
				do_action( 'woocommerce_after_shop_loop' );
			} else {
				do_action( 'woocommerce_no_products_found' );
			}
			?>
		</div>
	</div>
</div>

<?php
get_footer();
