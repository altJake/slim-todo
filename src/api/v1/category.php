<?php

/** @var \Slim\App $app */
$app->group('/category', function() use ($app) {
  $app->get('', function($request, $response, $args = []) {
    $cats = array('cat1' => 'somethin1', 'cat2' => 'something2');
    return $response->withJson($cats);
  });
});
