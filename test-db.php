<?php
$mysqli = new mysqli('localhost', 'root', 'root', 'local');

if ($mysqli->connect_error) {
    echo "Connection failed (localhost): " . $mysqli->connect_error . "\n";
    $mysqli = new mysqli('127.0.0.1', 'root', 'root', 'local');
    if ($mysqli->connect_error) {
        echo "Connection failed (127.0.0.1): " . $mysqli->connect_error . "\n";
    } else {
        echo "Connection success (127.0.0.1)\n";
    }
} else {
    echo "Connection success (localhost)\n";
}
?>
