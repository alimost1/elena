<?php
/**
 * Shop / Category sidebar - filters (Pointure, Couleur, Prix, Categories)
 *
 * @package Mashaussure
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<aside id="masha-shop-sidebar" class="masha-shop-sidebar">
	<?php if ( is_active_sidebar( 'shop-sidebar' ) ) : ?>
		<?php dynamic_sidebar( 'shop-sidebar' ); ?>
	<?php else : ?>
		<div class="masha-widget masha-widget-categories">
			<h4 class="masha-widget-title"><?php esc_html_e( 'Catégories', 'mashaussure' ); ?></h4>
			<?php
			wp_list_categories( array(
				'taxonomy'   => 'product_cat',
				'title_li'   => '',
				'depth'      => 2,
				'hierarchical' => true,
			) );
			?>
		</div>
		<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<?php the_widget( 'WC_Widget_Layered_Nav' ); ?>
			<?php the_widget( 'WC_Widget_Price_Filter' ); ?>
		<?php endif; ?>
	<?php endif; ?>
</aside>
