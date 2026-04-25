<?php
/**
 * Elena Theme Footer – Premium fashion storefront
 * SVG service icons + newsletter + dark footer columns + social + payments.
 *
 * @package Elena
 */

if (!defined('ABSPATH')) {
	exit;
}
?>

</main><!-- #content -->

<?php
$locale = get_locale();
if ( function_exists( 'xili_curlang' ) ) {
	$locale = xili_curlang();
} elseif ( function_exists( 'the_curlang' ) ) {
	$locale = the_curlang();
} elseif (isset($_GET['lang'])) {
	$locale = sanitize_text_field($_GET['lang']);
}
?>

<footer class="elena-footer elena-footer-dark">
	<div class="elena-container">
		<div class="elena-footer-columns">
			<div class="elena-footer-col">
				<h4><?php echo (strpos($locale, 'ar') === 0) ? 'الأقسام' : esc_html__('Catégories', 'elena'); ?>
				</h4>
				<ul>
					<?php
					$lang_val = (strpos($locale, 'ar') === 0) ? 'ar' : ((strpos($locale, 'en_') === 0) ? 'en' : 'fr');
					$meta_query = array(
						'relation' => 'OR',
						array('key' => 'category_language', 'value' => $lang_val, 'compare' => '='),
						array('key' => 'category_language', 'value' => 'all', 'compare' => '=')
					);
					if ( $lang_val === 'fr' ) {
						$meta_query[] = array('key' => 'category_language', 'compare' => 'NOT EXISTS');
					}

					$cat_args = array(
						'taxonomy'   => 'product_cat',
						'hide_empty' => false,
						'orderby'    => 'count',
						'order'      => 'DESC',
						'number'     => 6,
						'meta_query' => $meta_query
					);
					if ( taxonomy_exists( 'product_cat' ) ) {
						$product_categories = get_terms( $cat_args );
						if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) {
							foreach ( $product_categories as $cat ) {
								echo '<li><a href="' . esc_url( get_term_link( $cat ) ) . '">' . esc_html( $cat->name ) . '</a></li>';
							}
						} else {
							// Fallback if no categories
							echo '<li><a href="#">' . ((strpos($locale, 'ar') === 0) ? 'أحذية رياضية نسائية' : esc_html__('Baskets Femmes', 'elena')) . '</a></li>';
							echo '<li><a href="#">' . ((strpos($locale, 'ar') === 0) ? 'أحذية رياضية رجالية' : esc_html__('Baskets Hommes', 'elena')) . '</a></li>';
							echo '<li><a href="#">' . ((strpos($locale, 'ar') === 0) ? 'موكاسين' : esc_html__('Mocassins', 'elena')) . '</a></li>';
						}
					}
					?>
				</ul>
			</div>
			<div class="elena-footer-col">
				<h4><?php echo (strpos($locale, 'ar') === 0) ? 'التسوق' : esc_html__('Shopping', 'elena'); ?>
				</h4>
				<ul>
					<li><a
							href="#"><?php echo (strpos($locale, 'ar') === 0) ? 'نساء' : esc_html__('Femmes', 'elena'); ?></a>
					</li>
					<li><a
							href="#"><?php echo (strpos($locale, 'ar') === 0) ? 'رجال' : esc_html__('Hommes', 'elena'); ?></a>
					</li>
					<li><a
							href="#"><?php echo (strpos($locale, 'ar') === 0) ? 'أطفال' : esc_html__('Enfants', 'elena'); ?></a>
					</li>
					<li><a
							href="#"><?php echo (strpos($locale, 'ar') === 0) ? 'جديد' : esc_html__('Nouveautés', 'elena'); ?></a>
					</li>
					<li><a
							href="#"><?php echo (strpos($locale, 'ar') === 0) ? 'عروض' : esc_html__('Promotions', 'elena'); ?></a>
					</li>
				</ul>
			</div>
			<?php if ( strpos( $locale, 'ar' ) !== 0 && strpos( $locale, 'fr' ) !== 0 ) : ?>
				<div class="elena-footer-col">
					<h4><?php esc_html_e( 'Nos Boutiques', 'elena' ); ?></h4>
					<ul>
						<li><a href="#"><?php esc_html_e( 'Boutique Maarif', 'elena' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'Boutique Ain Chock', 'elena' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'Boutique Oulfa', 'elena' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'Morocco Mall', 'elena' ); ?></a></li>
					</ul>
				</div>
			<?php endif; ?>
			<div class="elena-footer-col">
				<h4><?php echo (strpos($locale, 'ar') === 0) ? 'روابط' : esc_html__('Liens', 'elena'); ?></h4>
				<ul>
					<li><a
							href="#"><?php echo (strpos($locale, 'ar') === 0) ? 'من نحن' : esc_html__('À Propos de Nous', 'elena'); ?></a>
					</li>
					<li><a
							href="#"><?php echo (strpos($locale, 'ar') === 0) ? 'سياسة الاستبدال' : esc_html__("Politique d'Échange", 'elena'); ?></a>
					</li>
					<li><a
							href="#"><?php echo (strpos($locale, 'ar') === 0) ? 'الخصوصية' : esc_html__('Confidentialité', 'elena'); ?></a>
					</li>
					<li><a
							href="#"><?php echo (strpos($locale, 'ar') === 0) ? 'الشروط العامة' : esc_html__('CGV', 'elena'); ?></a>
					</li>
				</ul>
			</div>
		</div>

		<div class="elena-footer-bottom-bar">
			<div class="elena-footer-social">
				<span><?php echo (strpos($locale, 'ar') === 0) ? 'تابع Elena.ma' : esc_html__('Suivre Elena.ma', 'elena'); ?></span>
				<div class="elena-social-links">
					<?php $fb = get_theme_mod('elena_facebook', '#');
					$ig = get_theme_mod('elena_instagram', '#'); ?>
					<?php if ($fb): ?><a href="<?php echo esc_url($fb); ?>" target="_blank" rel="noopener"
							aria-label="Facebook"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
								<path
									d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
							</svg></a><?php endif; ?>
					<?php if ($ig): ?><a href="<?php echo esc_url($ig); ?>" target="_blank" rel="noopener"
							aria-label="Instagram"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
								<path
									d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0z" />
							</svg></a><?php endif; ?>
				</div>
			</div>
			<div class="elena-footer-payments">
				<span><?php echo (strpos($locale, 'ar') === 0) ? 'طرق الدفع' : esc_html__('Mode de Paiements', 'elena'); ?></span>
				<span class="elena-payment-icons">VISA • CMI • MASTERCARD</span>
			</div>
		</div>

		<div class="elena-footer-bottom">
			<p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.
				<?php echo (strpos($locale, 'ar') === 0) ? 'جميع الحقوق محفوظة.' : esc_html__('Tous droits réservés.', 'elena'); ?>
			</p>
		</div>
	</div>
</footer>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>

</html>