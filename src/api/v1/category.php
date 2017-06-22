<?php

use App\Entity\Category;

/** @var \Slim\App $app
*   @var \Doctrine\ORM\EntityManager $entityManager
*/
$app->group('/category', function() use ($app, $entityManager, $categoryClass) {
  $app->get('[/[{id}]]', function($request, $response, $args = []) use ($entityManager, $categoryClass) {
    $id = $args['id'];

    if ($id === null) {
      $data = $entityManager->getRepository($categoryClass)->findAll();
    } else {
      $data = $entityManager->find($categoryClass, $id);
    }

    return $response->withJson($data);
  });

  $app->put('[/]', function($request, $response, $args = []) use ($entityManager, $categoryClass) {

    $reqBody = $request->getParsedBody();

    if ($reqBody == null || empty($reqBody['name']))
      return $response->withStatus(400)->withJson(array('error' => 'Request body is empty or does not contain name field'));

    $newCategory = new Category();
    $newCategory->setName($reqBody['name']);
    $entityManager->persist($newCategory);
    $entityManager->flush();

    return $response->withstatus(201)->withJson($newCategory);
  });

  $app->post('[/]', function($request, $response, $args = []) use ($entityManager, $categoryClass) {

    $reqBody = $request->getParsedBody();

    if ($reqBody == null || empty($reqBody['id']) || empty($reqBody['name']))
      return $response->withStatus(400)->withJson(array('error' => 'Request body is empty or does not contain name and id fields'));

    $category = $entityManager->getReference($categoryClass, $reqBody['id']);

    if (empty($category))
      return $response->withStatus(404)->withJson(array('error' => 'Category with the given id could not be found'));

    $category->setName($reqBody['name']);
    $entityManager->flush();

    return $response->withstatus(200)->withJson($category);
  });

  $app->delete('/{id}', function($request, $response, $args = []) use ($entityManager, $categoryClass) {

    $id = $args['id'];
    $category = $entityManager->find($categoryClass, $id);

    if (empty($category))
      return $response->withStatus(404)->withJson(array('error' => 'Category with the given id could not be found'));

    $entityManager->remove($category);
    $entityManager->flush();

    return $response->withstatus(204);
  });
});
