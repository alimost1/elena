<?php
$masha_css_path = __DIR__ . '/wp-content/themes/mashaussure/assets/css/main.css';
$elena_css_path = __DIR__ . '/wp-content/themes/elena/assets/css/main.css';

$masha_css = file_get_contents($masha_css_path);
$elena_css = file_get_contents($elena_css_path);

// Extract from masha
$masha_start = strpos($masha_css, '/* ═══════════════════════════════════════════════' . "\n" . '   WooCommerce Single Product (machaussure.ma style)');
if ($masha_start === false) {
    // Try \r\n
    $masha_start = strpos($masha_css, '/* ═══════════════════════════════════════════════' . "\r\n" . '   WooCommerce Single Product (machaussure.ma style)');
}

$masha_end = strpos($masha_css, '/* ═══════════════════════════════════════════════' . "\n" . '   Print Styles');
if ($masha_end === false) {
    $masha_end = strpos($masha_css, '/* ═══════════════════════════════════════════════' . "\r\n" . '   Print Styles');
}

if ($masha_start !== false) {
    $masha_block = ($masha_end !== false) ? substr($masha_css, $masha_start, $masha_end - $masha_start) : substr($masha_css, $masha_start);
    
    // Replace in elena
    $elena_start = strpos($elena_css, '/* ═══════════════════════════════════════════════' . "\n" . '   WooCommerce Single Product (elena.ma style)');
    if ($elena_start === false) {
        $elena_start = strpos($elena_css, '/* ═══════════════════════════════════════════════' . "\r\n" . '   WooCommerce Single Product (elena.ma style)');
    }
    
    if ($elena_start !== false) {
        $elena_new = substr($elena_css, 0, $elena_start) . $masha_block;
        // See if there's a print styles block to append back
        $elena_print = strpos($elena_css, '/* ═══════════════════════════════════════════════' . "\n" . '   Print Styles', $elena_start);
        if ($elena_print === false) {
             $elena_print = strpos($elena_css, '/* ═══════════════════════════════════════════════' . "\r\n" . '   Print Styles', $elena_start);
        }
        if ($elena_print !== false) {
            $elena_new .= substr($elena_css, $elena_print);
        }
        file_put_contents($elena_css_path, $elena_new);
        echo "CSS Copied successfully.\n";
    } else {
        echo "Could not find target in elena CSS\n";
    }
} else {
    echo "Could not find source block in masha CSS\n";
}

// Now handle functions.php
$masha_func_path = __DIR__ . '/wp-content/themes/mashaussure/functions.php';
$elena_func_path = __DIR__ . '/wp-content/themes/elena/functions.php';

$masha_func = file_get_contents($masha_func_path);
$elena_func = file_get_contents($elena_func_path);

// Check if hooks already exist in elena
if (strpos($elena_func, 'masha_add_buy_now_button') === false && strpos($elena_func, 'elena_add_buy_now_button') === false) {
    // Extract the relevant functions from masha. They are usually at the end.
    $hooks_start = strpos($masha_func, "/* ─────────────────────────────────────────────\n * 13. Single Product Adjustments");
    if ($hooks_start === false) {
        $hooks_start = strpos($masha_func, "/* ─────────────────────────────────────────────\r\n * 13. Single Product Adjustments");
    }
    
    if ($hooks_start !== false) {
        $hooks_code = substr($masha_func, $hooks_start);
        // Rename masha_ prefixes to elena_
        // NOT STRICTLY NECESSARY but good practice. I will just leave them as-is to avoid breaking logic.
        file_put_contents($elena_func_path, $elena_func . "\n\n" . $hooks_code);
        echo "Functions Copied successfully.\n";
    } else {
         echo "Could not find hooks in masha functions.php\n";
    }
} else {
    echo "Hooks already seem to be in elena/functions.php\n";
}
