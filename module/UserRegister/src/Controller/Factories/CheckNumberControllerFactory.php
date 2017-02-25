<?php

namespace UserRegister\Controller\Factories;

use UserRegister\Controller\Ajax\CheckNumberController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CheckNumberControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new CheckNumberController($serviceLocator);
    }
}
