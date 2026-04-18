<?php
require('wp-load.php');
$terms = get_terms(['taxonomy'=>'product_cat', 'hide_empty'=>false]);
echo "<h1>Categories:</h1><ul>";
foreach($terms as $t){
    $lang = get_term_meta($t->term_id, 'category_language', true);
    echo "<li>" . esc_html($t->name) . " - Lang: " . esc_html($lang) . " (" . $t->count . " products)</li>";
}
echo "</ul>";
