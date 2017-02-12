<?php

namespace UserRegister\Common\Util;

class Environment
{
    /** 環境ごとにあわせる */
    const ENV_PRODUCTION = 'production';
    const ENV_STAGING = 'staging';
    const ENV_DEVELOP = 'develop';
    const ENV_LOCAL = 'local';
    
    private $env;
    
    public function __construct()
    {
        // サーバ環境変数取得：APPLICATION_ENV
        // ※.htaccess や Apache側で設定済みとする
        $this->env = getenv('APPLICATION_ENV') ?: self::ENV_PRODUCTION;
    }
    
    public function isProduction()
    {
        return $this->env === self::ENV_PRODUCTION;
    }

    public function isStaging()
    {
        return $this->env === self::ENV_STAGING;
    }

    public function isDevelop()
    {
        return $this->env === self::ENV_DEVELOP;
    }

    public function isLocal()
    {
        return $this->env === self::ENV_LOCAL || (strlen($this->env) <= 0);
    }
}


