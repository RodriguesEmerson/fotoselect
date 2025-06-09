<?php 

//Enable namespaces
require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/src/routes/main.php';

use App\Config\EnvLoader;
use App\Core\Core;
use App\Http\Route;

//Enable environment variables
EnvLoader::load();

//Enable Routes
Core::dispatch(Route::routes());

