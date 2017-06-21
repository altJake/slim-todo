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
  $body = new Stream(ROOT_DIR . '/views/index.html', 'r');
  return  $response->withStatus(200, 'OK')->withBody($body);
});

$app->run();
