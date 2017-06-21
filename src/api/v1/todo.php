<?php

use App\Entity\Todo;

/** @var \Slim\App $app
*   @var \Doctrine\ORM\EntityManager $entityManager
*/
$app->group('/todo', function() use ($app, $entityManager) {
  $todoClass = 'App\Entity\Todo';

  $app->get('[/[{id}]]', function($request, $response, $args = []) use ($entityManager, $todoClass) {
    $id = $args['id'];

    if ($id === null) {
      $data = $entityManager->getRepository($todoClass)->findAll();
    } else {
      $data = $entityManager->find($todoClass, $id);
    }

    return $response->withJson($data);
  });

  $app->put('[/]', function($request, $response, $args = []) use ($entityManager, $todoClass) {

    $reqBody = $request->getParsedBody();

    if ($reqBody == null || empty($reqBody['subject']))
      return $response->withStatus(400)->withJson(array('error' => 'Request body is empty or does not contain subject field'));

    $newTodo = new Todo();
    $newTodo->setSubject($reqBody['subject']);
    $newTodo->setIsDone($reqBody['isDone']);
    // TODO add perssistence of categories

    $entityManager->persist($newTodo);
    $entityManager->flush();

    return $response->withstatus(201)->withJson($newTodo);
  });

  $app->post('[/]', function($request, $response, $args = []) use ($entityManager, $todoClass) {

    $reqBody = $request->getParsedBody();

    if ($reqBody == null || empty($reqBody['id']))
      return $response->withStatus(400)->withJson(array('error' => 'Request body is empty or does not contain id field'));

    $todo = $entityManager->find($todoClass, $reqBody['id']);

    if (empty($todo))
      return $response->withStatus(404)->withJson(array('error' => 'Todo with the given id could not be found'));

    $todo->setSubject($reqBody['subject']);
    $todo->setIsDone($reqBody['isDone']);
    // TODO add perssistence of categories

    $entityManager->persist($todo);
    $entityManager->flush();

    return $response->withstatus(200)->withJson($todo);
  });

  $app->delete('/{id}', function($request, $response, $args = []) use ($entityManager, $todoClass) {

    $id = $args['id'];
    $todo = $entityManager->find($todoClass, $id);

    if (empty($todo))
      return $response->withStatus(404)->withJson(array('error' => 'Tod with the given id could not be found'));

    $entityManager->remove($todo);
    $entityManager->flush();

    return $response->withstatus(204);
  });
});
