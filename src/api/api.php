<?php

/** @var \Slim\App $app */
$app->group('/api', function () use ($app) {
  $app->group('/v1', function () use ($app) {
    $routeFiles = (array) glob(__DIR__ . DIRECTORY_SEPARATOR . 'v1' . DIRECTORY_SEPARATOR . '*.php');
    foreach($routeFiles as $routeFile) {
      require_once $routeFile;
    }
  });
});
