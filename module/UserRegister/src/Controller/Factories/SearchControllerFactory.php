<?php

namespace UserRegister\Controller\Factories;

use UserRegister\Controller\SearchController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SearchControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new SearchController($serviceLocator);
    }
}
