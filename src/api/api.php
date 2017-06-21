<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Configuration;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\EntityManager;

$entityManager = initEntityManager();

/** @var \Slim\App $app */
$app->group('/api', function () use ($app, $entityManager) {
  $app->group('/v1', function () use ($app, $entityManager) {
    $routeFiles = (array) glob(__DIR__ . '/v1/*.php');
    foreach($routeFiles as $routeFile) {
      require_once $routeFile;
    }
  });
});

function initEntityManager() {
  $config = new Configuration();
  $config->setMetadataCacheImpl(new ArrayCache());
  $driverImpl = $config->newDefaultAnnotationDriver(array(ROOT_DIR . '/src/App/Entity'));
  $config->setMetadataDriverImpl($driverImpl);
  $config->setProxyDir(ROOT_DIR . '/src/App/Entity/Proxy');
  $config->setProxyNamespace('Proxy');
  $appConfig = require_once ROOT_DIR . '/config/config.php';

  return EntityManager::create($appConfig['db'], $config);
}
