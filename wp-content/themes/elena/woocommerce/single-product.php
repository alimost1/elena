<?php
/**
 * Single product template override for Elena theme.
 *
 * @package Elena
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

do_action( 'woocommerce_before_main_content' );
?>

<?php while ( have_posts() ) : ?>
	<?php
	the_post();
	global $product;

	do_action( 'woocommerce_before_single_product' );

	if ( post_password_required() ) {
		echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		continue;
	}

	$main_image_id = $product->get_image_id();
	$gallery_ids   = $product->get_gallery_image_ids();
	$image_ids     = array_filter( array_unique( array_merge( array( $main_image_id ), $gallery_ids ) ) );
	$has_sale      = $product->is_on_sale() && $product->get_regular_price() && (float) $product->get_regular_price() > 0;
	$sale_percent  = $has_sale ? round( ( ( (float) $product->get_regular_price() - (float) $product->get_sale_price() ) / (float) $product->get_regular_price() ) * 100 ) : 0;

	// Keep theme "buy now" behavior, but avoid duplicate stock/wishlist rows.
	remove_action( 'woocommerce_before_add_to_cart_form', 'masha_show_stock_status', 10 );
	remove_action( 'woocommerce_after_add_to_cart_form', 'masha_add_extra_links', 5 );
	?>

	<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'elena-product-reference', $product ); ?>>
		<div class="elena-sp-top">
			<div class="elena-sp-gallery" aria-label="<?php esc_attr_e( 'Product gallery', 'elena' ); ?>">
				<div class="elena-sp-thumbs">
					<?php foreach ( $image_ids as $index => $image_id ) : ?>
						<?php
						$thumb_src = wp_get_attachment_image_url( $image_id, 'woocommerce_gallery_thumbnail' );
						$main_src  = wp_get_attachment_image_url( $image_id, 'woocommerce_single' );
						$full_src  = wp_get_attachment_image_url( $image_id, 'full' );
						if ( ! $thumb_src || ! $main_src ) {
							continue;
						}
						?>
						<button
							type="button"
							class="elena-sp-thumb<?php echo 0 === $index ? ' is-active' : ''; ?>"
							data-main-src="<?php echo esc_url( $main_src ); ?>"
							data-full-src="<?php echo esc_url( $full_src ? $full_src : $main_src ); ?>"
							aria-label="<?php esc_attr_e( 'Select product image', 'elena' ); ?>"
						>
							<img src="<?php echo esc_url( $thumb_src ); ?>" alt="" loading="lazy" />
						</button>
					<?php endforeach; ?>
				</div>

				<div class="elena-sp-main-image">
					<?php if ( $has_sale ) : ?>
						<span class="elena-sp-sale-badge">-<?php echo esc_html( $sale_percent ); ?>%</span>
					<?php endif; ?>
					<?php
					if ( $main_image_id ) {
						$main_src = wp_get_attachment_image_url( $main_image_id, 'woocommerce_single' );
						$full_src = wp_get_attachment_image_url( $main_image_id, 'full' );
						?>
						<a class="elena-sp-main-link" href="<?php echo esc_url( $full_src ? $full_src : $main_src ); ?>">
							<img class="elena-sp-main-img" src="<?php echo esc_url( $main_src ); ?>" alt="<?php echo esc_attr( wp_strip_all_tags( get_the_title() ) ); ?>" />
						</a>
					<?php } else { ?>
						<?php echo wc_placeholder_img( 'woocommerce_single' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php } ?>
				</div>
			</div>

			<div class="elena-sp-summary">
				<div class="elena-sp-breadcrumbs">
					<?php woocommerce_breadcrumb( array( 'delimiter' => ' / ' ) ); ?>
				</div>

				<h1 class="product_title entry-title"><?php echo esc_html( $product->get_name() ); ?></h1>

				<div class="elena-sp-price-row">
					<?php woocommerce_template_single_price(); ?>
					<?php if ( $has_sale ) : ?>
						<span class="elena-sp-discount-label">-<?php echo esc_html( $sale_percent ); ?>%</span>
					<?php endif; ?>
				</div>

				<?php if ( count( $image_ids ) > 1 ) : ?>
					<div class="elena-sp-color-swatches">
						<span class="elena-sp-option-label"><?php esc_html_e( 'Color:', 'elena' ); ?></span>
						<div class="elena-sp-swatches-wrap">
							<?php foreach ( $image_ids as $index => $image_id ) : ?>
								<?php
								$thumb_src = wp_get_attachment_image_url( $image_id, 'thumbnail' );
								$main_src  = wp_get_attachment_image_url( $image_id, 'woocommerce_single' );
								$full_src  = wp_get_attachment_image_url( $image_id, 'full' );
								if ( ! $thumb_src || ! $main_src ) {
									continue;
								}
								?>
								<button
									type="button"
									class="elena-sp-color-swatch<?php echo 0 === $index ? ' is-active' : ''; ?>"
									data-main-src="<?php echo esc_url( $main_src ); ?>"
									data-full-src="<?php echo esc_url( $full_src ? $full_src : $main_src ); ?>"
									aria-label="<?php esc_attr_e( 'Select color image', 'elena' ); ?>"
								>
									<img src="<?php echo esc_url( $thumb_src ); ?>" alt="" loading="lazy" />
								</button>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

				<div class="elena-sp-stock">
					<?php if ( $product->is_in_stock() ) : ?>
						<span class="is-in-stock">&#10003; <?php esc_html_e( 'In stock', 'elena' ); ?></span>
					<?php else : ?>
						<span class="is-out-of-stock"><?php esc_html_e( 'Out of stock', 'elena' ); ?></span>
					<?php endif; ?>
				</div>

				<?php
				// Size selector for simple products — variable products already get one from the variation form.
				$elena_simple_sizes = array();
				if ( $product->is_type( 'simple' ) ) {
					$elena_simple_sizes = apply_filters(
						'elena_single_product_sizes',
						array( '36', '37', '38', '39', '40', '41', '42', '43' ),
						$product
					);
				}
				if ( ! empty( $elena_simple_sizes ) ) :
				?>
					<div class="elena-sp-size-picker">
						<span class="elena-sp-option-label"><?php esc_html_e( 'Size:', 'elena' ); ?></span>
						<div class="elena-size-buttons" role="radiogroup" aria-label="<?php esc_attr_e( 'Select size', 'elena' ); ?>">
							<?php foreach ( $elena_simple_sizes as $size_val ) : ?>
								<button type="button" class="elena-size-btn elena-size-btn-simple" data-value="<?php echo esc_attr( $size_val ); ?>" role="radio" aria-checked="false"><?php echo esc_html( $size_val ); ?></button>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

				<div class="elena-sp-cart-wrap">
					<?php woocommerce_template_single_add_to_cart(); ?>
				</div>

				<div class="elena-sp-links">
					<a href="#" class="elena-sp-link">&#9825; <?php esc_html_e( 'Add to wishlist', 'elena' ); ?></a>
					<a href="#" class="elena-sp-link">&#128207; <?php esc_html_e( 'Size guide', 'elena' ); ?></a>
				</div>

				<div class="elena-sp-meta">
					<?php woocommerce_template_single_meta(); ?>
				</div>
			</div>
		</div>

		<div class="elena-sp-tabs-wrap">
			<?php woocommerce_output_product_data_tabs(); ?>
		</div>

		<div class="elena-sp-related-wrap">
			<h2><?php esc_html_e( 'Related products', 'elena' ); ?></h2>
			<?php woocommerce_output_related_products(); ?>
		</div>
	</div>

	<?php do_action( 'woocommerce_after_single_product' ); ?>
<?php endwhile; ?>

<?php
do_action( 'woocommerce_after_main_content' );
get_footer( 'shop' );
