<?php

/** @var \Slim\App $app */
$app->group('/todo', function() use ($app) {
  $app->get('', function($request, $response, $args = []) {
    $todos = array('tod1' => 'tOdO1', 'tod2' => 'ToDo2');
    return $response->withJson($todos);
  });
});
