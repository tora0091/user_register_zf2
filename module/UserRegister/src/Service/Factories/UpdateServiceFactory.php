<?php

namespace UserRegister\Service\Factories;

use UserRegister\Service\UpdateService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UpdateServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new UpdateService($serviceLocator);
    }
}
