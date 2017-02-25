<?php

namespace UserRegister\Resource\Db\Table;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\TableGateway\TableGateway;

abstract class AbstractTableGateway
{
    private $tableName;
    protected $adapter = null;
    protected $tableGateway = null;

    public function __construct($tableName)
    {
        $this->tableName = $tableName;
        $this->adapter = GlobalAdapterFeature::getStaticAdapter();
        $this->tableGateway = new TableGateway($this->tableName, $this->getAdapter());
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
            $this->tableGateway = new TableGateway($this->tableName, $this->getAdapter());
        }
        return $this->tableGateway;
    }

    /**
     * fetchAll
     * @return ResultSet
     */
    public function fetchAll()
    {
        return $this->getTableGateway()->select();
    }
    
    /**
     * getArray
     * @param ResultSet $result
     */
    public function getArray(ResultSet $result = null)
    {
        if ($result !== null && $result instanceof ResultSet) {
            return $result->toArray();
        }
        return [];
    }

    /**
     * getRow
     * @param ResultSet $result
     */
    public function getRow(ResultSet $result = null)
    {
        if ($result !== null && $result instanceof ResultSet) {
            // 先頭1行を取得
            $res = $result->toArray();
            // 検索結果が0件の場合も空配列を返す
            if (empty($res)) {
                return [];
            }
            return $res[0];
        }
        return [];
    }
}
