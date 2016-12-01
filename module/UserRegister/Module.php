<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace UserRegister;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;

//use Zend\Db\Adapter\Adapter;
//use Zend\Db\TableGateway\Feature\GlobalAdapterFeatrue;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $this->bootstrapSession($e->getApplication()->getServiceManager());

//		$this->createDbAdapter($e);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function bootstrapSession(ServiceManager $serviceManager)
    {
        $sesConf = $serviceManager->get('config')['session'];
        
        $sessionConfig = new $sesConf['class']();
        $sessionConfig->setOptions($sesConf['options']);

        $sessionManager = $serviceManager->get('SessionManager');
        $sessionManager->setConfig($sessionConfig);
        $sessionManager->setStorage(new $sesConf['storage']());

        $sessionManager->start();
    }

//	protected function createDbAdapter(MvcEvent $e)
//	{
//		$config = $e->getApplication()->getConfig();
//		$adapter = new Adapter($config['db']);
//		GlobalAdapterFeature::setStaticAdapter($adapter);
//	}
}
