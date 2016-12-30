<?php

namespace UserRegister\Service;

use UserRegister\Common\LoggingTrait;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

abstract class AbstractService
{
    use LoggingTrait;
    
    /** @var table path */
    const TABLE_PATH = 'UserRegister\Resource\Db\Table\\';
    
    /** @var $serviceLocator */
    protected $serviceLocator;

    /** @var \Zend\Db\Adapter\Adapter $adapter */
    private $adapter;

    /**
     * Construt
     * @param ServiceLocatorInterface $serviceLocator
     */    
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * getServiceLocator
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
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
        return $this->getServiceLocator()->get($name);
    }

    /**
     * DB Adapter
     * @return Adapter
     */
    private function getAdapter()
    {
        if ($this->adapter == null) {
            $this->adapter = GlobalAdapterFeature::getStaticAdapter();
        }
        return $this->adapter;
    }

    /**
     * db connection
     * @return ConnectionInterface
     */
    public function connection()
    {
        return $this->getAdapter()->getDriver()->getConnection();
    }
    
    /**
     * begin
     */
    public function begin()
    {
        $this->connection()->beginTransaction();
    }

    /**
     * commit
     */
    public function commit()
    {
        $this->connection()->commit();
    }

    /**
     * rollback
     */
    public function rollback()
    {
        $this->connection()->rollback();
    }
}