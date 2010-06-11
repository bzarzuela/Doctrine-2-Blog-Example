<?php
use Doctrine\ORM\EntityManager,
	Doctrine\ORM\Configuration;

	
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initDoctrine()
	{
		$config = new Configuration;
		
		switch (APPLICATION_ENV) {
		case 'production':
		case 'staging':
			$cache = new \Doctrine\Common\Cache\ApcCache;
			break;
			
		// Both development and test environments will use array cache.
		default:
			$cache = new \Doctrine\Common\Cache\ArrayCache;
			break;
		}
		
		$config->setMetadataCacheImpl($cache);
		
		$driverImpl = $config->newDefaultAnnotationDriver(APPLICATION_PATH . '/models');
		$config->setMetadataDriverImpl($driverImpl);
		
		$config->setQueryCacheImpl($cache);
		$config->setProxyDir(APPLICATION_PATH . '/proxies');
		$config->setProxyNamespace('D2Test\Proxies');
		
		$options = $this->getOption('doctrine');

		$config->setAutoGenerateProxyClasses($options['auto_generate_proxy_class']);
	
		$em = EntityManager::create($options['db'], $config);
		
		return $em;
	}
}

