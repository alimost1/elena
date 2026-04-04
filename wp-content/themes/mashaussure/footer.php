<?php
/**
 * Machaussure Theme Footer
 * Matches machaussure.ma: 4-column layout + social + payments + newsletter
 *
 * @package Mashaussure
 */

if (!defined('ABSPATH')) {
	exit;
}
?>

</main><!-- #content -->

<footer class="elena-footer masha-footer">
	<div class="elena-container">
		<div class="masha-footer-columns">
			<!-- Column 1: Catégories -->
			<div class="masha-footer-col masha-footer-col-categories">
				<h4><?php 
                    $locale = get_locale();
                    if ($locale === 'ar') echo 'الأقسام';
                    elseif ($locale === 'en_US' || $locale === 'en_GB' || strpos($locale, 'en_') === 0) echo 'CATEGORIES';
                    else echo 'CATÉGORIES';
                ?></h4>
				<?php if (is_active_sidebar('footer-1')): ?>
					<?php dynamic_sidebar('footer-1'); ?>
				<?php else: ?>
					<ul>
						<li><a href="#"><?php 
                            if ($locale === 'ar') echo 'أحذية كاحل نسائية';
                            elseif (strpos($locale, 'en_') === 0) echo 'Women\'s Ankle Boots';
                            else echo 'Bottines Femmes';
                        ?></a></li>
						<li><a href="#"><?php 
                            if ($locale === 'ar') echo 'أحذية رجالية';
                            elseif (strpos($locale, 'en_') === 0) echo 'Men\'s Boots';
                            else echo 'Boots Hommes';
                        ?></a></li>
						<li><a href="#"><?php 
                            if ($locale === 'ar') echo 'موكاسين نسائي';
                            elseif (strpos($locale, 'en_') === 0) echo 'Women\'s Loafers';
                            else echo 'Mocassins femmes';
                        ?></a></li>
						<li><a href="#"><?php 
                            if ($locale === 'ar') echo 'موكاسين وأحذية قوارب';
                            elseif (strpos($locale, 'en_') === 0) echo 'Loafers & Boat Shoes';
                            else echo 'Mocassins et Chaussures Bateau';
                        ?></a></li>
						<li><a href="#"><?php 
                            if ($locale === 'ar') echo 'أحذية كلاسيكية';
                            elseif (strpos($locale, 'en_') === 0) echo 'Heels';
                            else echo 'Escarpins';
                        ?></a></li>
						<li><a href="#"><?php 
                            if ($locale === 'ar') echo 'أحذية مدينة';
                            elseif (strpos($locale, 'en_') === 0) echo 'City Shoes';
                            else echo 'Chaussures de ville';
                        ?></a></li>
						<li><a href="#"><?php 
                            if ($locale === 'ar') echo 'أحذية رياضية نسائية';
                            elseif (strpos($locale, 'en_') === 0) echo 'Women\'s Sneakers';
                            else echo 'Baskets Femmes';
                        ?></a></li>
						<li><a href="#"><?php 
                            if ($locale === 'ar') echo 'أحذية رياضية رجالية';
                            elseif (strpos($locale, 'en_') === 0) echo 'Men\'s Sneakers';
                            else echo 'Baskets Hommes';
                        ?></a></li>
						<li><a href="#"><?php 
                            if ($locale === 'ar') echo 'أحذية أطفال';
                            elseif (strpos($locale, 'en_') === 0) echo 'Kids\' Shoes';
                            else echo 'Chaussures Enfants';
                        ?></a></li>
					</ul>
				<?php endif; ?>
			</div>

			<!-- Column 2: Business + Nos Boutiques -->
			<div class="masha-footer-col">
				<h4><?php 
                    if ($locale === 'ar') echo 'الأعمال';
                    elseif (strpos($locale, 'en_') === 0) echo 'BUSINESS';
                    else echo 'BUSINESS';
                ?></h4>
				<ul>
					<li><a href="#"><?php 
                        if ($locale === 'ar') echo 'الشراء بالجملة';
                        elseif (strpos($locale, 'en_') === 0) echo 'Wholesale';
                        else echo 'Acheter en Gros';
                    ?></a></li>
					<li><a href="#"><?php 
                        if ($locale === 'ar') echo 'كن وكيلاً';
                        elseif (strpos($locale, 'en_') === 0) echo 'Become a Franchisee';
                        else echo 'Devenir franchiseur';
                    ?></a></li>
				</ul>

			</div>

			<!-- Column 3: Liens -->
			<div class="masha-footer-col">
				<h4><?php 
                    if ($locale === 'ar') echo 'روابط';
                    elseif (strpos($locale, 'en_') === 0) echo 'LINKS';
                    else echo 'LIENS';
                ?></h4>
				<ul>
					<li><a href="#"><?php 
                        if ($locale === 'ar') echo 'من نحن';
                        elseif (strpos($locale, 'en_') === 0) echo 'About Us';
                        else echo 'A Propos de Nous';
                    ?></a></li>
					<li><a href="#"><?php 
                        if ($locale === 'ar') echo 'سياسة الاستبدال';
                        elseif (strpos($locale, 'en_') === 0) echo 'Exchange Policy';
                        else echo 'Politique d\'Échange';
                    ?></a></li>
					<li><a href="#"><?php 
                        if ($locale === 'ar') echo 'الخصوصية';
                        elseif (strpos($locale, 'en_') === 0) echo 'Privacy';
                        else echo 'Confidentialité';
                    ?></a></li>
					<li><a href="#"><?php 
                        if ($locale === 'ar') echo 'الشروط العامة';
                        elseif (strpos($locale, 'en_') === 0) echo 'Terms & Conditions';
                        else echo 'CGV';
                    ?></a></li>
				</ul>
			</div>

			<!-- Column 4: Social + Payments + Newsletter -->
			<div class="masha-footer-col masha-footer-col-social">
				<h4><?php 
                    if ($locale === 'ar') echo 'تابع Elena.ma';
                    elseif (strpos($locale, 'en_') === 0) echo 'Follow Elena.ma';
                    else echo 'Suivre Elena.ma';
                ?></h4>
				<div class="masha-social-icons">
					<?php $fb = get_theme_mod('elena_facebook', '#');
					$ig = get_theme_mod('elena_instagram', '#'); ?>
					<?php if ($fb): ?>
						<a href="<?php echo esc_url($fb); ?>" target="_blank" rel="noopener" aria-label="Facebook"
							class="masha-social-icon">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
								<path
									d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
							</svg>
						</a>
					<?php endif; ?>
					<?php if ($ig): ?>
						<a href="<?php echo esc_url($ig); ?>" target="_blank" rel="noopener" aria-label="Instagram"
							class="masha-social-icon">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
								<path
									d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0z" />
							</svg>
						</a>
					<?php endif; ?>
					<a href="#" target="_blank" rel="noopener" aria-label="YouTube" class="masha-social-icon">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
							<path
								d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
						</svg>
					</a>
					<a href="#" target="_blank" rel="noopener" aria-label="Pinterest" class="masha-social-icon">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
							<path
								d="M12 0C5.373 0 0 5.372 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 0 1 .083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z" />
						</svg>
					</a>
					<a href="#" target="_blank" rel="noopener" aria-label="TikTok" class="masha-social-icon">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
							<path
								d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z" />
						</svg>
					</a>
				</div>

				<h4><?php 
                    if ($locale === 'ar') echo 'طرق الدفع';
                    elseif (strpos($locale, 'en_') === 0) echo 'Payment Methods';
                    else echo 'Mode de Paiements';
                ?></h4>
				<div class="masha-payment-badges">
					<span class="masha-payment-badge">CMI</span>
					<span class="masha-payment-badge">VISA</span>
					<span class="masha-payment-badge">MasterCard</span>
				</div>

				<h4><?php 
                    if ($locale === 'ar') echo 'اشترك';
                    elseif (strpos($locale, 'en_') === 0) echo 'Subscribe';
                    else echo 'S\'abonner';
                ?></h4>
				<form class="masha-newsletter-form" action="#" method="post">
					<input type="email" placeholder="<?php 
                        if ($locale === 'ar') echo 'بريدك الإلكتروني';
                        elseif (strpos($locale, 'en_') === 0) echo 'Your email';
                        else echo 'Votre email';
                    ?>" name="masha_email" aria-label="Email">
					<button type="submit"><?php 
                        if ($locale === 'ar') echo 'اشترك';
                        elseif (strpos($locale, 'en_') === 0) echo 'Subscribe';
                        else echo 'S\'abonner';
                    ?></button>
				</form>
			</div>
		</div>

		<div class="elena-footer-bottom masha-copyright">
			<p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php 
                if ($locale === 'ar') echo 'جميع الحقوق محفوظة.';
                elseif (strpos($locale, 'en_') === 0) echo 'All rights reserved.';
                else echo 'Tous droits réservés.';
            ?></p>
		</div>
	</div>
</footer>

<!-- Fixed bottom nav (mobile only) -->
<div class="masha-bottom-nav masha-mobile-only">
	<a href="<?php echo esc_url(home_url('/')); ?>"
		class="masha-bottom-nav-item<?php echo is_front_page() ? ' active' : ''; ?>">
		<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
			<path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
			<polyline points="9 22 9 12 15 12 15 22" />
		</svg>
		<span>Home</span>
	</a>
	<a href="<?php echo class_exists('WooCommerce') ? esc_url(wc_get_cart_url()) : '#'; ?>"
		class="masha-bottom-nav-item">
		<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
			<path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
			<line x1="3" y1="6" x2="21" y2="6" />
			<path d="M16 10a4 4 0 0 1-8 0" />
		</svg>
		<?php if (class_exists('WooCommerce') && WC()->cart->get_cart_contents_count() > 0): ?>
			<span class="masha-bottom-nav-badge"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
		<?php endif; ?>
		<span>Cart</span>
	</a>
	<a href="<?php echo class_exists('WooCommerce') ? esc_url(wc_get_page_permalink('shop')) : '#'; ?>"
		class="masha-bottom-nav-item">
		<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
			<rect x="3" y="3" width="7" height="7" />
			<rect x="14" y="3" width="7" height="7" />
			<rect x="3" y="14" width="7" height="7" />
			<rect x="14" y="14" width="7" height="7" />
		</svg>
		<span>Categories</span>
	</a>
</div>

</div><!-- #page -->

<!-- Scroll to top button -->
<button class="masha-scroll-top" id="masha-scroll-top" aria-label="Scroll to top">
	<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
		<polyline points="18 15 12 9 6 15" />
	</svg>
</button>

<?php wp_footer(); ?>
</body>

</html>