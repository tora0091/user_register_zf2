<?php

namespace UserRegister\Common\Type;

use UserRegister\Common\ContainerTrait;

class Auth
{
    use ContainerTrait;
    
    const AUTH_TYPE_ADMIN = "admin";
    const AUTH_TYPE_USER = "user";
    
    private function getAdmin()
    {
        return $this->getContainer('global')->admin;
    }

    public function isAdmin()
    {
        $admin = $this->getAdmin();
        if ($admin['auth'] === self::AUTH_TYPE_ADMIN) {
            return true;
        }
        return false;
    }
}