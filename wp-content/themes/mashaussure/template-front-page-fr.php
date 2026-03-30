<?php
/**
 * Template Name: Front Page French
 *Elena.ma Homepage – pixel-perfect replica
 *
 * @package Mashaussure
 */

get_header();

$shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : '#';
$hero_image = get_theme_mod('elena_hero_image', '');
$featured_img = get_the_post_thumbnail_url(get_the_ID(), 'full');
$hero_bg = $featured_img ? $featured_img : ($hero_image ? $hero_image : ELENA_URI . '/assets/images/hero-bg.png');
?>

<!-- ═══════════ HERO SLIDER ═══════════ -->
<section class="masha-hero-slider" id="hero">
    <div class="masha-slider-track">
        <div class="masha-slide active">
            <img src="<?php echo esc_url($hero_bg); ?>" alt="Nouvelle Collection" class="masha-slide-img">
            <div class="masha-slide-overlay">
                <a href="<?php echo esc_url($shop_url); ?>" class="masha-slide-btn">Découvrir</a>
            </div>
        </div>
    </div>
    <button class="masha-slider-arrow masha-slider-prev" aria-label="Previous">&#10094;</button>
    <button class="masha-slider-arrow masha-slider-next" aria-label="Next">&#10095;</button>
</section>

<!-- ═══════════ TOP CATEGORIES ═══════════ -->
<section class="masha-top-categories" id="top-categories">
    <div class="elena-container">
        <div class="masha-section-heading">
            <h2>TOP CATEGORIES</h2>
            <span class="masha-heading-line"></span>
        </div>
        <div class="masha-categories-grid">
            <?php
            // Get WooCommerce product categories
            $cat_args = array(
                'taxonomy' => 'product_cat',
                'orderby' => 'count',
                'order' => 'DESC',
                'hide_empty' => true,
                'number' => 8,
                'exclude' => get_option('default_product_cat'), // exclude "Uncategorized"
            );
            $categories = get_terms($cat_args);

            if (!empty($categories) && !is_wp_error($categories)) {
                foreach ($categories as $cat) {
                    $thumb_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
                    $thumb_url = $thumb_id ? wp_get_attachment_url($thumb_id) : '';

                    // Use premium generated placeholders if no image uploaded
                    if (!$thumb_url) {
                        $cat_n = strtolower($cat->name);
                        if (strpos($cat_n, 'escarpin') !== false || strpos($cat_n, 'heels') !== false)
                            $thumb_url = ELENA_URI . '/assets/images/categories/heels.png';
                        elseif (strpos($cat_n, 'mocassin') !== false || strpos($cat_n, 'bateau') !== false || strpos($cat_n, 'mule') !== false || strpos($cat_n, 'derbies') !== false)
                            $thumb_url = ELENA_URI . '/assets/images/categories/loafers.png';
                        elseif (strpos($cat_n, 'sac') !== false || strpos($cat_n, 'bag') !== false)
                            $thumb_url = ELENA_URI . '/assets/images/categories/bag.png';
                        elseif (strpos($cat_n, 'fille') !== false || strpos($cat_n, 'garçon') !== false || strpos($cat_n, 'enfant') !== false || strpos($cat_n, 'kids') !== false)
                            $thumb_url = ELENA_URI . '/assets/images/categories/kids.png';
                        else
                            $thumb_url = ELENA_URI . '/assets/images/categories/heels.png';
                    }

                    $cat_link = get_term_link($cat);
                    ?>
                    <a href="<?php echo esc_url($cat_link); ?>" class="masha-cat-card">
                        <div class="masha-cat-img-wrap">
                            <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($cat->name); ?>">
                        </div>
                        <span class="masha-cat-name"><?php echo esc_html(strtoupper($cat->name)); ?></span>
                    </a>
                    <?php
                }
            } else {
                // Fallback if no categories exist in WooCommerce yet
                $fallback_cats = array(
                    'Derbies & Richelieu' => 'loafers.png',
                    'Escarpins' => 'heels.png',
                    'Fille' => 'kids.png',
                    'Garçon' => 'kids.png',
                    'Mocassins Femmes' => 'loafers.png',
                    'Mocassins & Chaussures Bateau' => 'loafers.png',
                    'Mules' => 'loafers.png',
                    'Sacs' => 'bag.png'
                );
                foreach ($fallback_cats as $cat_name => $cat_img) {
                    ?>
                    <a href="<?php echo esc_url($shop_url); ?>" class="masha-cat-card">
                        <div class="masha-cat-img-wrap">
                            <img src="<?php echo esc_url(ELENA_URI . '/assets/images/categories/' . $cat_img); ?>"
                                alt="<?php echo esc_attr($cat_name); ?>">
                        </div>
                        <span class="masha-cat-name"><?php echo esc_html(strtoupper($cat_name)); ?></span>
                    </a>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<!-- ═══════════ SERVICE BENEFITS (White) ═══════════ -->
<section class="masha-benefits-white" id="benefits">
    <div class="elena-container">
        <div class="masha-benefits-row">
            <div class="masha-benefit-item">
                <div class="masha-benefit-icon">
                    <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2" />
                        <path d="M15 18H9" />
                        <path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14v10" />
                        <circle cx="17" cy="18" r="2" />
                        <circle cx="7" cy="18" r="2" />
                    </svg>
                </div>
                <h3>Livraison Partout</h3>
                <p>+1400 Destinations</p>
            </div>
            <div class="masha-benefit-divider"></div>
            <div class="masha-benefit-item">
                <div class="masha-benefit-icon">
                    <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                </div>
                <h3>Service Client</h3>
                <p>9h - 18h</p>
            </div>
            <div class="masha-benefit-divider"></div>
            <div class="masha-benefit-item">
                <div class="masha-benefit-icon">
                    <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2" />
                        <line x1="1" y1="10" x2="23" y2="10" />
                        <path d="M5 15h2" />
                        <path d="M10 15h4" />
                    </svg>
                </div>
                <h3>Paiement Sécurisé</h3>
                <p>En ligne ou à la livraison</p>
            </div>
            <div class="masha-benefit-divider"></div>
            <div class="masha-benefit-item">
                <div class="masha-benefit-icon">
                    <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <h3>Livraison Rapide</h3>
                <p>Sous 48h</p>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════ NOS COUPS DE COEUR (Femmes) ═══════════ -->
<?php if (class_exists('WooCommerce')): ?>
    <section class="masha-coups-section elena-section" id="coups-de-coeur">
        <div class="elena-container">
            <div class="masha-coups-header">
                <h2 class="masha-coups-title">Nos coups de cœur ❤️</h2>
            </div>

            <div class="masha-coups-layout">
                <!-- FEATURED LEFT CARD -->
                <div class="masha-coups-left">
                    <?php
                    $args_featured = array(
                        'post_type' => 'product',
                        'posts_per_page' => 1,
                        'meta_key' => 'total_sales',
                        'orderby' => 'meta_value_num',
                        'order' => 'DESC',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field' => 'slug',
                                'terms' => array('femmes', 'femme', 'escarpins', 'women'),
                                'operator' => 'IN',
                            ),
                        ),
                    );
                    $featured = new WP_Query($args_featured);

                    // Fallback: if no women's products, get any product
                    if (!$featured->have_posts()) {
                        $args_featured['tax_query'] = array();
                        $featured = new WP_Query($args_featured);
                    }

                    if ($featured->have_posts()) {
                        $featured->the_post();
                        global $product;
                        $product = wc_get_product(get_the_ID());

                        $sale_badge = '';
                        if ($product->is_on_sale() && (float) $product->get_regular_price() > 0) {
                            $percent = round((((float) $product->get_regular_price() - (float) $product->get_sale_price()) / (float) $product->get_regular_price()) * 100);
                            $sale_badge = '-' . $percent . '%';
                        }

                        $is_new = false;
                        if (has_term('new', 'product_tag', $product->get_id()) || has_term('NEW', 'product_tag', $product->get_id())) {
                            $is_new = true;
                        } elseif ((time() - get_the_time('U', $product->get_id())) < (30 * 24 * 60 * 60)) {
                            $is_new = true;
                        }

                        $size_attrs = array();
                        if ($product->is_type('variable')) {
                            $attrs = $product->get_variation_attributes();
                            if (!empty($attrs)) {
                                foreach ($attrs as $name => $options) {
                                    if (stripos($name, 'pointure') !== false || stripos($name, 'size') !== false || stripos($name, 'taille') !== false) {
                                        $size_attrs = is_array($options) ? $options : array();
                                        break;
                                    }
                                }
                                if (empty($size_attrs)) {
                                    $size_attrs = reset($attrs);
                                    $size_attrs = is_array($size_attrs) ? $size_attrs : array();
                                }
                            }
                        }
                        ?>
                        <div class="masha-featured-card">
                            <a href="<?php echo esc_url($product->get_permalink()); ?>" class="masha-fc-link">
                                <div class="masha-fc-image">
                                    <?php echo $product->get_image('woocommerce_single'); ?>
                                    <?php if ($sale_badge): ?>
                                        <span
                                            class="elena-sale-badge elena-sale-badge-black"><?php echo esc_html($sale_badge); ?></span>
                                    <?php endif; ?>
                                    <?php if ($is_new): ?>
                                        <span class="elena-new-badge elena-new-badge-green">NEW</span>
                                    <?php endif; ?>
                                </div>
                                <div class="masha-fc-content">
                                    <h3 class="masha-fc-title"><?php echo get_the_title(); ?></h3>
                                    <?php if (!empty($size_attrs)): ?>
                                        <div class="elena-product-sizes masha-fc-sizes">
                                            <?php foreach ($size_attrs as $s): ?>
                                                <span class="elena-size-option"><?php echo esc_html($s); ?></span>
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
                <div class="masha-coups-right">
                    <ul class="masha-coups-tabs">
                        <li class="active">ESCARPINS CHIC</li>
                        <li>MOCASSINS</li>
                        <li>DERBIES</li>
                    </ul>
                    <div class="masha-coups-grid">
                        <ul class="elena-products-grid masha-right-products">
                            <?php
                            $args_grid = array(
                                'post_type' => 'product',
                                'posts_per_page' => 6,
                                'offset' => 1,
                                'meta_key' => 'total_sales',
                                'orderby' => 'meta_value_num',
                                'order' => 'DESC',
                            );
                            $grid = new WP_Query($args_grid);
                            if ($grid->have_posts()) {
                                while ($grid->have_posts()) {
                                    $grid->the_post();
                                    wc_get_template_part('content', 'product');
                                }
                            }
                            wp_reset_postdata();
                            ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="elena-section-footer" style="margin-top: 2rem;">
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="elena-link-arrow">
                    <?php esc_html_e('Voir tous les produits', 'mashaussure'); ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <polyline points="12 5 19 12 12 19" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- ═══════════ STYLE AUTHENTIQUE (Hommes) ═══════════ -->
    <section class="masha-coups-section masha-coups-men elena-section" id="style-authentique">
        <div class="elena-container">
            <div class="masha-coups-header">
                <h2 class="masha-coups-title">Style Authentique 🖤</h2>
            </div>

            <div class="masha-coups-layout">
                <!-- FEATURED LEFT CARD -->
                <div class="masha-coups-left">
                    <?php
                    $args_men = array(
                        'post_type' => 'product',
                        'posts_per_page' => 1,
                        'meta_key' => 'total_sales',
                        'orderby' => 'meta_value_num',
                        'order' => 'DESC',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field' => 'slug',
                                'terms' => array('hommes', 'homme', 'men', 'mocassins'),
                                'operator' => 'IN',
                            ),
                        ),
                    );
                    $men_featured = new WP_Query($args_men);

                    if (!$men_featured->have_posts()) {
                        $args_men['tax_query'] = array();
                        $args_men['offset'] = 2;
                        $men_featured = new WP_Query($args_men);
                    }

                    if ($men_featured->have_posts()) {
                        $men_featured->the_post();
                        global $product;
                        $product = wc_get_product(get_the_ID());

                        $sale_badge = '';
                        if ($product->is_on_sale() && (float) $product->get_regular_price() > 0) {
                            $percent = round((((float) $product->get_regular_price() - (float) $product->get_sale_price()) / (float) $product->get_regular_price()) * 100);
                            $sale_badge = '-' . $percent . '%';
                        }

                        $is_new = (time() - get_the_time('U', $product->get_id())) < (30 * 24 * 60 * 60);

                        $size_attrs = array();
                        if ($product->is_type('variable')) {
                            $attrs = $product->get_variation_attributes();
                            if (!empty($attrs)) {
                                foreach ($attrs as $name => $options) {
                                    if (stripos($name, 'pointure') !== false || stripos($name, 'size') !== false || stripos($name, 'taille') !== false) {
                                        $size_attrs = is_array($options) ? $options : array();
                                        break;
                                    }
                                }
                                if (empty($size_attrs)) {
                                    $size_attrs = reset($attrs);
                                    $size_attrs = is_array($size_attrs) ? $size_attrs : array();
                                }
                            }
                        }
                        ?>
                        <div class="masha-featured-card">
                            <a href="<?php echo esc_url($product->get_permalink()); ?>" class="masha-fc-link">
                                <div class="masha-fc-image">
                                    <?php echo $product->get_image('woocommerce_single'); ?>
                                    <?php if ($sale_badge): ?>
                                        <span
                                            class="elena-sale-badge elena-sale-badge-black"><?php echo esc_html($sale_badge); ?></span>
                                    <?php endif; ?>
                                    <?php if ($is_new): ?>
                                        <span class="elena-new-badge elena-new-badge-green">NEW</span>
                                    <?php endif; ?>
                                </div>
                                <div class="masha-fc-content">
                                    <h3 class="masha-fc-title"><?php echo get_the_title(); ?></h3>
                                    <?php if (!empty($size_attrs)): ?>
                                        <div class="elena-product-sizes masha-fc-sizes">
                                            <?php foreach ($size_attrs as $s): ?>
                                                <span class="elena-size-option"><?php echo esc_html($s); ?></span>
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
                <div class="masha-coups-right">
                    <ul class="masha-coups-tabs">
                        <li class="active">MOCASSINS</li>
                        <li>BASKETS URBAINES</li>
                        <li>VILLE & ÉLÉGANCE</li>
                    </ul>
                    <div class="masha-coups-grid">
                        <ul class="elena-products-grid masha-right-products">
                            <?php
                            $args_men_grid = array(
                                'post_type' => 'product',
                                'posts_per_page' => 6,
                                'offset' => 3,
                                'meta_key' => 'total_sales',
                                'orderby' => 'meta_value_num',
                                'order' => 'DESC',
                            );
                            $men_grid = new WP_Query($args_men_grid);
                            if ($men_grid->have_posts()) {
                                while ($men_grid->have_posts()) {
                                    $men_grid->the_post();
                                    wc_get_template_part('content', 'product');
                                }
                            }
                            wp_reset_postdata();
                            ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="elena-section-footer" style="margin-top: 2rem;">
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="elena-link-arrow">
                    <?php esc_html_e('Voir tous les produits', 'mashaussure'); ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <polyline points="12 5 19 12 12 19" />
                    </svg>
                </a>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- ═══════════ STORE BANNER ═══════════ -->
<section class="masha-store-banner" id="store-banner"
    style="background-image: url('<?php echo esc_url(ELENA_URI . '/assets/images/store-banner.jpg'); ?>'); background-size: cover; background-position: center; background-attachment: fixed;">
    <div class="masha-store-banner-overlay">
        <div class="elena-container">
            <p class="masha-store-banner-text">DécouvrezElena.ma, votre destination pour les meilleures offres en ligne
                et dans la boutique en exclusivité !</p>
        </div>
    </div>
</section>


<!-- ═══════════ SERVICES GRID (Black Pre-Footer) ═══════════ -->
<section class="masha-services-section elena-section" id="services">
    <div class="elena-container">
        <div class="masha-services-grid">
            <div class="masha-service-box">
                <div class="masha-service-icon">
                    <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2" />
                        <path d="M15 18H9" />
                        <path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14v10" />
                        <circle cx="17" cy="18" r="2" />
                        <circle cx="7" cy="18" r="2" />
                    </svg>
                </div>
                <div class="masha-service-info">
                    <h3>Livraison Partout</h3>
                    <p>+1400 Destinations</p>
                </div>
            </div>
            <div class="masha-service-box">
                <div class="masha-service-icon">
                    <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                </div>
                <div class="masha-service-info">
                    <h3>Service Client</h3>
                    <p>9h - 18h</p>
                </div>
            </div>
            <div class="masha-service-box">
                <div class="masha-service-icon">
                    <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2" />
                        <line x1="1" y1="10" x2="23" y2="10" />
                        <path d="M5 15h2" />
                        <path d="M10 15h4" />
                    </svg>
                </div>
                <div class="masha-service-info">
                    <h3>Paiement Sécurisé</h3>
                    <p>En ligne ou à la livraison</p>
                </div>
            </div>
            <div class="masha-service-box">
                <div class="masha-service-icon">
                    <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
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
get_footer();
