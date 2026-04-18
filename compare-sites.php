<?php
$macha = file_get_contents('https://machaussure.ma/');
$elena = file_get_contents('http://elena.local/');

echo "Machaussure.ma bytes: " . strlen($macha) . "\n";
echo "Elena.local bytes: " . strlen($elena) . "\n";

// Look for Elementor or specific wrappers
if (strpos($macha, 'elementor') !== false) {
    echo "Machaussure uses Elementor.\n";
}
if (strpos($elena, 'elementor') !== false) {
    echo "Elena.local uses Elementor.\n";
}

// Compare Header tags
preg_match('/<header[^>]*>/', $macha, $m_h);
preg_match('/<header[^>]*>/', $elena, $e_h);
echo "Machaussure Header: " . ($m_h[0] ?? 'none') . "\n";
echo "Elena Header: " . ($e_h[0] ?? 'none') . "\n";

// Compare main sections
preg_match_all('/<section[^>]*class=["\']([^"\']*)["\'][^>]*>/', $macha, $m_sec);
preg_match_all('/<section[^>]*class=["\']([^"\']*)["\'][^>]*>/', $elena, $e_sec);

echo "\nMachaussure Sections (first 5):\n";
foreach (array_slice($m_sec[1], 0, 5) as $s) echo "- $s\n";

echo "\nElena Sections (first 5):\n";
foreach (array_slice($e_sec[1], 0, 5) as $s) echo "- $s\n";
