<?php

namespace UserRegister\Service;

use UserRegister\Service\AbstractService;

class RegisterService extends AbstractService
{
    public function getPrefecture()
    {
        /** @see \UserRegister\Resource\Db\Table\PrefectureTable::getPrefecture() */
        return $this->getTable('PrefectureTable')->getPrefecture();
    }
}