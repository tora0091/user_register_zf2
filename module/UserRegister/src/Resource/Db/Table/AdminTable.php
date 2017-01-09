<?php

namespace UserRegister\Resource\Db\Table;

use UserRegister\Resource\Db\Table\AbstractTableGateway;

class AdminTable extends AbstractTableGateway
{
    const TABLE_NAME = 'admin';

    public function __construct()
    {
        parent::__construct(self::TABLE_NAME);
    }
    
    public function findByUser($user)
    {
        $select = $this->getTableGateway()->getSql()->select();
        $select->columns([
            'id',
            'user',
            'password',
            'auth',
            'status',
        ])->where
                ->equalTo('user', $user)
                ->notEqualTo('status', 1);
        $select->limit(1);

        return $this->getRow($this->getTableGateway()->selectWith($select));
    }
}
/*
CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `user` varchar(16) NOT NULL,
  `password` varchar(512) NOT NULL,
  `auth` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `admin` 
  ADD UNIQUE(`user`); 
 */
