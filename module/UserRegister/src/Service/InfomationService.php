<?php

namespace UserRegister\Service;

use UserRegister\Service\AbstractService;

class InfomationService extends AbstractService
{
    public function getInfomationList()
    {
        return $this->getTable("InfomationTable")->getInfomationList();
    }
}