<?php
/**
 * Elena 404 Page Template
 *
 * @package Elena
 */

get_header();
?>

<div class="elena-page-content elena-section">
    <div class="elena-container" style="text-align: center; padding: 6rem 1.5rem;">
        <h1 class="elena-page-title" style="font-size: 5rem; color: var(--elena-orange); margin-bottom: 1rem;">404</h1>
        <h2 style="font-family: var(--elena-font-heading); margin-bottom: 1rem;">Page Not Found</h2>
        <p style="color: var(--elena-gray); max-width: 500px; margin: 0 auto 2rem;">
            <?php esc_html_e( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'elena' ); ?>
        </p>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="elena-btn elena-btn-primary">
            <?php esc_html_e( 'Back to Home', 'elena' ); ?>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        </a>
    </div>
</div>

<?php
get_footer();
