<?php
$html = file_get_contents('http://localhost/product/new-balance-1000-retro-sneaker-pink-grey-lightweight-street-style-running-shoes/');
// save to file
file_put_contents('c:/Users/alimost/Local Sites/elena/app/public/page_dump.html', $html);
echo "dumped";
