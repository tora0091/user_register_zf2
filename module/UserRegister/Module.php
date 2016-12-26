<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace UserRegister;

use Zend\Mvc\Application;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;
use Zend\Http\PhpEnvironment\Response;
use Zend\ServiceManager\ServiceManager;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        // database
        $this->createDbAdapter($e);

        // session
        $this->bootstrapSession($e->getApplication()->getServiceManager());
        
        // exception handler
        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'exceptionHandler']);
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
        $sessionManager = $serviceManager->get('SessionManager');
        if ($sessionManager->sessionExists()) {
            $sesConf = $serviceManager->get('config')['session'];
            $sessionConfig = new $sesConf['class']();
            $sessionConfig->setOptions($sesConf['options']);
            $sessionManager->setConfig($sessionConfig);
            $sessionManager->setStorage(new $sesConf['storage']());
        }
        $sessionManager->start();
    }

    protected function createDbAdapter(MvcEvent $e)
    {
        $config = $e->getApplication()->getConfig();
        $adapter = new Adapter($config['db']);
        GlobalAdapterFeature::setStaticAdapter($adapter);
    }

    public function exceptionHandler(MvcEvent $e)
    {
        $error = $e->getError();
        if ($error !== Application::ERROR_EXCEPTION) {
            return;
        }

        $result = $e->getResult();
        if (!$result instanceof ViewModel) {
            return;
        }

        $response = $e->getResponse();
        if (!$response instanceof Response) {
            return;
        }

        $exception = $e->getParam('exception');
        if ($e->isError()) {
            if ($exception instanceof \UserRegister\Common\Exception\ApplicationException) {
                $response->setStatusCode(500);
                $result->setTemplate('error/index');
            } elseif ($exception instanceof \UserRegister\Common\Exception\DatabaseException) {
                $response->setStatusCode(500);
                $result->setTemplate('error/index');
            } elseif ($exception instanceof \UserRegister\Common\Exception\FileNotFoundException) {
                $response->setStatusCode(404);
                $result->setTemplate('error/404');
            } elseif ($exception instanceof \UserRegister\Common\Exception\NotTokenException) {
                $response->setStatusCode(404);
                $result->setTemplate('error/404');
            } else {
                $response->setStatusCode(500);
                $result->setTemplate('error/index');
            }
        }
    }
}
