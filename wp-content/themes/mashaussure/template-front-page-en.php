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
    $cta_image     = get_theme_mod( 'elena_cta_image', '' );
    $shop_url      = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '#';
    ?>

    <!-- ═══════════ HERO SECTION ═══════════ -->
    <?php
    // Use Page Featured Image as priority, then Customizer, then fallback
    $featured_img = get_the_post_thumbnail_url( get_the_ID(), 'full' );
    $hero_bg = $featured_img ? $featured_img : ( $hero_image ? $hero_image : ELENA_URI . '/assets/images/hero-bg.png' );
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
                    echo '<ul class="elena-products-grid elena-animate">';
                    while ( $products->have_posts() ) {
                        $products->the_post();
                        global $product;
                        $product = wc_get_product( get_the_ID() );
                        if ( $product && $product->is_visible() ) {
                            wc_get_template_part( 'content', 'product' );
                        }
                    }
                    echo '</ul>';
                    wp_reset_postdata();
                } else {
                    echo '<ul class="elena-products-grid elena-animate">';
                    $demos = array(
                        array( 'name' => 'Air Max Pro', 'price' => 'د.م. 149,00' ),
                        array( 'name' => 'Urban Runner', 'price' => 'د.م. 129,00' ),
                        array( 'name' => 'Sport Flex', 'price' => 'د.م. 139,00' ),
                        array( 'name' => 'Classic Elite', 'price' => 'د.م. 159,00' ),
                    );
                    foreach ( $demos as $demo ) {
                        ?>
                        <li class="elena-product-card elena-product-card-masha">
                            <div class="elena-product-card-inner">
                                <a href="<?php echo esc_url( $shop_url ); ?>" class="elena-product-link">
                                    <div class="elena-product-image">
                                        <div class="elena-product-placeholder">
                                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#bbb" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                                        </div>
                                    </div>
                                </a>
                                <div class="elena-product-info">
                                    <div class="elena-product-sizes">36 37 38 39 40 41</div>
                                    <h3 class="elena-product-title"><a href="<?php echo esc_url( $shop_url ); ?>"><?php echo esc_html( $demo['name'] ); ?></a></h3>
                                    <div class="elena-product-price"><?php echo esc_html( $demo['price'] ); ?></div>
                                </div>
                                <div class="elena-product-actions">
                                    <a href="<?php echo esc_url( $shop_url ); ?>" class="button"><?php esc_html_e( 'Add to cart', 'mashaussure' ); ?></a>
                                </div>
                            </div>
                        </li>
                        <?php
                    }
                    echo '</ul>';
                }
            } else {
                echo '<p class="elena-no-products">' . esc_html__( 'Install WooCommerce to display products here.', 'mashaussure' ) . '</p>';
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
                <?php $cta_bg = $cta_image ? $cta_image : ELENA_URI . '/assets/images/store-interior.jpg'; ?>
                <img src="<?php echo esc_url( $cta_bg ); ?>" alt="Sneakers Store" class="elena-cta-img">
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

    <!-- ═══════════ SERVICES GRID ═══════════ -->
    <section class="masha-services-section elena-section" id="services">
        <div class="elena-container">
            <div class="masha-services-grid elena-animate">
                <!-- Item 1: Livraison -->
                <div class="masha-service-box">
                    <div class="masha-service-icon">
                        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 17h4V5H2v12h3m0 0a2 2 0 1 0 4 0 2 2 0 1 0-4 0m14 0a2 2 0 1 0 4 0 2 2 0 1 0-4 0m-8 0h6V12h3.5L22 17v2h-4"/><path d="M16 12h4.5"/></svg>
                    </div>
                    <div class="masha-service-info">
                        <h3>Livraison Partout</h3>
                        <p>+1400 Destinations</p>
                    </div>
                </div>

                <!-- Item 2: Customer Service -->
                <div class="masha-service-box">
                    <div class="masha-service-icon">
                        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11v3a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-3"/><path d="M21 11a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2"/><circle cx="12" cy="11" r="3"/><path d="M7 21v-2a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v2"/></svg>
                    </div>
                    <div class="masha-service-info">
                        <h3>Service Client</h3>
                        <p>9h - 18h</p>
                    </div>
                </div>

                <!-- Item 3: Secure Payment -->
                <div class="masha-service-box">
                    <div class="masha-service-icon">
                        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/><path d="M5 15h2"/><path d="M10 15h4"/></svg>
                    </div>
                    <div class="masha-service-info">
                        <h3>Paiement Sécurisé</h3>
                        <p>En ligne ou à la livraison</p>
                    </div>
                </div>

                <!-- Item 4: Fast Delivery -->
                <div class="masha-service-box">
                    <div class="masha-service-icon">
                        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="M2 12h2"/><path d="M20 12h2"/></svg>
                    </div>
                    <div class="masha-service-info">
                        <h3>Livraison Rapide</h3>
                        <p>Sous 48h</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
}

get_footer();
