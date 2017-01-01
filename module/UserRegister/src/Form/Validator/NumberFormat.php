<?php

namespace UserRegister\Form\Validator;

use UserRegister\Common\Messages;
use Zend\Validator\AbstractValidator;

class NumberFormat extends AbstractValidator
{
    const INVALID = 'numberFormatInvalid';

    protected $messageTemplates = [
        self::INVALID => Messages::NUMBER_INVAL_FORMAT,
    ];

    protected $options = [
        'nullOk' => false,  // Null OK option
    ];

    /**
     * 社員番号形式バリデーション
     * @param string $value 社員番号
     * @return boolean true:OK false:NG
     */
    public function isValid($value)
    {
        if ($this->options['nullOk']) {
            if (is_null($value) || strlen($value) === 0) {
                return true;
            }
        }
        
        $this->setValue($value);
        if (!preg_match('/^[A-Z]\d{5}$/', $value)) {
            $this->error(self::INVALID);
            return false;
        }
        return true;
    }
}

