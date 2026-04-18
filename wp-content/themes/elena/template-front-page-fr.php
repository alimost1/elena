<?php
/**
 * Template Name: Front Page French
 * Elena Premium Homepage – French
 *
 * @package Elena
 */

get_header();

// Check if Elementor has a template for this page
if ( false && function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'single' ) ) {
    // Elementor will handle this page
} else {
    // Theme default homepage
    $hero_title    = get_theme_mod( 'elena_hero_title', 'Nouvelle Collection' );
    $hero_subtitle = get_theme_mod( 'elena_hero_subtitle', 'Style authentique & confort premium pour toute la famille.' );
    $hero_image    = get_theme_mod( 'elena_hero_image', '' );
    $hero_cta_text = get_theme_mod( 'elena_hero_cta_text', 'Découvrir' );
    $hero_cta_url  = get_theme_mod( 'elena_hero_cta_url', '#' );
    $shop_url      = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '#';
    ?>

    <!-- ═══════════ ① HERO SECTION ═══════════ -->
    <?php
    $hero_bg = $hero_image ? $hero_image : ELENA_URI . '/assets/images/hero-bg.png';
    ?>
    <section class="elena-hero" id="hero">
        <div class="elena-hero-image-wrap">
            <img src="<?php echo esc_url( $hero_bg ); ?>" alt="<?php echo esc_attr( $hero_title ); ?>" class="elena-hero-bg-img">
        </div>

        <!-- Hero overlay with headline + CTA -->
        <div class="elena-hero-overlay">
            <div class="elena-hero-content elena-animate">
                <p class="elena-hero-label"><?php esc_html_e( 'ELENA.MA', 'elena' ); ?></p>
                <h1 class="elena-hero-title"><?php echo esc_html( $hero_title ); ?></h1>
                <p class="elena-hero-subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>
            </div>
        </div>

        <div class="elena-hero-cta">
            <a href="<?php echo esc_url( $hero_cta_url ? $hero_cta_url : $shop_url ); ?>" class="elena-btn elena-btn-primary elena-animate">
                <?php echo esc_html( $hero_cta_text ); ?>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
    </section>

    <!-- ═══════════ ② CATEGORY BROWSING ═══════════ -->
    <section class="elena-categories elena-section" id="categories">
        <div class="elena-container">
            <div class="elena-section-header elena-animate">
                <h2 class="elena-section-title"><?php esc_html_e( 'Nos Catégories', 'elena' ); ?></h2>
                <p class="elena-section-label"><?php esc_html_e( 'TROUVEZ VOTRE STYLE', 'elena' ); ?></p>
            </div>

            <?php
            // Get WooCommerce product categories with images
            if ( class_exists( 'WooCommerce' ) ) {
                $categories = get_terms( array(
                    'taxonomy'   => 'product_cat',
                    'hide_empty' => true,
                    'parent'     => 0,
                    'number'     => 8,
                    'exclude'    => array( get_option( 'default_product_cat' ) ),
                ) );

                if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
                    echo '<div class="elena-categories-grid elena-animate">';
                    foreach ( $categories as $cat ) {
                        $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
                        $image_url = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : ELENA_URI . '/assets/images/category-placeholder.jpg';
                        $cat_link = get_term_link( $cat );
                        ?>
                        <a href="<?php echo esc_url( $cat_link ); ?>" class="elena-category-card">
                            <div class="elena-category-image">
                                <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $cat->name ); ?>">
                            </div>
                            <span class="elena-category-name"><?php echo esc_html( $cat->name ); ?></span>
                        </a>
                        <?php
                    }
                    echo '</div>';
                } else {
                    // Fallback categories
                    $fallback_cats = array(
                        'Baskets', 'Mocassins', 'Escarpins', 'Derbies',
                        'Sandales', 'Sacs', 'Chaussures Enfants', 'Bottines'
                    );
                    echo '<div class="elena-categories-grid elena-animate">';
                    foreach ( $fallback_cats as $cat_name ) {
                        ?>
                        <a href="<?php echo esc_url( $shop_url ); ?>" class="elena-category-card">
                            <div class="elena-category-image">
                                <div class="elena-product-placeholder">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#bbb" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                                </div>
                            </div>
                            <span class="elena-category-name"><?php echo esc_html( $cat_name ); ?></span>
                        </a>
                        <?php
                    }
                    echo '</div>';
                }
            }
            ?>
        </div>
    </section>

    <!-- ═══════════ ③ FEATURED PRODUCTS (Nos Coups de Cœur) ═══════════ -->
    <section class="elena-best-sellers elena-section" id="best-sellers" style="background-color: var(--elena-bg-alt);">
        <div class="elena-container">
            <div class="elena-section-header elena-animate">
                <h2 class="elena-section-title"><?php esc_html_e( 'Nos Coups de Cœur', 'elena' ); ?></h2>
                <p class="elena-section-label"><?php esc_html_e( 'SÉLECTION PREMIUM', 'elena' ); ?></p>
            </div>

            <?php
            if ( class_exists( 'WooCommerce' ) ) {
                $args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => 8,
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
                        array( 'name' => 'Sandales Élégantes', 'price' => 'د.م. 249,00' ),
                        array( 'name' => 'Mocassins Classiques', 'price' => 'د.م. 329,00' ),
                        array( 'name' => 'Escarpins Chic', 'price' => 'د.م. 299,00' ),
                        array( 'name' => 'Baskets Premium', 'price' => 'د.م. 379,00' ),
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
                                    <a href="<?php echo esc_url( $shop_url ); ?>" class="button"><?php esc_html_e( 'Ajouter au panier', 'elena' ); ?></a>
                                </div>
                            </div>
                        </li>
                        <?php
                    }
                    echo '</ul>';
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

    <!-- ═══════════ ④ GENDER SPLIT BANNERS ═══════════ -->
    <section class="elena-gender-split elena-section" id="gender-split">
        <div class="elena-container">
            <div class="elena-gender-grid elena-animate">
                <a href="<?php echo esc_url( $shop_url ); ?>" class="elena-gender-card elena-gender-elle">
                    <div class="elena-gender-overlay">
                        <span class="elena-gender-label"><?php esc_html_e( 'ELLE', 'elena' ); ?></span>
                        <span class="elena-gender-cta"><?php esc_html_e( 'Découvrir', 'elena' ); ?> →</span>
                    </div>
                </a>
                <a href="<?php echo esc_url( $shop_url ); ?>" class="elena-gender-card elena-gender-lui">
                    <div class="elena-gender-overlay">
                        <span class="elena-gender-label"><?php esc_html_e( 'LUI', 'elena' ); ?></span>
                        <span class="elena-gender-cta"><?php esc_html_e( 'Découvrir', 'elena' ); ?> →</span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- ═══════════ ⑤ TRUST / VALUE PROPOSITION ═══════════ -->
    <section class="elena-features elena-section" id="features">
        <div class="elena-container">
            <div class="elena-features-grid elena-animate">
                <div class="elena-feature">
                    <div class="elena-feature-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <h4><?php esc_html_e( 'Qualité Garantie', 'elena' ); ?></h4>
                    <p><?php esc_html_e( 'Sélection premium de marques', 'elena' ); ?></p>
                </div>
                <div class="elena-feature">
                    <div class="elena-feature-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                    </div>
                    <h4><?php esc_html_e( 'Livraison Rapide', 'elena' ); ?></h4>
                    <p><?php esc_html_e( 'Partout au Maroc sous 48h', 'elena' ); ?></p>
                </div>
                <div class="elena-feature">
                    <div class="elena-feature-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
                    </div>
                    <h4><?php esc_html_e( 'Échange Facile', 'elena' ); ?></h4>
                    <p><?php esc_html_e( 'Retour sous 7 jours', 'elena' ); ?></p>
                </div>
                <div class="elena-feature">
                    <div class="elena-feature-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    </div>
                    <h4><?php esc_html_e( 'Paiement Sécurisé', 'elena' ); ?></h4>
                    <p><?php esc_html_e( 'En ligne ou à la livraison', 'elena' ); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════ ⑥ REVIEWS SECTION ═══════════ -->
    <section class="elena-reviews elena-section" id="reviews">
        <div class="elena-reviews-bg">
            <div class="elena-container">
                <div class="elena-reviews-content elena-animate">
                    <h2 class="elena-section-title"><?php esc_html_e( 'Ce que disent nos clients', 'elena' ); ?></h2>
                    <p class="elena-reviews-rating"><?php printf( esc_html__( 'Nos clients nous évaluent systématiquement à %s', 'elena' ), '<strong>4.8 / 5</strong>' ); ?></p>

                    <div class="elena-testimonials">
                        <div class="elena-testimonial">
                            <div class="elena-stars">★★★★★</div>
                            <p class="elena-testimonial-name"><strong><?php esc_html_e( 'Amine B.', 'elena' ); ?></strong> <span class="elena-verified">✓ <?php esc_html_e( 'Achat vérifié', 'elena' ); ?></span></p>
                            <p class="elena-testimonial-text">"<?php esc_html_e( 'La qualité est exceptionnelle. Ce sont les meilleures chaussures que j\'aie jamais possédées. Confortables, élégantes et durables.', 'elena' ); ?>"</p>
                        </div>
                        <div class="elena-testimonial">
                            <div class="elena-stars">★★★★★</div>
                            <p class="elena-testimonial-name"><strong><?php esc_html_e( 'Sara M.', 'elena' ); ?></strong> <span class="elena-verified">✓ <?php esc_html_e( 'Achat vérifié', 'elena' ); ?></span></p>
                            <p class="elena-testimonial-text">"<?php esc_html_e( 'J\'ai reçu ma commande en seulement 2 jours ! Matériaux de grande qualité et super confortables. Service client incroyable.', 'elena' ); ?>"</p>
                        </div>
                        <div class="elena-testimonial">
                            <div class="elena-stars">★★★★★</div>
                            <p class="elena-testimonial-name"><strong><?php esc_html_e( 'Karim L.', 'elena' ); ?></strong> <span class="elena-verified">✓ <?php esc_html_e( 'Achat vérifié', 'elena' ); ?></span></p>
                            <p class="elena-testimonial-text">"<?php esc_html_e( 'Des chaussures qui allient parfaitement style et confort. Je recommande vivement Elena à tous mes amis.', 'elena' ); ?>"</p>
                        </div>
                    </div>

                    <a href="#" class="elena-link-arrow">
                        <?php esc_html_e( 'Lire plus d\'avis', 'elena' ); ?>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <?php
}

get_footer();
