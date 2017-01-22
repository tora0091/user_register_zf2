<?php

namespace UserRegister\Service\Factories;

use UserRegister\Service\SearchService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SearchServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new SearchService($serviceLocator);
    }
}
