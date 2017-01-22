<?php

namespace UserRegister\Service;

use UserRegister\Service\AbstractService;

class SearchService extends AbstractService
{
    public function search($data)
    {
        return $this->getTable('UserTable')->search($data);
    }
}