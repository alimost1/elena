<?php
/**
 * Elena Theme Footer – Machaussure.ma style
 * Service blocks + black footer columns + social + payments.
 *
 * @package Elena
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

	</main><!-- #content -->

	<!-- Service features bar -->
	<div class="elena-footer-services">
		<div class="elena-container elena-services-grid">
			<div class="elena-service-item">
				<span class="elena-service-icon">🚚</span>
				<h4><?php esc_html_e( 'Livraison Partout', 'elena' ); ?></h4>
				<p>+1400 <?php esc_html_e( 'Destinations', 'elena' ); ?></p>
			</div>
			<div class="elena-service-item">
				<span class="elena-service-icon">🎧</span>
				<h4><?php esc_html_e( 'Service Client', 'elena' ); ?></h4>
				<p>9h - 18h</p>
			</div>
			<div class="elena-service-item">
				<span class="elena-service-icon">💳</span>
				<h4><?php esc_html_e( 'Paiement Sécurisé', 'elena' ); ?></h4>
				<p><?php esc_html_e( 'En ligne ou à la livraison', 'elena' ); ?></p>
			</div>
			<div class="elena-service-item">
				<span class="elena-service-icon">📦</span>
				<h4><?php esc_html_e( 'Livraison Rapide', 'elena' ); ?></h4>
				<p><?php esc_html_e( 'Sous 48h', 'elena' ); ?></p>
			</div>
		</div>
	</div>

	<footer class="elena-footer elena-footer-dark">
		<div class="elena-container">
			<div class="elena-footer-columns">
				<div class="elena-footer-col">
					<h4><?php esc_html_e( 'Catégories', 'elena' ); ?></h4>
					<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
						<?php dynamic_sidebar( 'footer-1' ); ?>
					<?php else : ?>
						<ul>
							<li><a href="#"><?php esc_html_e( 'Bottines Femmes', 'elena' ); ?></a></li>
							<li><a href="#"><?php esc_html_e( 'Boots Hommes', 'elena' ); ?></a></li>
							<li><a href="#"><?php esc_html_e( 'Mocassins femmes', 'elena' ); ?></a></li>
							<li><a href="#"><?php esc_html_e( 'Escarpins', 'elena' ); ?></a></li>
							<li><a href="#"><?php esc_html_e( 'Baskets Femmes', 'elena' ); ?></a></li>
							<li><a href="#"><?php esc_html_e( 'Baskets Hommes', 'elena' ); ?></a></li>
						</ul>
					<?php endif; ?>
				</div>
				<div class="elena-footer-col">
					<h4>Business</h4>
					<ul>
						<li><a href="#"><?php esc_html_e( 'Acheter en Gros', 'elena' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'Devenir franchiseur', 'elena' ); ?></a></li>
					</ul>
				</div>
				<div class="elena-footer-col">
					<h4><?php esc_html_e( 'Nos boutiques', 'elena' ); ?></h4>
					<ul>
						<li><a href="#"><?php esc_html_e( 'Boutique Maarif', 'elena' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'Boutique Ain Chock', 'elena' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'Boutique Oulfa', 'elena' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'Morocco Mall', 'elena' ); ?></a></li>
					</ul>
				</div>
				<div class="elena-footer-col">
					<h4><?php esc_html_e( 'Liens', 'elena' ); ?></h4>
					<ul>
						<li><a href="#"><?php esc_html_e( 'A Propos de Nous', 'elena' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'Politique d\'Échange', 'elena' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'Confidentialité', 'elena' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'CGV', 'elena' ); ?></a></li>
					</ul>
				</div>
			</div>

			<div class="elena-footer-bottom-bar">
				<div class="elena-footer-social">
					<span><?php esc_html_e( 'Suivre Machaussure.ma', 'elena' ); ?></span>
					<div class="elena-social-links">
						<?php $fb = get_theme_mod( 'elena_facebook', '#' ); $ig = get_theme_mod( 'elena_instagram', '#' ); ?>
						<?php if ( $fb ) : ?><a href="<?php echo esc_url( $fb ); ?>" target="_blank" rel="noopener" aria-label="Facebook"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a><?php endif; ?>
						<?php if ( $ig ) : ?><a href="<?php echo esc_url( $ig ); ?>" target="_blank" rel="noopener" aria-label="Instagram"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0z"/></svg></a><?php endif; ?>
					</div>
				</div>
				<div class="elena-footer-payments">
					<span><?php esc_html_e( 'Mode de Paiements', 'elena' ); ?></span>
					<span class="elena-payment-icons">VISA • CMI</span>
				</div>
				<div class="elena-footer-newsletter">
					<form class="elena-newsletter-form" action="#" method="post">
						<input type="email" placeholder="<?php esc_attr_e( 'Votre email', 'elena' ); ?>" name="elena_email" aria-label="Email">
						<button type="submit"><?php esc_html_e( 'S\'abonner', 'elena' ); ?></button>
					</form>
				</div>
			</div>

			<div class="elena-footer-bottom">
				<p>&copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'Tous droits réservés.', 'elena' ); ?></p>
			</div>
		</div>
	</footer>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
