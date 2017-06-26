<?php

use App\Entity\Todo;
use Doctrine\Common\Collections\ArrayCollection;

/** @var \Slim\App $app
*   @var \Doctrine\ORM\EntityManager $entityManager
*/
$app->group('/todo', function() use ($app, $entityManager, $todoClass, $categoryClass) {
  $app->get('[/[{id}]]', function($request, $response, $args = []) use ($entityManager, $todoClass) {
    $id = $args['id'];

    if ($id === null) {
      $data = $entityManager->getRepository($todoClass)->findAll();
    } else {
      $data = $entityManager->find($todoClass, $id);
    }

    return $response->withJson($data);
  });

  $app->put('[/]', function($request, $response, $args = []) use ($entityManager, $todoClass, $categoryClass) {

    $reqBody = $request->getParsedBody();

    if ($reqBody === null || empty($reqBody['subject']))
      return $response->withStatus(400)->withJson(array('error' => 'Request body is empty or does not contain subject field'));

    $newTodo = new Todo();
    $newTodo->setSubject($reqBody['subject']);

    if (array_key_exists('categories', $reqBody)) {
      $categoriesIds = array_map(function($cat) { return $cat['id']; }, $reqBody['categories']);
      if (!empty($categoriesIds)) {
        $qb = $entityManager->getRepository($categoryClass)->createQueryBuilder('c');
        $categories =
          $qb->where($qb->expr()->in('c.id', $categoriesIds))
             ->getQuery()->getResult();
        $newTodo->categories = new ArrayCollection($categories);
      }
    }

    $entityManager->persist($newTodo);
    $entityManager->flush();

    return $response->withstatus(201)->withJson($newTodo);
  });

  $app->post('[/]', function($request, $response, $args = []) use ($entityManager, $todoClass, $categoryClass) {

    $reqBody = $request->getParsedBody();

    if ($reqBody == null || empty($reqBody['id']))
      return $response->withStatus(400)->withJson(array('error' => 'Request body is empty or does not contain id field'));

    $todo = $entityManager->getReference($todoClass, $reqBody['id']);

    if (empty($todo))
      return $response->withStatus(404)->withJson(array('error' => 'Todo with the given id could not be found'));

    $todo->setSubject($reqBody['subject']);
    $todo->setIsDone(array_key_exists('isDone', $reqBody) && (strtolower($reqBody['isDone']) === 'true' || $reqBody['isDone'] === true));

    if (!array_key_exists('categories', $reqBody)) {
      $todo->categories = new ArrayCollection();
    }
    else {
      $categoriesIds = array_map(function($cat) { return $cat['id']; }, $reqBody['categories']);
      if (!empty($categoriesIds)) {
        $qb = $entityManager->getRepository($categoryClass)->createQueryBuilder('c');
        $categories =
          $qb->where($qb->expr()->in('c.id', $categoriesIds))
             ->getQuery()->getResult();
        $todo->categories = new ArrayCollection($categories);
      }
    }

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
