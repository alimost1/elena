<?php
/**
 * Elena Front Page Router
 * 
 * Routes to language-specific templates to allow each language
 * to have its own dedicated template file.
 *
 * @package Elena
 */

$locale = get_locale();
$lang_param = isset( $_GET['lang'] ) ? $_GET['lang'] : '';

if ( strpos( $locale, 'fr' ) === 0 || strpos( strtolower( $lang_param ), 'fr' ) === 0 ) {
    // Load French Template
    $template = locate_template( 'template-front-page-fr.php' );
    if ( $template ) {
        include( $template );
    }
} elseif ( strpos( $locale, 'ar' ) === 0 || strpos( strtolower( $lang_param ), 'ar' ) === 0 ) {
    // Load Arabic Template
    $template = locate_template( 'template-front-page-ar.php' );
    if ( $template ) {
        include( $template );
    }
} else {
    // Load English Template (Default)
    $template = locate_template( 'template-front-page-en.php' );
    if ( $template ) {
        include( $template );
    }
}
