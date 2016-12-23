<?php

namespace UserRegister\Service;

use UserRegister\Service\AbstractService;

class RegisterService extends AbstractService
{
    /**
     * 都道府県リスト取得
     * @return array
     */
    public function getPrefecture()
    {
        return $this->getTable('PrefectureTable')->getPrefecture();
    }

    /**
     * 部署名リスト取得
     * @return array
     */
    public function getSection()
    {
        return $this->getTable('SectionTable')->getSection();
    }

    /**
     * 登録処理
     * @param array $data 登録情報
     * @return integer 登録件数
     */
    public function insert($data)
    {
        return $this->getTable('UserTable')->insert($data);
    }
}