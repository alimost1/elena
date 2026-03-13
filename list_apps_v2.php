<?php
include "vendor/autoload.php";
$app = require_once "bootstrap/app.php";
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$applications = App\Models\Application::all();
foreach ($applications as $application) {
    echo "ID: " . $application->id . " | UUID: " . $application->uuid . "\n";
    echo "Name: " . $application->name . "\n";
    echo "FQDN: " . $application->fqdn . "\n";
    echo "Webhook: " . $application->deploy_webhook_url . "\n";
    echo "--------------------\n";
}
