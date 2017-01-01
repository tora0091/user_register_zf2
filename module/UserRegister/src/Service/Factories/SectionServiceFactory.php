<?php

namespace UserRegister\Service\Factories;

use UserRegister\Service\SectionService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SectionServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new SectionService($serviceLocator);
    }
}
