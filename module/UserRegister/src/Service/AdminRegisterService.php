<?php

namespace UserRegister\Service;

use UserRegister\Service\AbstractService;

class AdminRegisterService extends AbstractService
{
    public function getAdminList()
    {
        return $this->getTable('AdminTable')->getAdminList();
    }
}