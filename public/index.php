<?php
// ==============================================
// JaminMagazijn - Front Controller (simpel MVC)
// ==============================================

declare(strict_types=1);

// Foutmeldingen aan tijdens development
ini_set('display_errors', '1');
error_reporting(E_ALL);

// ---- Pad-constanten
define('BASE_PATH', realpath(__DIR__ . '/..'));
define('APP_PATH',  BASE_PATH . '/app');
define('CTRL_PATH', APP_PATH   . '/Controllers');
define('MODEL_PATH',APP_PATH   . '/Models');
define('VIEW_PATH', APP_PATH   . '/Views');

// ---- Helpers, config & DB helper
require_once APP_PATH . '/Helpers/helpers.php';    // bevat url() helper
require_once BASE_PATH . '/config/database.php';   // geeft array terug
require_once MODEL_PATH . '/Database.php';         // PDO-connector

// ---- Kleine view-helper
function view(string $name, array $data = []): void {
    $file = VIEW_PATH . '/' . $name . '.php';
    if (!is_file($file)) {
        http_response_code(500);
        echo "<h1>500 - View '{$name}' niet gevonden</h1>";
        return;
    }
    extract($data, EXTR_SKIP);
    require $file;
}

// ---- Routes
$routes = [
    'GET' => [
        '/'                     => ['HomeController', 'index'],
        '/index.php'            => ['HomeController', 'index'],    // voor klikken op index.php
        '/magazijn/overzicht'   => ['MagazijnController', 'index'],
        '/allergenen/overzicht' => ['AllergenenController', 'index'],
        '/leveringen/overzicht' => ['LeveringenController', 'index'],
    ],
    'POST' => [
        // voorbeeld: '/iets/opslaan' => ['IetsController', 'store'],
    ],
];

// ---- Bepaal pad (zonder .htaccess: via ?route=...; anders fallback)
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if (!empty($_GET['route'])) {
    $path = '/' . trim((string)$_GET['route'], '/');
} else {
    // Fallback voor als je ooit "mooie" paden krijgt
    $path = strtok($_SERVER['REQUEST_URI'] ?? '/', '?') ?: '/';
    $scriptDir = rtrim(str_replace('\\','/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
    if ($scriptDir !== '' && $scriptDir !== '/') {
        if (strpos($path, $scriptDir) === 0) {
            $path = substr($path, strlen($scriptDir));
        }
    }
    $path = $path === '' ? '/' : rtrim($path, '/');
    if ($path === '') { $path = '/'; }
}

// Normaliseer expliciet /index.php naar /
if ($path === '/index.php') {
    $path = '/';
}

// ---- Controllers laden (1x)
require_once CTRL_PATH . '/HomeController.php';
require_once CTRL_PATH . '/MagazijnController.php';
require_once CTRL_PATH . '/AllergenenController.php';
require_once CTRL_PATH . '/LeveringenController.php';

// ---- Dispatch met nette foutcodes
try {
    // Bestaat route voor deze method?
    if (!isset($routes[$method])) {
        // Method niet gedefinieerd in routing
        http_response_code(405);
        echo "<h1>405 - Method Not Allowed</h1><p>{$method}</p>";
        exit;
    }

    // Route exact gevonden?
    if (!isset($routes[$method][$path])) {
        // Check: bestaat het pad wél voor een andere method? → 405
        $existsForOtherMethod = false;
        foreach ($routes as $m => $table) {
            if (isset($table[$path])) { $existsForOtherMethod = true; break; }
        }
        if ($existsForOtherMethod) {
            http_response_code(405);
            echo "<h1>405 - Method Not Allowed</h1><p>{$method} {$path}</p>";
        } else {
            http_response_code(404);
            echo "<h1>404 - Route niet gevonden</h1><p>{$method} {$path}</p>";
        }
        exit;
    }

    [$class, $action] = $routes[$method][$path];

    if (!class_exists($class)) {
        http_response_code(500);
        echo "<h1>500 - Controller '{$class}' niet gevonden</h1>";
        exit;
    }

    $controller = new $class();

    if (!method_exists($controller, $action)) {
        http_response_code(500);
        echo "<h1>500 - Actie {$class}::{$action}() niet gevonden</h1>";
        exit;
    }

    // Uitvoeren
    $controller->$action();

} catch (Throwable $e) {
    http_response_code(500);
    echo "<h1>500 - Onverwachte fout</h1>";
    echo "<pre style='white-space:pre-wrap;'>".$e->getMessage()."\n\n".$e->getTraceAsString()."</pre>";
    exit;
}
