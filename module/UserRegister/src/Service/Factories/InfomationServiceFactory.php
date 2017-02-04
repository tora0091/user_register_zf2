<?php

namespace UserRegister\Service\Factories;

use UserRegister\Service\InfomationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class InfomationServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new InfomationService($serviceLocator);
    }
}
