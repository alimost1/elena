<?php
/**
 * Front page language router - use Machaussure reference layout.
 *
 * @package Elena
 */

defined( 'ABSPATH' ) || exit;

$lang = '';
if ( isset( $_GET['lang'] ) ) {
	$lang = strtolower( sanitize_text_field( wp_unslash( $_GET['lang'] ) ) );
} elseif ( function_exists( 'xili_curlang' ) ) {
	$lang = strtolower( (string) xili_curlang() );
} elseif ( function_exists( 'the_curlang' ) ) {
	$lang = strtolower( (string) the_curlang() );
}
$locale = strtolower( get_locale() );

$masha_theme_dir = trailingslashit( get_theme_root() ) . 'mashaussure/';

if ( strpos( $lang, 'ar' ) === 0 || strpos( $locale, 'ar' ) === 0 ) {
	$template = $masha_theme_dir . 'template-front-page-ar.php';
} elseif ( strpos( $lang, 'en' ) === 0 || strpos( $locale, 'en' ) === 0 ) {
	$template = $masha_theme_dir . 'template-front-page-en.php';
} else {
	$template = $masha_theme_dir . 'template-front-page-fr.php';
}

if ( file_exists( $template ) ) {
	include $template;
	return;
}

get_header();
echo '<div class="elena-container" style="padding:40px 20px;">';
echo '<h1>Homepage template is unavailable.</h1>';
echo '</div>';
get_footer();
