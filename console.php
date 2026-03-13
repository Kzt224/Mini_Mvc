<?php
define('BASE_PATH', __DIR__);

use App\Database\Manager\ControllerManager;
use App\Database\Manager\MigrationManager;
use App\Database\Manager\ModelManager;

require __DIR__ . "/vendor/autoload.php";

$command = $argv[1] ?? null;
$params = array_slice($argv, 2);

if (!$command) {
    echo "No command found!\n";
    echo "Type help for all commands!\n";
    exit;
}

switch ($command) {
    case "make:migration":
        $name = $params[0] ?? null;
        $red = "\033[31m";
        $reset = "\033[0m";
        if (!$name) {
            echo $red . "Please provide a model name" . $reset . "\n";
            break;
        }
        MigrationManager::CreateMigration($name);
        break;
    case "make:model":
        $name = $params[0] ?? null;
        $red = "\033[31m";
        $reset = "\033[0m";
        if (!$name) {
            echo $red . "Please provide a migration name" . $reset . "\n";
            break;
        }
        ModelManager::CreateModel($name);
        break;
    case "make:controller":
        $name = $params[0] ?? null;
        $red = "\033[31m";
        $reset = "\033[0m";
        if (!$name) {
            echo $red . "Please provide a model name" . $reset . "\n";
            break;
        }
        ControllerManager::CreateController($name);
        break;

    case 'migrate':
        MigrationManager::runMigrations();
        break;

    case "help":
        $green = "\033[32m";
        $blue = "\033[34m";
        $yellow = "\033[33m";
        $reset = "\033[0m";

        echo $green . "make:migration" . $reset . " - create migration table\n";
        echo $green . "make:migrate" . $reset . " - run all migrations\n";
        echo $green . "make:controller" . $reset . " - create controller\n";
        echo $green . "make:model" . $reset . " - create model\n";
        break;

    default:
        echo "Unknown command: type help for all commands ($command)\n";
        break;
}
