<?php

namespace UserRegister\Form\Validator;

use UserRegister\Common\Messages;
use Zend\Validator\AbstractValidator;

class StringKatakana extends AbstractValidator
{
    const INVALID_ZENKAKU = 'stringKatakanaZenkakuInvalid';
    const INVALID_HANKAKU = 'stringKatakanaHankakuInvalid';

    protected $messageTemplates = [
        self::INVALID_ZENKAKU => Messages::INVALID_STRING_KATAKANA_ZENKAKU,
        self::INVALID_HANKAKU => Messages::INVALID_STRING_KATAKANA_HANKAKU,
    ];

    protected $options = [
        'isHankaku' => false,
    ];

    public function isValid($value)
    {
        $this->setValue($value);

        // 全角カタカナでければエラーとする
        if (!preg_match("/^(?:\xE3\x82[\xA1-\xBF]|\xE3\x83[\x80-\xB6])+$/", $value)) {
            $this->error(self::INVALID_ZENKAKU);
            return false;
        }
        
        // 半角カタカナでなければエラーとする
        if ($this->options['isHankaku'] && !preg_match("/^(?:\xEF\xBD[\xA1-\xBF]|\xEF\xBE[\x80-\x9F])+$/", $value)) {
            $this->error(self::INVALID_HANKAKU);
            return false;
        }

        return true;
    }
}
