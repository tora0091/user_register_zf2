<?php

namespace UserRegister\Resource\Db\Table;

use UserRegister\Resource\Db\Table\AbstractTableGateway;

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
    public function search($data)
    {
        return $this->getArray($this->getTableGateway()->select($data));
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