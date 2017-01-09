<?php

namespace UserRegister\Form\Validator;

use UserRegister\Common\Messages;
use Zend\Validator\AbstractValidator;

class UserFormat extends AbstractValidator
{
    const INVALID_USER = 'invaluser';
    
    protected $messageTemplates = [
        self::INVALID_USER => Messages::LOGIN_INVALID,
    ];

    public function isValid($value)
    {
        $this->setValue($value);
        if (!preg_match("/^[a-zA-Z0-9]{4,16}+$/", $value)) {
            $this->error(self::INVALID_USER);
            return false;
        }
        return true;
    }
}