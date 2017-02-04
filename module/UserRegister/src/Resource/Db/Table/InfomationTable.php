<?php

namespace UserRegister\Resource\Db\Table;

use UserRegister\Resource\Db\Table\AbstractTableGateway;
use Zend\Db\Sql\Predicate\Expression;

class InfomationTable extends AbstractTableGateway
{
    const TABLE_NAME = 'infomation';

    public function __construct()
    {
        parent::__construct(self::TABLE_NAME);
    }
    
    public function getInfomationList()
    {
        $select = $this->getTableGateway()->getSql()->select();
        $select->columns([
            'id',
            'title',
            'content',
            'start_date',
            'end_date'
        ])->where
                ->lessThan("start_date", new Expression("NOW()"))
                ->greaterThan("end_date", new Expression("NOW()"));
        $select->order("start_date ASC");
        $select->limit(5);
        return $this->getArray($this->getTableGateway()->selectWith($select));
    }
}
/*
CREATE TABLE `infomation` (
  `id` int(11) NOT NULL,
  `title` varchar(300) NOT NULL,
  `content` text NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `infomation`
  ADD PRIMARY KEY (`id`);
 */
