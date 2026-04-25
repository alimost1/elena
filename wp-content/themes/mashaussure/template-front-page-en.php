<?php
/**
 * Template Name: Front Page English
 * Machaussure.ma Homepage – English version
 *
 * @package Mashaussure
 */

get_header();

$theme_uri = get_template_directory_uri();
$shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
$hero_image = get_theme_mod('elena_hero_image', '');
$featured_img = get_the_post_thumbnail_url(get_the_ID(), 'full');
$hero_bg = $featured_img ? $featured_img : ($hero_image ? $hero_image : $theme_uri . '/assets/images/hero-bg.png');
$xl_lang = function_exists('elena_current_lang_slug') ? elena_current_lang_slug() : (function_exists('xili_curlang') ? strtolower((string) xili_curlang()) : 'en_us');
if ('fr' === $xl_lang) {
    $xl_lang = 'fr_fr';
} elseif ('en' === $xl_lang) {
    $xl_lang = 'en_us';
} elseif ('ar' === $xl_lang) {
    $xl_lang = 'ar_ar';
}
$homepage_category_terms = array();
$products_for_cats = get_posts(
    array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => 300,
        'fields' => 'ids',
        'lang' => $xl_lang,
        'suppress_filters' => false,
        'no_found_rows' => true,
    )
);
if (!empty($products_for_cats)) {
    $homepage_category_terms = wp_get_object_terms(
        $products_for_cats,
        'product_cat',
        array(
            'orderby' => 'count',
            'order' => 'DESC',
            'hide_empty' => true,
            'exclude' => array((int) get_option('default_product_cat')),
        )
    );
    if (is_wp_error($homepage_category_terms)) {
        $homepage_category_terms = array();
    }
}
$tabs_categories = array();
if (!empty($homepage_category_terms)) {
    foreach ($homepage_category_terms as $tabs_category) {
        if (preg_match('/\p{Arabic}/u', (string) $tabs_category->name)) {
            continue;
        }
        $tabs_categories[] = $tabs_category;
        if (count($tabs_categories) >= 3) {
            break;
        }
    }
}
?>

<!-- ═══════════ HERO SLIDER ═══════════ -->
<section class="masha-hero-slider" id="hero">
    <div class="masha-slider-track">
        <div class="masha-slide active">
            <img src="<?php echo esc_url($hero_bg); ?>" alt="New Collection" class="masha-slide-img">
            <div class="masha-slide-overlay">
                <a href="<?php echo esc_url($shop_url); ?>" class="masha-slide-btn">Shop Now</a>
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
            $categories = array();
            if (!empty($homepage_category_terms)) {
                foreach ($homepage_category_terms as $category_term) {
                    if (preg_match('/\p{Arabic}/u', (string) $category_term->name)) {
                        continue;
                    }
                    $categories[] = $category_term;
                    if (count($categories) >= 8) {
                        break;
                    }
                }
            }
            if (!empty($categories)) {
                foreach ($categories as $cat) {
                    $thumb_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
                    $thumb_url = $thumb_id ? wp_get_attachment_url($thumb_id) : '';

                    // Use premium generated placeholders if no image uploaded
                    if (!$thumb_url) {
                        $cat_n = strtolower($cat->name);
                        if (strpos($cat_n, 'escarpin') !== false || strpos($cat_n, 'heels') !== false)
                            $thumb_url = $theme_uri . '/assets/images/categories/heels.png';
                        elseif (strpos($cat_n, 'mocassin') !== false || strpos($cat_n, 'bateau') !== false || strpos($cat_n, 'mule') !== false || strpos($cat_n, 'derbies') !== false || strpos($cat_n, 'loafers') !== false)
                            $thumb_url = $theme_uri . '/assets/images/categories/loafers.png';
                        elseif (strpos($cat_n, 'sac') !== false || strpos($cat_n, 'bag') !== false)
                            $thumb_url = $theme_uri . '/assets/images/categories/bag.png';
                        elseif (strpos($cat_n, 'fille') !== false || strpos($cat_n, 'garçon') !== false || strpos($cat_n, 'enfant') !== false || strpos($cat_n, 'kids') !== false)
                            $thumb_url = $theme_uri . '/assets/images/categories/kids.png';
                        else
                            $thumb_url = $theme_uri . '/assets/images/categories/heels.png';
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
                    <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.2">
                        <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2" />
                        <path d="M15 18H9" />
                        <path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14v10" />
                        <circle cx="17" cy="18" r="2" />
                        <circle cx="7" cy="18" r="2" />
                    </svg>
                </div>
                <h3>Worldwide Delivery</h3>
                <p>+1400 Destinations</p>
            </div>
            <div class="masha-benefit-divider"></div>
            <div class="masha-benefit-item">
                <div class="masha-benefit-icon">
                    <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.2">
                        <path
                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                </div>
                <h3>Customer Service</h3>
                <p>9am - 6pm</p>
            </div>
            <div class="masha-benefit-divider"></div>
            <div class="masha-benefit-item">
                <div class="masha-benefit-icon">
                    <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.2">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2" />
                        <line x1="1" y1="10" x2="23" y2="10" />
                        <path d="M5 15h2" />
                        <path d="M10 15h4" />
                    </svg>
                </div>
                <h3>Secure Payment</h3>
                <p>Online or on delivery</p>
            </div>
            <div class="masha-benefit-divider"></div>
            <div class="masha-benefit-item">
                <div class="masha-benefit-icon">
                    <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                    </svg>
                </div>
                <h3>Fast Delivery</h3>
                <p>&nbsp;</p>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════ NOS COUPS DE COEUR ═══════════ -->
<?php if (class_exists('WooCommerce')): ?>
    <section class="masha-coups-section elena-section" id="coups-de-coeur">
        <div class="elena-container">
            <div class="masha-coups-header">
                <h2 class="masha-coups-title">Our Favorites ❤️</h2>
            </div>
            <div class="masha-coups-layout">
                <div class="masha-coups-left">
                    <?php
                    $args_featured = array(
                        'post_type' => 'product',
                        'posts_per_page' => 1,
                        'meta_key' => 'total_sales',
                        'orderby' => 'meta_value_num',
                        'order' => 'DESC',
                        'lang' => $xl_lang,
                    );
                    $featured = new WP_Query($args_featured);
                    if ($featured->have_posts()) {
                        $featured->the_post();
                        global $product;
                        $product = wc_get_product(get_the_ID());
                        $sale_badge = masha_fp_get_sale_badge($product);
                        $is_new = masha_fp_is_new_product($product);
                        $size_attrs = masha_fp_get_size_attributes($product);
                        ?>
                        <div class="masha-featured-card">
                            <a href="<?php echo esc_url($product->get_permalink()); ?>" class="masha-fc-link">
                                <div class="masha-fc-image">
                                    <?php echo $product->get_image('woocommerce_single'); ?>
                                    <?php if ($sale_badge): ?><span
                                            class="elena-sale-badge elena-sale-badge-black"><?php echo esc_html($sale_badge); ?></span><?php endif; ?>
                                    <?php if ($is_new): ?><span
                                            class="elena-new-badge elena-new-badge-green">NEW</span><?php endif; ?>
                                </div>
                                <div class="masha-fc-content">
                                    <h3 class="masha-fc-title"><?php echo get_the_title(); ?></h3>
                                    <?php if (!empty($size_attrs)): ?>
                                        <div class="elena-product-sizes masha-fc-sizes">
                                            <?php foreach ($size_attrs as $s): ?><span
                                                    class="elena-size-option"><?php echo esc_html($s); ?></span><?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="elena-product-price masha-fc-price"><?php echo $product->get_price_html(); ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php
                    }
                    wp_reset_postdata();
                    ?>
                </div>
                <div class="masha-coups-right">
                    <ul class="masha-coups-tabs">
                        <?php foreach ($tabs_categories as $tab_index => $tab_category): ?>
                            <li class="<?php echo 0 === $tab_index ? 'active' : ''; ?>" data-tab-cat="<?php echo esc_attr($tab_category->slug); ?>">
                                <?php echo esc_html(strtoupper($tab_category->name)); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="masha-coups-grid">
                        <?php foreach ($tabs_categories as $tab_index => $tab_category): ?>
                            <ul class="elena-products-grid masha-right-products masha-tab-panel<?php echo 0 === $tab_index ? ' is-active' : ''; ?>"
                                data-tab-cat="<?php echo esc_attr($tab_category->slug); ?>"<?php echo 0 === $tab_index ? '' : ' style="display:none;"'; ?>>
                                <?php
                                $args_grid = array(
                                    'post_type' => 'product',
                                    'posts_per_page' => 6,
                                    'meta_key' => 'total_sales',
                                    'orderby' => 'meta_value_num',
                                    'order' => 'DESC',
                                    'lang' => $xl_lang,
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'product_cat',
                                            'field' => 'slug',
                                            'terms' => array($tab_category->slug),
                                        ),
                                    ),
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
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="elena-section-footer" style="margin-top: 2rem;">
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="elena-link-arrow">
                    View all products
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
                <h2 class="masha-coups-title">Authentic Style 🖤</h2>
            </div>
            <div class="masha-coups-layout">
                <div class="masha-coups-left">
                    <?php
                    $args_men = array('post_type' => 'product', 'posts_per_page' => 1, 'offset' => 2, 'meta_key' => 'total_sales', 'orderby' => 'meta_value_num', 'order' => 'DESC', 'lang' => $xl_lang);
                    $men_featured = new WP_Query($args_men);
                    if ($men_featured->have_posts()) {
                        $men_featured->the_post();
                        global $product;
                        $product = wc_get_product(get_the_ID());
                        $sale_badge = masha_fp_get_sale_badge($product);
                        $is_new = masha_fp_is_new_product($product);
                        $size_attrs = masha_fp_get_size_attributes($product);
                        ?>
                        <div class="masha-featured-card">
                            <a href="<?php echo esc_url($product->get_permalink()); ?>" class="masha-fc-link">
                                <div class="masha-fc-image">
                                    <?php echo $product->get_image('woocommerce_single'); ?>
                                    <?php if ($sale_badge): ?><span
                                            class="elena-sale-badge elena-sale-badge-black"><?php echo esc_html($sale_badge); ?></span><?php endif; ?>
                                    <?php if ($is_new): ?><span
                                            class="elena-new-badge elena-new-badge-green">NEW</span><?php endif; ?>
                                </div>
                                <div class="masha-fc-content">
                                    <h3 class="masha-fc-title"><?php echo get_the_title(); ?></h3>
                                    <?php if (!empty($size_attrs)): ?>
                                        <div class="elena-product-sizes masha-fc-sizes">
                                            <?php foreach ($size_attrs as $s): ?><span
                                                    class="elena-size-option"><?php echo esc_html($s); ?></span><?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="elena-product-price masha-fc-price"><?php echo $product->get_price_html(); ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php
                    }
                    wp_reset_postdata();
                    ?>
                </div>
                <div class="masha-coups-right">
                    <ul class="masha-coups-tabs">
                        <?php foreach ($tabs_categories as $tab_index => $tab_category): ?>
                            <li class="<?php echo 0 === $tab_index ? 'active' : ''; ?>" data-tab-cat="<?php echo esc_attr($tab_category->slug); ?>">
                                <?php echo esc_html(strtoupper($tab_category->name)); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="masha-coups-grid">
                        <?php foreach ($tabs_categories as $tab_index => $tab_category): ?>
                            <ul class="elena-products-grid masha-right-products masha-tab-panel<?php echo 0 === $tab_index ? ' is-active' : ''; ?>"
                                data-tab-cat="<?php echo esc_attr($tab_category->slug); ?>"<?php echo 0 === $tab_index ? '' : ' style="display:none;"'; ?>>
                                <?php
                                $args_men_grid = array(
                                    'post_type' => 'product',
                                    'posts_per_page' => 6,
                                    'meta_key' => 'total_sales',
                                    'orderby' => 'meta_value_num',
                                    'order' => 'DESC',
                                    'lang' => $xl_lang,
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'product_cat',
                                            'field' => 'slug',
                                            'terms' => array($tab_category->slug),
                                        ),
                                    ),
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
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="elena-section-footer" style="margin-top: 2rem;">
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="elena-link-arrow">
                    View all products
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
    style="background-image: url('<?php echo esc_url($theme_uri . '/assets/images/store-interior.jpg'); ?>'); background-size: cover; background-position: center; background-attachment: fixed;">
    <div class="masha-store-banner-overlay">
        <div class="elena-container">
            <p class="masha-store-banner-text">Discover Elena.ma, your destination for the best exclusive offers online and in-store!</p>
        </div>
    </div>
</section>


<!-- ═══════════ SERVICES GRID (Black Pre-Footer) ═══════════ -->
<section class="masha-services-section elena-section" id="services">
    <div class="elena-container">
        <div class="masha-services-grid">
            <div class="masha-service-box">
                <div class="masha-service-icon"><svg width="52" height="52" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.2">
                        <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2" />
                        <path d="M15 18H9" />
                        <path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14v10" />
                        <circle cx="17" cy="18" r="2" />
                        <circle cx="7" cy="18" r="2" />
                    </svg></div>
                <div class="masha-service-info">
                    <h3>Worldwide Delivery</h3>
                    <p>+1400 Destinations</p>
                </div>
            </div>
            <div class="masha-service-box">
                <div class="masha-service-icon"><svg width="52" height="52" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.2">
                        <path
                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg></div>
                <div class="masha-service-info">
                    <h3>Customer Service</h3>
                    <p>9am - 6pm</p>
                </div>
            </div>
            <div class="masha-service-box">
                <div class="masha-service-icon"><svg width="52" height="52" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.2">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2" />
                        <line x1="1" y1="10" x2="23" y2="10" />
                        <path d="M5 15h2" />
                        <path d="M10 15h4" />
                    </svg></div>
                <div class="masha-service-info">
                    <h3>Secure Payment</h3>
                    <p>Online or on delivery</p>
                </div>
            </div>
            <div class="masha-service-box">
                <div class="masha-service-icon"><svg width="52" height="52" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                    </svg></div>
                <div class="masha-service-info">
                    <h3>Fast Delivery</h3>
                    <p>&nbsp;</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
