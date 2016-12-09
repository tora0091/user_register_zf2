<?php

namespace UserRegister\Service;

use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractService
{
    /** @var table path */
    const TABLE_PATH = 'UserRegister\Resource\Db\Table\\';
    
    /** @var $serviceLocator */
    protected $serviceLocator;

    /**
     * Construt
     * @param ServiceLocatorInterface $serviceLocator
     */    
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }
    
    /**
     * テーブルオブジェクトを返す
     * @param string $name
     * @return ServiceLocator
     */
    public function getTable($name)
    {
        if (!strpos(self::TABLE_PATH, $name)) {
            $name = self::TABLE_PATH . $name;
        }
        return $this->serviceLocator->get($name);
    }
}