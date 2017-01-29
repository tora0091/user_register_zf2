<?php

namespace UserRegister\Service;

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
}
