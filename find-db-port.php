<?php
$host = '127.0.0.1';
$user = 'root';
$pass = 'root';
$db = 'local';

mysqli_report(MYSQLI_REPORT_OFF);
for ($port = 10000; $port <= 10100; $port++) {
    $mysqli = @new mysqli($host, $user, $pass, $db, $port);
    if (!$mysqli->connect_error) {
        echo "Found DB at port: $port\n";
        $mysqli->close();
        exit;
    }
}
echo "Could not find DB port in range 10000-10100\n";

// Try standard ports too
$standard_ports = [3306, 3307, 8889];
foreach ($standard_ports as $port) {
    $mysqli = @new mysqli($host, $user, $pass, $db, $port);
    if (!$mysqli->connect_error) {
        echo "Found DB at standard port: $port\n";
        $mysqli->close();
        exit;
    }
}
?>
