<?php

namespace UserRegister\Form\Validator;

use UserRegister\Common\Messages;
use Zend\Validator\AbstractValidator;

class PasswordFormat extends AbstractValidator
{
    const INVALID_PASSWORD = 'invalpassword';
    
    protected $messageTemplates = [
        self::INVALID_PASSWORD => Messages::LOGIN_INVALID,
    ];

    public function isValid($value)
    {
        $this->setValue($value);
        if (!preg_match("/^[a-zA-Z0-9+*?@!$%&-=~:;]{8,16}+$/", $value)) {
            $this->error(self::INVALID_PASSWORD);
            return false;
        }
        return true;
    }
}