<?php

namespace UserRegister\Controller\Factories;

use UserRegister\Controller\UpdateController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UpdateControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new UpdateController($serviceLocator);
    }
}
