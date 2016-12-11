<?php

namespace UserRegister\Resource\Db\Table;

use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\TableGateway\TableGateway;

abstract class AbstractTableGateway
{
    protected $adapter = null;
    protected $tableGateway = null;

    abstract function getTableName();

    public function __construct()
    {
        $this->adapter = GlobalAdapterFeature::getStaticAdapter();
        $this->tableGateway = new TableGateway($this->getTableName(), $this->getAdapter());
    }
    
    /**
     * getAdapter
     * @return Adapter
     */
    public function getAdapter()
    {
        if (is_null($this->adapter)) {
            $this->adapter = GlobalAdapterFeature::getStaticAdapter();
        }
        return $this->adapter;
    }

    /**
     * getTableGateway
     * @return TableGateway
     */
    public function getTableGateway()
    {
        if (is_null($this->tableGateway)) {
            $this->tableGateway = new TableGateway($this->getTableName(), $this->getAdapter());
        }
        return $this->tableGateway;
    }

    /**
     * fetchAll
     * @return array
     */
    public function fetchAll()
    {
        return $this->getTableGateway()->select()->toArray();
    }
}
