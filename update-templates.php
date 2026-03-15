<?php
define('WP_USE_THEMES', false);
require('./wp-load.php');

$en_page_id = 2;
$fr_page_id = 64;

// Assign English template
update_post_meta($en_page_id, '_wp_page_template', 'template-front-page-en.php');
echo "Assigned template-front-page-en.php to Page $en_page_id\n";

// Assign French template
update_post_meta($fr_page_id, '_wp_page_template', 'template-front-page-fr.php');
echo "Assigned template-front-page-fr.php to Page $fr_page_id\n";

// Clear internal cache
clean_post_cache($en_page_id);
clean_post_cache($fr_page_id);

echo "Success!\n";
