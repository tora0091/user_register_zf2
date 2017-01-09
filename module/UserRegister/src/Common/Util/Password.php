<?php

namespace UserRegister\Common\Util;

class Password
{
    /**
     * make pasword hash
     * @param string $password
     * @return hash
     */
    public static function makePasswordHash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * verity password
     * @param string $password
     * @param string $hash
     * @return boolean true:OK/false:NG
     */    
    public static function isVerity($password, $hash)
    {
        return password_verify($password, $hash);
    }
}