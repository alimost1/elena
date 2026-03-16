<?php
/**
 * Search form – pill style with magnifying glass on the right (header).
 *
 * @package Elena
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="header-search-input"><?php echo esc_html_x( 'Search for:', 'label', 'elena' ); ?></label>
	<span class="header-search-field-wrap">
		<input type="search" name="s" id="header-search-input" class="header-search-input" placeholder="<?php echo esc_attr_x( 'Search for products', 'placeholder', 'elena' ); ?>" value="<?php echo get_search_query(); ?>" />
		<button type="submit" class="header-search-submit" aria-label="<?php echo esc_attr_x( 'Search', 'submit button', 'elena' ); ?>">
			<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
		</button>
	</span>
</form>
