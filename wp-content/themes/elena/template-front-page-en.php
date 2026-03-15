<?php
/**
 * Template Name: Front Page English
 * Elena Front Page Template
 *
 * @package Elena
 */

get_header();

// Check if Elementor has a template for this page
if ( false && function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'single' ) ) {
    // Elementor will handle this page
} else {
    // Theme default homepage
    $hero_title    = get_theme_mod( 'elena_hero_title', 'Step Into Performance' );
    $hero_subtitle = get_theme_mod( 'elena_hero_subtitle', 'Modern athletic footwear built for real performance. Lightweight materials, durable construction, and ergonomic design.' );
    $hero_image    = get_theme_mod( 'elena_hero_image', '' );
    $hero_cta_text = get_theme_mod( 'elena_hero_cta_text', 'See More' );
    $hero_cta_url  = get_theme_mod( 'elena_hero_cta_url', '#' );
    $shop_url      = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '#';
    ?>

    <!-- ═══════════ HERO SECTION ═══════════ -->
    <?php
    // Use Customizer image or fall back to bundled hero
    $hero_bg = $hero_image ? $hero_image : ELENA_URI . '/assets/images/hero-bg.png';
    ?>
    <section class="elena-hero" id="hero">
        <div class="elena-hero-image-wrap">
            <img src="<?php echo esc_url( $hero_bg ); ?>" alt="<?php echo esc_attr( $hero_title ); ?>" class="elena-hero-bg-img">
        </div>

        <!-- Centered CTA at bottom -->
        <div class="elena-hero-cta">
            <a href="<?php echo esc_url( $hero_cta_url ? $hero_cta_url : $shop_url ); ?>" class="elena-btn elena-btn-primary elena-animate">
                <?php echo esc_html( $hero_cta_text ); ?>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
    </section>

    <!-- ═══════════ COLLECTION TEXT ═══════════ -->
    <section class="elena-collection-intro elena-section" id="collection">
        <div class="elena-container">
            <div class="elena-collection-text elena-animate">
                <h2 class="elena-section-subtitle"><?php esc_html_e( 'Collection For Men', 'elena' ); ?></h2>
                <p><?php esc_html_e( 'Discover our selection of performance athletic footer. Each pair is designed to deliver maximum comfort and style for everyday wear.', 'elena' ); ?></p>
                <p><?php esc_html_e( 'Engineered with premium materials, our sneakers blend cutting-edge technology with contemporary aesthetics.', 'elena' ); ?></p>
                <p><?php esc_html_e( 'Every pair is crafted for those who demand more from their footwear — combining performance, durability, and style in equal measure.', 'elena' ); ?></p>
            </div>
        </div>
    </section>

    <!-- ═══════════ BEST SELLERS ═══════════ -->
    <section class="elena-best-sellers elena-section" id="best-sellers">
        <div class="elena-container">
            <div class="elena-section-header elena-animate">
                <h2 class="elena-section-title"><?php esc_html_e( 'Best Sellers', 'elena' ); ?></h2>
                <p class="elena-section-label"><?php esc_html_e( 'SNEAKERS COLLECTION', 'elena' ); ?></p>
            </div>

            <?php
            if ( class_exists( 'WooCommerce' ) ) {
                $args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => 4,
                    'meta_key'       => 'total_sales',
                    'orderby'        => 'meta_value_num',
                    'order'          => 'DESC',
                );
                $products = new WP_Query( $args );

                if ( $products->have_posts() ) {
                    echo '<div class="elena-products-grid elena-animate">';
                    while ( $products->have_posts() ) {
                        $products->the_post();
                        global $product;
                        ?>
                        <div class="elena-product-card">
                            <a href="<?php the_permalink(); ?>" class="elena-product-link">
                                <div class="elena-product-image">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <?php the_post_thumbnail( 'elena-product-thumb' ); ?>
                                    <?php else : ?>
                                        <div class="elena-product-placeholder">
                                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#bbb" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="elena-product-info">
                                    <h3 class="elena-product-title"><?php the_title(); ?></h3>
                                    <span class="elena-product-price"><?php echo $product->get_price_html(); ?></span>
                                </div>
                            </a>
                        </div>
                        <?php
                    }
                    echo '</div>';
                    wp_reset_postdata();
                } else {
                    // Demo placeholder cards
                    echo '<div class="elena-products-grid elena-animate">';
                    $demos = array(
                        array( 'name' => 'Air Max Pro', 'price' => '$149.99' ),
                        array( 'name' => 'Urban Runner', 'price' => '$129.99' ),
                        array( 'name' => 'Sport Flex', 'price' => '$139.99' ),
                        array( 'name' => 'Classic Elite', 'price' => '$159.99' ),
                    );
                    foreach ( $demos as $demo ) {
                        ?>
                        <div class="elena-product-card">
                            <div class="elena-product-link">
                                <div class="elena-product-image">
                                    <div class="elena-product-placeholder">
                                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#bbb" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                                    </div>
                                </div>
                                <div class="elena-product-info">
                                    <h3 class="elena-product-title"><?php echo esc_html( $demo['name'] ); ?></h3>
                                    <span class="elena-product-price"><?php echo esc_html( $demo['price'] ); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    echo '</div>';
                }
            } else {
                echo '<p class="elena-no-products">Install WooCommerce to display products here.</p>';
            }
            ?>

            <div class="elena-section-footer elena-animate">
                <a href="<?php echo esc_url( $shop_url ); ?>" class="elena-link-arrow">
                    <?php esc_html_e( 'View All Products', 'elena' ); ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- ═══════════ REVIEWS SECTION ═══════════ -->
    <section class="elena-reviews elena-section" id="reviews">
        <div class="elena-reviews-bg">
            <div class="elena-container">
                <div class="elena-reviews-content elena-animate">
                    <h2 class="elena-section-title elena-text-white"><?php esc_html_e( 'Reviews', 'elena' ); ?></h2>
                    <p class="elena-reviews-rating elena-text-white"><?php printf( esc_html__( 'Our customers consistently rate us %s', 'elena' ), '<strong>4.8 / 5</strong>' ); ?></p>

                    <div class="elena-testimonials">
                        <div class="elena-testimonial">
                            <div class="elena-stars">★★★★★</div>
                            <p class="elena-testimonial-name"><strong><?php esc_html_e( 'Amine', 'elena' ); ?></strong></p>
                            <p class="elena-testimonial-text">"<?php esc_html_e( 'The quality is outstanding. These are the best sneakers I\'ve ever owned. Comfortable, stylish, and they last. Absolutely worth every dirham.', 'elena' ); ?>"</p>
                        </div>
                        <div class="elena-testimonial">
                            <div class="elena-stars">★★★★★</div>
                            <p class="elena-testimonial-name"><strong><?php esc_html_e( 'Sara', 'elena' ); ?></strong></p>
                            <p class="elena-testimonial-text">"<?php esc_html_e( 'Got my order in just 2 days! Great quality materials and super comfortable. The customer service is incredible too — very responsive and professional.', 'elena' ); ?>"</p>
                        </div>
                    </div>

                    <a href="#" class="elena-link-arrow elena-text-white">
                        <?php esc_html_e( 'Read More Reviews', 'elena' ); ?>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════ CTA SECTION ═══════════ -->
    <section class="elena-cta elena-section" id="cta">
        <div class="elena-container elena-cta-inner">
            <div class="elena-cta-image elena-animate">
                <img src="<?php echo esc_url( ELENA_URI . '/assets/images/store-interior.jpg' ); ?>" alt="Sneakers Store" class="elena-cta-img">
            </div>
            <div class="elena-cta-text elena-animate">
                <h2 class="elena-cta-title"><?php echo wp_kses_post( __( 'Buy Your<br>Sneakers<br>Today', 'elena' ) ); ?></h2>
                <a href="<?php echo esc_url( $shop_url ); ?>" class="elena-btn elena-btn-primary">
                    <?php esc_html_e( 'Order Now', 'elena' ); ?>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- ═══════════ FEATURES SECTION ═══════════ -->
    <section class="elena-features elena-section" id="features">
        <div class="elena-container">
            <div class="elena-features-grid elena-animate">
                <div class="elena-feature">
                    <div class="elena-feature-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 3 20 16 16 16 16 8"/><line x1="1" y1="16" x2="5" y2="16"/><line x1="8" y1="16" x2="12" y2="16"/><line x1="15" y1="16" x2="19" y2="16"/><circle cx="5" cy="18" r="2"/><circle cx="18" cy="18" r="2"/></svg>
                    </div>
                    <h3><?php esc_html_e( 'Delivery Everywhere', 'elena' ); ?></h3>
                    <p><?php esc_html_e( '1,000+ Destinations', 'elena' ); ?></p>
                </div>
                <div class="elena-feature">
                    <div class="elena-feature-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <h3><?php esc_html_e( 'Customer Service', 'elena' ); ?></h3>
                    <p><?php esc_html_e( '24/7 Support', 'elena' ); ?></p>
                </div>
                <div class="elena-feature">
                    <div class="elena-feature-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    </div>
                    <h3><?php esc_html_e( 'Secure Payment', 'elena' ); ?></h3>
                    <p><?php esc_html_e( 'Cash on Delivery', 'elena' ); ?></p>
                </div>
                <div class="elena-feature">
                    <div class="elena-feature-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <h3><?php esc_html_e( 'Fast Delivery', 'elena' ); ?></h3>
                    <p><?php esc_html_e( 'Within 48h', 'elena' ); ?></p>
                </div>
            </div>
        </div>
    </section>

    <?php
}

get_footer();
