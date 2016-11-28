<?php

namespace UserRegister\Controller\Factories;

use UserRegister\Controller\MainController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MainControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new MainController($serviceLocator);
    }
}
