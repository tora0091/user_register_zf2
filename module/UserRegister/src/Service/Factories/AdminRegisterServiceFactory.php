<?php

namespace UserRegister\Service\Factories;

use UserRegister\Service\AdminRegisterService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AdminRegisterServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new AdminRegisterService($serviceLocator);
    }
}
