<?php

namespace UserRegister\Resource\Db\Table;

use UserRegister\Resource\Db\Table\AbstractTableGateway;

class SectionTable extends AbstractTableGateway
{
    const TABLE_NAME = 'm_section';

    public function __construct()
    {
        parent::__construct(self::TABLE_NAME);
    }
    
    /**
     * 部署名リストを取得する
     * return array
     */
    public function getSection()
    {
        return $this->getArray($this->fetchAll());
    }
}

/*
CREATE TABLE `m_section` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `m_section` (`id`, `name`, `status`) VALUES
(1, '営業部', 1),
(2, 'エンタメ部', 1),
(3, 'セクシー女優部', 1),
(4, '俳優部', 1),
(5, '声優部', 1),
(6, '演劇部', 1);

ALTER TABLE `m_section`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `m_section`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
*/