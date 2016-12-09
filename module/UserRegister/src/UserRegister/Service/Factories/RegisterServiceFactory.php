<?php

namespace UserRegister\Service\Factories;

use UserRegister\Service\RegisterService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RegisterServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new RegisterService($serviceLocator);
    }
}
