<?php

namespace UserRegister\Form\Validator;

use Zend\Validator\Digits;

class DigitsEmpty extends Digits
{
    /**
     * @see \Zend\Validator\Digits
     * @param string $value
     * @return boolean
     */
    public function isValid($value)
    {
        if (strlen($value) <= 0) {
            return true;
        }
        return parent::isValid($value);
    }
}

