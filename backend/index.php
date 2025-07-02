<?php 
header('Content-Type: application/json; charset=UTF-8');
header("Access-Control-Allow-Origin: http://localhost:3000");  // Permitir apenas localhost:3000
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, origin");
header("Access-Control-Allow-Credentials: true"); //Obrigatório o envio de: credentials: 'include' no header pelo front.
// header("Access-Control-Max-Age: 3600");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
   http_response_code(200);
   exit();
}
$request =str_replace( '/organizze-bk/public/', '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$method = $_SERVER['REQUEST_METHOD'];
//Enable namespaces
require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/src/routes/main.php';

use App\Config\EnvLoader;
use App\Middleware\AuthMiddleware;
use App\Core\Core;
use App\Http\Route;

//Enable environment variables
EnvLoader::load();

AuthMiddleware::verify();

//Enable Routes
Core::dispatch(Route::routes());

