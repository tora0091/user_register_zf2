<?php

namespace UserRegister\Controller\Factories;

use UserRegister\Controller\RegisterController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RegisterControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new RegisterController($serviceLocator);
    }
}
