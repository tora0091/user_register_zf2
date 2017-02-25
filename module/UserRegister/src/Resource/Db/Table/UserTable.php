<?php

namespace UserRegister\Resource\Db\Table;

use UserRegister\Resource\Db\Table\AbstractTableGateway;
USE Zend\Db\Sql\Expression;

class UserTable extends AbstractTableGateway
{
    const TABLE_NAME = 'user';

    public function __construct()
    {
        parent::__construct(self::TABLE_NAME);
    }
    
    /**
     * 登録処理
     * @param array $data 登録情報
     */
    public function insert($data)
    {
        return $this->getTableGateway()->insert($data);
    }
    
    /**
     * 検索
     * @param array $data 検索条件
     */
    public function search($data, $page = 1, $limit = 10)
    {
        $select = $this->getTableGateway()->getSql()->select();
        $select->columns([
            'number',
            'family_name',
            'last_name',
            'family_name_kana',
            'last_name_kana',
            'sex',
            'phone_number',
            'mobile_phone_number',
            'post_code',
            'prefecture_id',
            'address_city',
            'address_other',
            'section_id',
            'status',
            'create_date',
            'update_date'
        ]);
        if (isset($data['number']) && strlen($data['number']) > 0) {
            $select->where->like('number', $data['number'] . '%');  // 前方一致
        }
        if (isset($data['section_id']) && strlen($data['section_id']) > 0) {
            $select->where->equalTo('section_id', $data['section_id']);
        }
        $select->order('number ASC');
        $select->limit((int)$limit);
        $select->offset((int)(($page - 1) * $limit));

        return $this->getArray($this->getTableGateway()->selectWith($select));
    }
    
    public function isExist($number)
    {
        return count($this->findByNumber($number)) <= 0 ? false : true;
    }
    
    public function findByNumber($number)
    {
        $select = $this->getTableGateway()->getSql()->select();
        $select->columns([
            'number',
            'family_name',
            'last_name',
            'family_name_kana',
            'last_name_kana',
            'sex',
            'phone_number',
            'mobile_phone_number',
            'post_code',
            'prefecture_id',
            'address_city',
            'address_other',
            'section_id',
            'status',
            'create_date',
            'update_date'
        ])->where
                ->equalTo('number', $number);
        $select->limit(1);

        return $this->getRow($this->getTableGateway()->selectWith($select));
    }
    
    public function update($primaryKey, $changed)
    {
        return $this->getTableGateway()->update($changed, ['number' => $primaryKey]);
    }
    
    public function count($data)
    {
        $select = $this->getTableGateway()->getSql()->select();
        $select->columns([
            'count' => new Expression('COUNT(1)'),
        ]);
        if (isset($data['number']) && strlen($data['number']) > 0) {
            $select->where->like('number', $data['number'] . '%');  // 前方一致
        }
        if (isset($data['section_id']) && strlen($data['section_id']) > 0) {
            $select->where->equalTo('section_id', $data['section_id']);
        }

        return $this->getRow($this->getTableGateway()->selectWith($select));
    }
}
/*
CREATE TABLE `user` (
  `number` varchar(10) NOT NULL,
  `family_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `family_name_kana` varchar(40) NOT NULL,
  `last_name_kana` varchar(40) NOT NULL,
  `sex` tinyint(4) NOT NULL,
  `phone_number` varchar(10) NOT NULL,
  `mobile_phone_number` varchar(11) NOT NULL,
  `post_code` varchar(8) NOT NULL,
  `prefecture_id` tinyint(4) NOT NULL,
  `address_city` varchar(40) NOT NULL,
  `address_other` varchar(40) DEFAULT NULL,
  `section_id` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `user`
  ADD PRIMARY KEY (`number`);
*/