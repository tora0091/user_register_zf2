<?php

namespace UserRegister\Resource\Db\Table;

use UserRegister\Resource\Db\Table\AbstractTableGateway;

class PrefectureTable extends AbstractTableGateway
{
    const TABLE_NAME = 'm_prefecture';

    /**
     * @see \UserRegister\Resource\Db\Table\AbstractTableGateway::getTableName()
     * @return string
     */
    public function getTableName()
    {
        return self::TABLE_NAME;
    }
    
    /**
     * 都道府県リストを取得する
     * return array
     */
    public function getPrefecture()
    {
        return $this->getArray($this->fetchAll());
    }
}

/*
CREATE TABLE `m_prefecture` (
  `id` tinyint(3) unsigned NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `name_kana` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `m_prefecture` VALUES
  (1,'北海道','ホッカイドウ'),
  (2,'青森県','アオモリケン'),
  (3,'岩手県','イワテケン'),
  (4,'宮城県','ミヤギケン'),
  (5,'秋田県','アキタケン'),
  (6,'山形県','ヤマガタケン'),
  (7,'福島県','フクシマケン'),
  (8,'茨城県','イバラキケン'),
  (9,'栃木県','トチギケン'),
  (10,'群馬県','グンマケン'),
  (11,'埼玉県','サイタマケン'),
  (12,'千葉県','チバケン'),
  (13,'東京都','トウキョウト'),
  (14,'神奈川県','カナガワケン'),
  (15,'新潟県','ニイガタケン'),
  (16,'富山県','トヤマケン'),
  (17,'石川県','イシカワケン'),
  (18,'福井県','フクイケン'),
  (19,'山梨県','ヤマナシケン'),
  (20,'長野県','ナガノケン'),
  (21,'岐阜県','ギフケン'),
  (22,'静岡県','シズオカケン'),
  (23,'愛知県','アイチケン'),
  (24,'三重県','ミエケン'),
  (25,'滋賀県','シガケン'),
  (26,'京都府','キョウトフ'),
  (27,'大阪府','オオサカフ'),
  (28,'兵庫県','ヒョウゴケン'),
  (29,'奈良県','ナラケン'),
  (30,'和歌山県','ワカヤマケン'),
  (31,'鳥取県','トットリケン'),
  (32,'島根県','シマネケン'),
  (33,'岡山県','オカヤマケン'),
  (34,'広島県','ヒロシマケン'),
  (35,'山口県','ヤマグチケン'),
  (36,'徳島県','トクシマケン'),
  (37,'香川県','カガワケン'),
  (38,'愛媛県','エヒメケン'),
  (39,'高知県','コウチケン'),
  (40,'福岡県','フクオカケン'),
  (41,'佐賀県','サガケン'),
  (42,'長崎県','ナガサキケン'),
  (43,'熊本県','クマモトケン'),
  (44,'大分県','オオイタケン'),
  (45,'宮崎県','ミヤザキケン'),
  (46,'鹿児島県','カゴシマケン'),
  (47,'沖縄県','オキナワケン');
*/