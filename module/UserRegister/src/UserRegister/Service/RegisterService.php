<?php

namespace UserRegister\Service;

use UserRegister\Service\AbstractService;
use UserRegister\Common\Exception\DatabaseException;

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
        $data['post_code'] = $data['post_code1'] .$data['post_code2'];
        unset($data['post_code1']);
        unset($data['post_code2']);
        $data['status'] = 1;
        $now = date('Y-m-d H:i:s');
        $data['create_date'] = $now;
        $data['update_date'] = $now;
        
        $res = null;
        try {
            $this->begin();
            $res = $this->getTable('UserTable')->insert($data);
            $this->commit();
        } catch (Exception $ex) {
            $this->rollback();
            throw new DatabaseException();
        }
        return $res;
    }
}