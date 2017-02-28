<?php

namespace UserRegister\Controller\Factories;

use UserRegister\Controller\AdminRegisterController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AdminRegisterControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new AdminRegisterController($serviceLocator);
    }
}
