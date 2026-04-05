<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Replicated to match machaussure.ma reference design exactly.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

<?php
	// Remove default sale flash (it renders outside the gallery)
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
	// Remove default breadcrumbs from the hook (we'll place them manually in the summary)
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
	?>

	<div class="masha-product-gallery-wrap" style="position:relative;">
		<?php
		// Calculate precise percentage for sale badge
		global $product;
		if ( $product->is_on_sale() && $product->get_regular_price() && (float) $product->get_regular_price() > 0 ) {
			$percent = round( ( ( (float) $product->get_regular_price() - (float) $product->get_sale_price() ) / (float) $product->get_regular_price() ) * 100 );
			echo '<span class="onsale masha-sale-badge">-' . esc_html( $percent ) . '%</span>';
		}
		
		// Check for NEW condition
		$is_new = false;
		if ( has_term( 'new', 'product_tag', $product->get_id() ) || has_term( 'NEW', 'product_tag', $product->get_id() ) ) {
			$is_new = true;
		} elseif ( ( time() - get_the_time( 'U', $product->get_id() ) ) < ( 30 * 24 * 60 * 60 ) ) {
			$is_new = true;
		}

		if ( $is_new ) {
			echo '<span class="elena-new-badge elena-new-badge-green masha-single-new">NEW</span>';
		}

		// Output product images
		woocommerce_show_product_images();
		?>
	</div>


	<div class="summary entry-summary">
		<?php
		// ── Breadcrumbs ──
		?>
		<nav class="woocommerce-breadcrumb masha-breadcrumb">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Accueil</a>
			<span class="breadcrumb-separator">/</span>
			<?php
			$terms = wc_get_product_terms( $product->get_id(), 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) );
			if ( $terms ) {
				foreach ( $terms as $term ) {
					echo '<a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a>';
					echo '<span class="breadcrumb-separator">/</span>';
				}
			}
			?>
			<?php the_title(); ?>
		</nav>
		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		do_action( 'woocommerce_single_product_summary' );
		?>
	</div>

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
