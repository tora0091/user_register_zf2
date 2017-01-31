<?php

namespace UserRegister\Common\Type;

class Status
{
    const STATUS_DISENABLE = '0';
    const STATUS_ENABLE = '1';
    
    const TEXT_STATUS_DISENABLE = '無効';
    const TEXT_STATUS_ENABLE = '有効';
    
    private $list = [
        self::STATUS_DISENABLE => self::TEXT_STATUS_DISENABLE,
        self::STATUS_ENABLE => self::TEXT_STATUS_ENABLE,
    ];

    public function getStatusText($key)
    {
        if (isset($this->list[$key])) {
            return $this->list[$key];
        }
        return "";
    }

    public function getEnableKey()
    {
        return self::STATUS_ENABLE;
    }

    public function getDisableKey()
    {
        return self::STATUS_DISENABLE;
    }
    
    public function getEnableText()
    {
        return self::TEXT_STATUS_ENABLE;
    }
    
    public function getDisableText()
    {
        return self::TEXT_STATUS_DISENABLE;
    }
    
    public function isEnable($key)
    {
        return $key === self::STATUS_ENABLE;
    }

    public function isDisable($key)
    {
        return $key === self::STATUS_DISENABLE;
    }
}