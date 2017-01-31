<?php

namespace UserRegister\Service;

use UserRegister\Common\Exception\DatabaseException;
use UserRegister\Common\Exception\FileNotFoundException;
use UserRegister\Service\AbstractService;

class UpdateService extends AbstractService
{
    public function findByNumber($number = null)
    {
        if ($number === null) {
            throw new FileNotFoundException();
        }
        return $this->getTable('UserTable')->findByNumber($number);
    }
    
    public function update(array $inputs = null)
    {
        if ($inputs === null) {
            throw new FileNotFoundException();
        }
        
        if (!isset($inputs['number']) || strlen($inputs['number']) <= 0) {
            throw new FileNotFoundException();
        }
        $primaryKey = $inputs['number'];
        $inputs['post_code'] = $inputs['post_code1'] . $inputs['post_code2'];
        $inputKeys = $this->getUpdateKeys();

        $changed = [];
        $existRow = $this->findByNumber($primaryKey);
        foreach ($inputKeys as $key) {
            if ($inputs[$key] !== $existRow[$key]) {
                $changed[$key] = $inputs[$key];
            }
        }

        if (count($changed) <= 0) {
            return;
        }
        
        $res = null;
        try {
            $this->begin();
            $res = $this->getTable('UserTable')->update($primaryKey, $changed);
            $this->commit();
        } catch (Exception $ex) {
            $this->rollback();
            throw new DatabaseException();
        }
        return $res;
    }
    
    private function getUpdateKeys()
    {
        return [
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
        ];
    }
}
