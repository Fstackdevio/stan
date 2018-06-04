<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

require './../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Slim\Http\Environment as Environment;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App([
    'settings' => [
      'displayErrorDetails' => true
    ]
]);
    
$container = $app->getContainer();
$container['upload_directory'] = dirname(dirname(dirname(__FILE__))) . '\\' . 'uploads';
// $container['upload_directory'] = 'C:\xampp\htdocs\stan\uploads';

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', 'http://localhost/stan/*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});



// $env = Environment::mock(); 
// $directory = UploadedFile::createFromEnvironment($env);

// Handlers
require_once  __DIR__ . '/../src/dbHandler.php';

require_once  __DIR__ . '/../src/passwordHash.php';
// $handler = new IOhandler;

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
// require __DIR__ . '/../src/routes.php';


require __DIR__ . '/../src/authentication.php';
require __DIR__ . '/../src/adminHandler.php';
require __DIR__ . '/../src/bookHandler.php';
require __DIR__ . '/../src/userHandler.php';
require __DIR__ . '/../src/prefHandler.php';
require __DIR__ . '/../src/adminAuth.php';
require __DIR__ . '/../src/examsHandler.php';
require __DIR__ . '/../src/studentHandler.php';
require __DIR__ . '/../src/questionsHandler.php';



$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
    $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
    return $handler($req, $res);
});


// Run app
$app->run();

function verifyRequiredParams($required_fields,$request_params) {
    $error = false;
    $error_fields = "";
    foreach ($required_fields as $field) {
        if (!isset($request_params->$field) || strlen(trim($request_params->$field)) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if ($error) {
        // Required field(s) are missing or empty
        // echo error json and stop the app
        $response = array();
        $response["status"] = "error";
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        // echoResponse(200, $response);
        return json_encode($response);
        $app->stop();
    }
}


