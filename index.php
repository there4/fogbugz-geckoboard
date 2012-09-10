<?php
// # FogBugz Widgets for Geckboard
// 
// * Author: Craig Davis <craig@there4development.com>
//

// Composer supplies most of our dependencies
require __DIR__ . '/vendor/autoload.php';

// Include some legacy libraries
// TODO: migrate these to Packagist
require_once __DIR__ . '/lib/There4/FogBugz/api.php';
require_once __DIR__ . '/lib/Gecko/response.php';

// This app is based on the Slim Framework, a perfect little microframework
// for serving a handful of routes for Geckoboard widgets.
// See the ./routes folder for all of the endpoints.
use Slim\Slim;

// Start Slim framework and setup our config and GeckboBoard response object
$app = new Slim();

// If this config file isn't found, prompt the user to add it.
$configFile = __DIR__ . '/config/config.php';
if (file_exists($configFile)) {
  $app->config = include($configFile);
}
elseif ($_SERVER['REQUEST_URI'] !== '/require-config') {
  // The URI check prevents a redirect loop
  header('Location: http://' . $_SERVER['HTTP_HOST'] . '/require-config');
  exit();
}

$app->geckoResponse = new Response();

// This is a Slim Middleware helper to establish authentication
$apiAuthenticate = function() use ($app) {
    if ($app->config->require_auth
        && (
             !isset($_SERVER['PHP_AUTH_USER'])
             || ($_SERVER['PHP_AUTH_USER'] != $app->config->gecko_auth)
           )
    ) {
        Header("HTTP/1.1 403 Access denied");
        $data = array('error' => 'Access denied.');
        echo $app->geckoResponse->getResponse($data);
        exit();
    }
};

// Slim middleware to set the xml or json format for this request
$setFormat = function() use ($app) {
    $format = isset($_REQUEST['format']) ? (int) $_REQUEST['format'] : 0;
    $format = ($format == 1) ? 'xml' : 'json';
    $app->geckoResponse->setFormat($format);
};

// Setup each of our application routes. Note that routes that start with
// and underscore are in the gitignore, and this makes it easy to add new
// routes without having to branch of add new gitignore rules if you send
// a pull request.
foreach (glob(__DIR__ ."/routes/*.php") as $route) {
    require $route;
}

// Run the Slim Application
$app->run();

/* End of file index.php */
