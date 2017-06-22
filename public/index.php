<?php
require '../vendor/autoload.php';

use GuzzleHttp\Psr7\LazyOpenStream as Stream;
use \Slim\App;

define('PUBLIC_DIR', dirname(__FILE__));
define('ROOT_DIR', dirname(PUBLIC_DIR . '../'));

$app = new App(['settings' =>
  [
    'mode' => 'development',
    'debug' => true
  ]
]);

$app->get('/', function ($request, $response, $args = []) {
  $body = new Stream(__DIR__ . '/index.html', 'r');
  return  $response->withStatus(200, 'OK')->withBody($body);
});

require_once ROOT_DIR . '/src/api/api.php';

$app->run();
