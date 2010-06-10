<?php

$config = new \Doctrine\ORM\Configuration();
$config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
$driverImpl = $config->newDefaultAnnotationDriver(array(__DIR__."/../application/models"));
$config->setMetadataDriverImpl($driverImpl);

$config->setProxyDir(__DIR__ . '/../application/proxies');
$config->setProxyNamespace('Proxies');

// Bootstrap the ZF application here to get the connection options.

$connectionOptions = array(
    'driver' => 'pdo_mysql',
	'user' => 'd2test',
	'password' => 'd2test',
	'dbname' => 'd2test_dev',
	'host' => '127.0.0.1',
);

$em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);

$helpers = array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
);