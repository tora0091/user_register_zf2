<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace UserRegister;

use UserRegister\Common\ContainerTrait;
use Zend\Mvc\Application;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;
use Zend\Http\PhpEnvironment\Response;
use Zend\ServiceManager\ServiceManager;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

class Module
{
    use ContainerTrait;
    
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        // database
        $this->createDbAdapter($e->getApplication()->getServiceManager());

        // session
        $this->bootstrapSession($e->getApplication()->getServiceManager());
        
        // exception handler
        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'exceptionHandler']);
        
        // authorization handler
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'authorizationHandler'], 1);

        // view handler
//        $eventManager->attach(MvcEvent::EVENT_RENDER, [$this, 'viewHandler']);
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

    protected function createDbAdapter(ServiceManager $serviceManager)
    {
        $adapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
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
    
    public function authorizationHandler(MvcEvent $e)
    {
        $serviceManager = $e->getApplication()->getServiceManager();
        $excludeLoginUser = $serviceManager->get('config')['exclude_login_user'];

        $controller = $e->getRouteMatch()->getParam('controller');
        $action = $e->getRouteMatch()->getParam('action');

        // 認証確認処理
        if (!isset($excludeLoginUser[$controller]) || !in_array($action, $excludeLoginUser[$controller])) {
            $admin = $this->getContainer('global')->admin;
            if (is_null($admin)) {
                // ログイン状態でない場合はログイン画面を表示する
                $response = $e->getResponse();
                $response->getHeaders()->addHeaderLine('Location', '/');
                $response->setStatusCode(302);
            }
        }
    }

//    public function viewHandler(MvcEvent $e)
//    {
//        $view = $e->getViewModel();
//        $view->setVariable('admin', $this->getContainer('global')->admin);
//    }
}
