<?php
/**
 * Template Name: Front Page French
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
    $hero_title    = get_theme_mod( 'elena_hero_title', 'Entrez dans la Performance' );
    $hero_subtitle = get_theme_mod( 'elena_hero_subtitle', 'Des chaussures de sport modernes conçues pour une performance réelle. Matériaux légers, construction durable et design ergonomique.' );
    $hero_image    = get_theme_mod( 'elena_hero_image', '' );
    $hero_cta_text = get_theme_mod( 'elena_hero_cta_text', 'Voir plus' );
    $hero_cta_url  = get_theme_mod( 'elena_hero_cta_url', '#' );
    $cta_image     = get_theme_mod( 'elena_cta_image', '' );
    $shop_url      = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '#';
    ?>

    <!-- ═══════════ HERO SECTION ═══════════ -->
    <?php
    // Priority: Featured Image of page, then Customizer, then fallback
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
                <h2 class="elena-section-subtitle"><?php esc_html_e( 'Collection pour hommes', 'elena' ); ?></h2>
                <p><?php esc_html_e( 'Découvrez notre sélection de chaussures de sport performantes. Chaque paire est conçue pour offrir un maximum de confort et de style pour un usage quotidien.', 'elena' ); ?></p>
                <p><?php esc_html_e( 'Conçues avec des matériaux de première qualité, nos baskets allient technologie de pointe et esthétique contemporaine.', 'elena' ); ?></p>
                <p><?php esc_html_e( 'Chaque paire est fabriquée pour ceux qui exigent plus de leurs chaussures — alliant performance, durabilité et style en égale mesure.', 'elena' ); ?></p>
            </div>
        </div>
    </section>

    <!-- ═══════════ BEST SELLERS ═══════════ -->
    <section class="masha-coups-section elena-section" id="best-sellers">
        <div class="elena-container">
            <div class="masha-coups-header elena-animate">
                <h2 class="masha-coups-title">Nos coups de cœur ❤️</h2>
            </div>

            <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                <div class="masha-coups-layout">
                    <!-- FEATURED LEFT CARD -->
                    <div class="masha-coups-left elena-animate">
                        <?php
                        $args_featured = array(
                            'post_type'      => 'product',
                            'posts_per_page' => 1,
                            'meta_key'       => 'total_sales',
                            'orderby'        => 'meta_value_num',
                            'order'          => 'DESC',
                        );
                        $featured = new WP_Query( $args_featured );
                        if ( $featured->have_posts() ) {
                            $featured->the_post();
                            global $product;
                            $product = wc_get_product( get_the_ID() );
                            
                            $sale_badge = '';
                            if ( $product->is_on_sale() && (float) $product->get_regular_price() > 0 ) {
                                $percent = round( ( ( (float) $product->get_regular_price() - (float) $product->get_sale_price() ) / (float) $product->get_regular_price() ) * 100 );
                                $sale_badge = '-' . $percent . '%';
                            }
                            
                            $is_new = false;
                            if ( has_term( 'new', 'product_tag', $product->get_id() ) || has_term( 'NEW', 'product_tag', $product->get_id() ) ) {
                                $is_new = true;
                            } elseif ( ( time() - get_the_time( 'U', $product->get_id() ) ) < ( 30 * 24 * 60 * 60 ) ) {
                                $is_new = true;
                            }

                            $size_attrs = array();
                            if ( $product->is_type( 'variable' ) ) {
                                $attrs = $product->get_variation_attributes();
                                if ( ! empty( $attrs ) ) {
                                    foreach ( $attrs as $name => $options ) {
                                        if ( stripos( $name, 'pointure' ) !== false || stripos( $name, 'size' ) !== false || stripos( $name, 'taille' ) !== false ) {
                                            $size_attrs = is_array( $options ) ? $options : array();
                                            break;
                                        }
                                    }
                                    if ( empty( $size_attrs ) ) {
                                        $size_attrs = reset( $attrs );
                                        $size_attrs = is_array( $size_attrs ) ? $size_attrs : array();
                                    }
                                }
                            } else {
                                foreach ( array( 'pa_taille', 'pa_pointure', 'taille', 'pointure', 'size' ) as $key ) {
                                    $val = $product->get_attribute( $key );
                                    if ( $val ) {
                                        $size_attrs = strpos($val, ',') !== false ? explode(',', $val) : explode(' ', $val);
                                        $size_attrs = array_filter(array_map('trim', $size_attrs));
                                        break;
                                    }
                                }
                            }
                            ?>
                            <div class="masha-featured-card">
                                <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="masha-fc-link">
                                    <div class="masha-fc-image">
                                        <?php echo $product->get_image( 'woocommerce_single' ); ?>
                                        <?php if ( $sale_badge ) : ?>
                                            <span class="elena-sale-badge elena-sale-badge-black"><?php echo esc_html( $sale_badge ); ?></span>
                                        <?php endif; ?>
                                        <?php if ( $is_new ) : ?>
                                            <span class="elena-new-badge elena-new-badge-green">NEW</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="masha-fc-content">
                                        <h3 class="masha-fc-title"><?php echo get_the_title(); ?></h3>
                                        <?php if ( ! empty( $size_attrs ) ) : ?>
                                            <div class="elena-product-sizes masha-fc-sizes">
                                                <?php foreach ( $size_attrs as $s ) : ?>
                                                    <span class="elena-size-option"><?php echo esc_html( $s ); ?></span>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="elena-product-price masha-fc-price">
                                            <?php echo $product->get_price_html(); ?>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php
                        }
                        wp_reset_postdata();
                        ?>
                    </div>

                    <!-- RIGHT GRID -->
                    <div class="masha-coups-right elena-animate">
                        <ul class="masha-coups-tabs">
                            <li class="active">ESCARPINS CHIC</li>
                            <li>MOCASSINS</li>
                            <li>DERBIES</li>
                        </ul>
                        <div class="masha-coups-grid">
                            <ul class="elena-products-grid masha-right-products">
                                <?php
                                $args_grid = array(
                                    'post_type'      => 'product',
                                    'posts_per_page' => 6,
                                    'offset'         => 1,
                                    'meta_key'       => 'total_sales',
                                    'orderby'        => 'meta_value_num',
                                    'order'          => 'DESC',
                                );
                                $grid = new WP_Query( $args_grid );
                                if ( $grid->have_posts() ) {
                                    while ( $grid->have_posts() ) {
                                        $grid->the_post();
                                        wc_get_template_part( 'content', 'product' );
                                    }
                                }
                                wp_reset_postdata();
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="elena-section-footer elena-animate" style="margin-top: 2rem;">
                    <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="elena-link-arrow">
                        <?php esc_html_e( 'Voir tous les produits', 'elena' ); ?>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </div>
            <?php else: ?>
                <p class="elena-no-products"><?php esc_html_e( 'Installez WooCommerce pour afficher les produits ici.', 'mashaussure' ); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <!-- ═══════════ REVIEWS SECTION ═══════════ -->
    <section class="elena-reviews elena-section" id="reviews">
        <div class="elena-reviews-bg">
            <div class="elena-container">
                <div class="elena-reviews-content elena-animate">
                    <h2 class="elena-section-title elena-text-white"><?php esc_html_e( 'Avis', 'elena' ); ?></h2>
                    <p class="elena-reviews-rating elena-text-white"><?php printf( esc_html__( 'Nos clients nous évaluent systématiquement à %s', 'elena' ), '<strong>4.8 / 5</strong>' ); ?></p>

                    <div class="elena-testimonials">
                        <div class="elena-testimonial">
                            <div class="elena-stars">★★★★★</div>
                            <p class="elena-testimonial-name"><strong><?php esc_html_e( 'Amine', 'elena' ); ?></strong></p>
                            <p class="elena-testimonial-text">"<?php esc_html_e( 'La qualité est exceptionnelle. Ce sont les meilleures baskets que j\'aie jamais possédées. Confortables, élégantes et durables. Elles valent absolument chaque dirham.', 'elena' ); ?>"</p>
                        </div>
                        <div class="elena-testimonial">
                            <div class="elena-stars">★★★★★</div>
                            <p class="elena-testimonial-name"><strong><?php esc_html_e( 'Sara', 'elena' ); ?></strong></p>
                            <p class="elena-testimonial-text">"<?php esc_html_e( 'J\'ai reçu ma commande en seulement 2 jours ! Matériaux de grande qualité et super confortables. Le service client est également incroyable — très réactif et professionnel.', 'elena' ); ?>"</p>
                        </div>
                    </div>

                    <a href="#" class="elena-link-arrow elena-text-white">
                        <?php esc_html_e( 'Lire plus d\'avis', 'elena' ); ?>
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
                <h2 class="elena-cta-title"><?php echo wp_kses_post( __( 'Achetez vos<br>baskets<br>aujourd\'hui', 'elena' ) ); ?></h2>
                <a href="<?php echo esc_url( $shop_url ); ?>" class="elena-btn elena-btn-primary">
                    <?php esc_html_e( 'Commander maintenant', 'elena' ); ?>
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
                        <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10 17h4V5H2v12h3m0 0a2 2 0 1 0 4 0 2 2 0 1 0-4 0m14 0a2 2 0 1 0 4 0 2 2 0 1 0-4 0m-8 0h6V12h3.5L22 17v2h-4"/><path d="M16 12h4.5"/></svg>
                    </div>
                    <div class="masha-service-info">
                        <h3>Livraison Partout</h3>
                        <p>+1400 Destinations</p>
                    </div>
                </div>

                <!-- Item 2: Customer Service -->
                <div class="masha-service-box">
                    <div class="masha-service-icon">
                        <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11v3a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-3"/><path d="M21 11a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2"/><circle cx="12" cy="11" r="3"/><path d="M7 21v-2a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v2"/></svg>
                    </div>
                    <div class="masha-service-info">
                        <h3>Service Client</h3>
                        <p>9h - 18h</p>
                    </div>
                </div>

                <!-- Item 3: Secure Payment -->
                <div class="masha-service-box">
                    <div class="masha-service-icon">
                        <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/><path d="M5 15h2"/><path d="M10 15h4"/></svg>
                    </div>
                    <div class="masha-service-info">
                        <h3>Paiement Sécurisé</h3>
                        <p>En ligne ou à la livraison</p>
                    </div>
                </div>

                <!-- Item 4: Fast Delivery -->
                <div class="masha-service-box">
                    <div class="masha-service-icon">
                        <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
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
