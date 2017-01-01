<?php

namespace UserRegister\Form\Validator;

use Zend\Validator\StringLength;

class StringLengthEmpty extends StringLength
{
    /**
     * @see \Zend\Validator\StringLength
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

