<?php
session_start();
define('BASE_PATH', dirname(__DIR__));
require "../vendor/autoload.php";
require __DIR__ ."/../app/helpers/helpers.php";
use App\Core\Router;
use Dotenv\Dotenv;


$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$app_name = $_ENV['APP_NAME'];
$cut_path = "/" . $app_name . "/public";
$request_url = str_replace($cut_path, "", $_SERVER['REQUEST_URI']);


$router = new Router();


require '../routes/web.php';

define('BASE_URL', $_ENV['APP_URL']);

$router->dispatch($request_url);