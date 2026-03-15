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
                <h2 class="elena-section-subtitle"><?php esc_html_e( 'Collection pour hommes', 'elena' ); ?></h2>
                <p><?php esc_html_e( 'Découvrez notre sélection de chaussures de sport performantes. Chaque paire est conçue pour offrir un maximum de confort et de style pour un usage quotidien.', 'elena' ); ?></p>
                <p><?php esc_html_e( 'Conçues avec des matériaux de première qualité, nos baskets allient technologie de pointe et esthétique contemporaine.', 'elena' ); ?></p>
                <p><?php esc_html_e( 'Chaque paire est fabriquée pour ceux qui exigent plus de leurs chaussures — alliant performance, durabilité et style en égale mesure.', 'elena' ); ?></p>
            </div>
        </div>
    </section>

    <!-- ═══════════ BEST SELLERS ═══════════ -->
    <section class="elena-best-sellers elena-section" id="best-sellers">
        <div class="elena-container">
            <div class="elena-section-header elena-animate">
                <h2 class="elena-section-title"><?php esc_html_e( 'Meilleures ventes', 'elena' ); ?></h2>
                <p class="elena-section-label"><?php esc_html_e( 'COLLECTION DE BASKETS', 'elena' ); ?></p>
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
                echo '<p class="elena-no-products">' . esc_html__( 'Installez WooCommerce pour afficher les produits ici.', 'elena' ) . '</p>';
            }
            ?>

            <div class="elena-section-footer elena-animate">
                <a href="<?php echo esc_url( $shop_url ); ?>" class="elena-link-arrow">
                    <?php esc_html_e( 'Voir tous les produits', 'elena' ); ?>
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
                <img src="<?php echo esc_url( ELENA_URI . '/assets/images/store-interior.jpg' ); ?>" alt="Sneakers Store" class="elena-cta-img">
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

    <!-- ═══════════ FEATURES SECTION ═══════════ -->
    <section class="elena-features elena-section" id="features">
        <div class="elena-container">
            <div class="elena-features-grid elena-animate">
                <div class="elena-feature">
                    <div class="elena-feature-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 3 20 16 16 16 16 8"/><line x1="1" y1="16" x2="5" y2="16"/><line x1="8" y1="16" x2="12" y2="16"/><line x1="15" y1="16" x2="19" y2="16"/><circle cx="5" cy="18" r="2"/><circle cx="18" cy="18" r="2"/></svg>
                    </div>
                    <h3><?php esc_html_e( 'Livraison partout', 'elena' ); ?></h3>
                    <p><?php esc_html_e( 'Plus de 1 000 destinations', 'elena' ); ?></p>
                </div>
                <div class="elena-feature">
                    <div class="elena-feature-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <h3><?php esc_html_e( 'Service client', 'elena' ); ?></h3>
                    <p><?php esc_html_e( 'Assistance 24/7', 'elena' ); ?></p>
                </div>
                <div class="elena-feature">
                    <div class="elena-feature-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    </div>
                    <h3><?php esc_html_e( 'Paiement sécurisé', 'elena' ); ?></h3>
                    <p><?php esc_html_e( 'Paiement à la livraison', 'elena' ); ?></p>
                </div>
                <div class="elena-feature">
                    <div class="elena-feature-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <h3><?php esc_html_e( 'Livraison rapide', 'elena' ); ?></h3>
                    <p><?php esc_html_e( 'Sous 48h', 'elena' ); ?></p>
                </div>
            </div>
        </div>
    </section>

    <?php
}

get_footer();
