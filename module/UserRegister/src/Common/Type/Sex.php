<?php

namespace UserRegister\Common\Type;

class Sex
{
    const KEY_MALE = '1';
    const KEY_FEMALE = '2';
    
    const TEXT_MALE = '男性';
    const TEXT_FEMALE = '女性';
    
    private $sexList = [
        self::KEY_MALE => self::TEXT_MALE,
        self::KEY_FEMALE => self::TEXT_FEMALE,
    ];

    public function getSexText($key)
    {
        if (isset($this->sexList[$key])) {
            return $this->sexList[$key];
        }
        return "";
    }

    public function getMaleText()
    {
        return $this->getSexText(self::KEY_MALE);
    }

    public function getFemaleText()
    {
        return $this->getSexText(self::KEY_FEMALE);
    }
    
    public function isMale($key)
    {
        return $key === self::KEY_MALE;
    }

    public function isFemale($key)
    {
        return $key === self::KEY_FEMALE;
    }
}