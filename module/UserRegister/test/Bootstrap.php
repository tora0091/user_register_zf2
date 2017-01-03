<?php

namespace UserRegisterTest;

use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Loader\AutoloaderFactory;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\ArrayUtils;
use RuntimeException;
error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

class Bootstrap
{
    const MODULE_DIR_NAME = 'src';
    const VENDOR_DIR_NAME = 'vendor';
    
    protected static $config;
    protected static $serviceManager;
    
    public static function init()
    {
        static::$config = Bootstrap::getApplicationConfig();
        
        $serviceManager = new ServiceManager(new ServiceManagerConfig());
        $serviceManager->setService('ApplicationConfig', static::$config);
        $serviceManager->get('ModuleManager')->loadModules();
        
        $adapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
        GlobalAdapterFeature::setStaticAdapter($adapter);
        
        static::$serviceManager = $serviceManager;
    }
    
    public static function getApplicationConfig()
    {
        if (!is_null(static::$config)) {
            return static::$config;
        }
        $env = getenv('APPLICATION_ENV');
        $config = require __DIR__ . '/../../../config/application.config.php';
        $config['module_listener_options']['config_glob_paths'][0] = sprintf(__DIR__ . "/../../../config/autoload/{,*.}{global,local,%s}.php", $env);
        $config['module_listener_options']['config_cache_enabled'] = false;
        
        $zf2ModulePaths = [dirname(dirname(__DIR__))];
        if (($path = static::findParentPath(static::VENDOR_DIR_NAME))) {
            $zf2ModulePaths[] = $path;
        }
        if (($path = static::findParentPath(static::MODULE_DIR_NAME)) !== $zf2ModulePaths[0]) {
            $zf2ModulePaths[] = $path;
        }
        
        static::initAutoloader();
        
        $baseConfig = [
            'module_listener_options' => [
                'module_paths' => $zf2ModulePaths,
            ],
        ];
        $config['module_listener_options']['module_paths'] = [];
        $config = ArrayUtils::merge($baseConfig, $config);
        return $config;
    }
    
    public static function chroot()
    {
        $rootPath = dirname(static::findParentPath('module'));
        chdir($rootPath);
    }
    
    public static function getServiceManager()
    {
        return static::$serviceManager;
    }
    
    protected static function initAutoloader()
    {
        $vendorPath = static::findParentPath('vendor');
        
        if (file_exists($vendorPath . '/autoload.php')) {
            include $vendorPath . '/autoload.php';
        }
        
        if (!class_exists('Zend\Loader\AutoloaderFactory')) {
            throw new RuntimeException('Unable to load ZF2. Run `php composer.phar install`');
        }
        
        AutoloaderFactory::factory([
            'Zend\Loader\StandardAutoloader' => [
                'autoregister_zf' => true,
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/' . __NAMESPACE__,
                ],
            ],
        ]);
    }
    
    protected static function findParentPath($path)
    {
        $dir = __DIR__;
        $previousDir = '.';
        while (!is_dir($dir . '/' . $path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir) {
                return false;
            }
            $previousDir = $dir;
        }
        return $dir . '/' . $path;
    }
}

Bootstrap::init();
Bootstrap::chroot();
