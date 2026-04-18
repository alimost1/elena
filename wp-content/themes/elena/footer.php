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
if (isset($_GET['lang'])) {
	$locale = sanitize_text_field($_GET['lang']);
}
?>

<!-- Service features bar (SVG icons) -->
<div class="elena-footer-services">
	<div class="elena-container elena-services-grid">
		<div class="elena-service-item">
			<span class="elena-service-icon">
				<svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
					stroke-linecap="round" stroke-linejoin="round">
					<rect x="1" y="3" width="15" height="13" />
					<polygon points="16 8 20 8 23 11 23 16 16 16 16 8" />
					<circle cx="5.5" cy="18.5" r="2.5" />
					<circle cx="18.5" cy="18.5" r="2.5" />
				</svg>
			</span>
			<h4><?php echo (strpos($locale, 'ar') === 0) ? 'توصيل في كل مكان' : esc_html__('Livraison Partout', 'elena'); ?>
			</h4>
			<p>+1400
				<?php echo (strpos($locale, 'ar') === 0) ? 'وجهة' : esc_html__('Destinations', 'elena'); ?></p>
		</div>
		<div class="elena-service-item">
			<span class="elena-service-icon">
				<svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
					stroke-linecap="round" stroke-linejoin="round">
					<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
					<circle cx="9" cy="7" r="4" />
					<path d="M23 21v-2a4 4 0 0 0-3-3.87" />
					<path d="M16 3.13a4 4 0 0 1 0 7.75" />
				</svg>
			</span>
			<h4><?php echo (strpos($locale, 'ar') === 0) ? 'خدمة العملاء' : esc_html__('Service Client', 'elena'); ?>
			</h4>
			<p><?php echo (strpos($locale, 'ar') === 0) ? '9ص - 6م' : '9h - 18h'; ?></p>
		</div>
		<div class="elena-service-item">
			<span class="elena-service-icon">
				<svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
					stroke-linecap="round" stroke-linejoin="round">
					<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
					<path d="M9 12l2 2 4-4" />
				</svg>
			</span>
			<h4><?php echo (strpos($locale, 'ar') === 0) ? 'دفع آمن' : esc_html__('Paiement Sécurisé', 'elena'); ?>
			</h4>
			<p><?php echo (strpos($locale, 'ar') === 0) ? 'عبر الإنترنت أو عند التسليم' : esc_html__('En ligne ou à la livraison', 'elena'); ?>
			</p>
		</div>
		<div class="elena-service-item">
			<span class="elena-service-icon">
				<svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
					stroke-linecap="round" stroke-linejoin="round">
					<circle cx="12" cy="12" r="10" />
					<polyline points="12 6 12 12 16 14" />
				</svg>
			</span>
			<h4><?php echo (strpos($locale, 'ar') === 0) ? 'توصيل سريع' : esc_html__('Livraison Rapide', 'elena'); ?>
			</h4>
			<p><?php echo (strpos($locale, 'ar') === 0) ? 'تحت 48 ساعة' : esc_html__('Sous 48h', 'elena'); ?>
			</p>
		</div>
	</div>
</div>

<!-- Newsletter Section -->
<section class="elena-newsletter-section">
	<div class="elena-container">
		<div class="elena-newsletter-inner">
			<h3 class="elena-newsletter-title">
				<?php echo (strpos($locale, 'ar') === 0) ? 'انضم إلى عائلة إيلينا' : esc_html__('Rejoignez la Famille Elena', 'elena'); ?>
			</h3>
			<p class="elena-newsletter-subtitle">
				<?php echo (strpos($locale, 'ar') === 0) ? 'احصل على عروضنا الحصرية والجديد مباشرة في صندوق الوارد الخاص بك.' : esc_html__('Recevez nos offres exclusives et nouveautés directement dans votre boîte mail.', 'elena'); ?>
			</p>
			<form class="elena-newsletter-form" action="#" method="post">
				<input type="email"
					placeholder="<?php echo (strpos($locale, 'ar') === 0) ? 'بريدك الإلكتروني' : esc_attr__('Votre adresse email', 'elena'); ?>"
					name="elena_email" aria-label="Email" required>
				<button
					type="submit"><?php echo (strpos($locale, 'ar') === 0) ? 'اشترك' : esc_html__("S'inscrire", 'elena'); ?></button>
			</form>
			<p class="elena-newsletter-privacy">
				<?php echo (strpos($locale, 'ar') === 0) ? 'نحن نحترم خصوصيتك.' : esc_html__('Nous respectons votre vie privée.', 'elena'); ?>
			</p>
		</div>
	</div>
</section>

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
			<div class="elena-footer-col">
				<h4><?php echo (strpos($locale, 'ar') === 0) ? 'فروعنا' : esc_html__('Nos Boutiques', 'elena'); ?>
				</h4>
				<ul>
					<li><a
							href="#"><?php echo (strpos($locale, 'ar') === 0) ? 'فرع المعاريف' : esc_html__('Boutique Maarif', 'elena'); ?></a>
					</li>
					<li><a
							href="#"><?php echo (strpos($locale, 'ar') === 0) ? 'فرع عين الشق' : esc_html__('Boutique Ain Chock', 'elena'); ?></a>
					</li>
					<li><a
							href="#"><?php echo (strpos($locale, 'ar') === 0) ? 'فرع الألفة' : esc_html__('Boutique Oulfa', 'elena'); ?></a>
					</li>
					<li><a
							href="#"><?php echo (strpos($locale, 'ar') === 0) ? 'موروكو مول' : esc_html__('Morocco Mall', 'elena'); ?></a>
					</li>
				</ul>
			</div>
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
				<?php echo ($localestrpos($locale, 'ar') === 0) ? 'جميع الحقوق محفوظة.' : esc_html__('Tous droits réservés.', 'elena'); ?>
			</p>
		</div>
	</div>
</footer>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>

</html>