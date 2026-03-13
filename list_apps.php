<?php
include "vendor/autoload.php";
$app = require_once "bootstrap/app.php";
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
foreach(App\Models\Application::all() as $a) {
    echo "App: " . $a->name . "\n";
    echo "UUID: " . $a->uuid . "\n";
    echo "FQDN: " . $a->fqdn . "\n";
    echo "Git Repo: " . $a->git_repository . "\n";
    echo "---------\n";
}
