<?php
// trigger_deploy.php
include "vendor/autoload.php";
$app = require_once "bootstrap/app.php";
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Application UUID for Elena
$uuid = "josgk00c0ook04cs8cck00c4";

$application = App\Models\Application::where("uuid", $uuid)->first();

if ($application) {
    echo "Found application: " . $application->name . "\n";
    echo "Triggering deployment...\n";
    $app->make(App\Actions\Application\DeployApplication::class)->run($application, "");
    echo "Success!\n";
} else {
    echo "Error: Application with UUID '$uuid' not found.\n";
    exit(1);
}
