<?php
define('WP_USE_THEMES', false);
require_once('wp-load.php');

$english_id = 2; // Sample Page
$slug = 'fr_FR';
$taxonomy = 'language';

// Check if french version already exists
$args = array(
    'post_type' => 'page',
    'title' => "Page d'exemple",
    'post_status' => 'publish',
    'numberposts' => 1
);
$existing = get_posts($args);

if ($existing) {
    $french_id = $existing[0]->ID;
    echo "French version already exists: ID $french_id\n";
} else {
    echo "Creating French version...\n";
    $french_post = array(
        'post_title' => "Page d'exemple",
        'post_content' => "<!-- wp:paragraph -->\n<p>Ceci est une page d'exemple. C'est différent d'un article de blog car elle restera au même endroit et apparaîtra dans la navigation de votre site (dans la plupart des thèmes). La plupart des gens commencent par une page À propos qui les présente aux visiteurs potentiels du site.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>En tant que nouvel utilisateur de WordPress, vous devriez aller sur <a href=\"http://elena.local/wp-admin/\">votre tableau de bord</a> pour supprimer cette page et créer de nouvelles pages pour votre contenu. Amusez-vous bien !</p>\n<!-- /wp:paragraph -->",
        'post_status' => 'publish',
        'post_type' => 'page'
    );
    $french_id = wp_insert_post($french_post);
    if (is_wp_error($french_id)) {
        echo "Error creating French version: " . $french_id->get_error_message() . "\n";
        exit;
    }
    echo "Created French ID $french_id\n";
}

// Set language for French post
wp_set_object_terms($french_id, $slug, $taxonomy);
echo "Set language of French post to $slug\n";

// Set language for English post if not set
wp_set_object_terms($english_id, 'en_US', $taxonomy);
echo "Set language of English post to en_US\n";

// Link them
$quetag = 'lang'; // Based on xili settings
update_post_meta($english_id, $quetag . '-fr_FR', $french_id);
update_post_meta($french_id, $quetag . '-en_US', $english_id);
echo "Linked posts: $english_id <-> $french_id\n";
?>
