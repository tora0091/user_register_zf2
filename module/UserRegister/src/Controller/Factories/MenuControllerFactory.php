<?php

namespace UserRegister\Controller\Factories;

use UserRegister\Controller\MenuController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MenuControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new MenuController($serviceLocator);
    }
}
