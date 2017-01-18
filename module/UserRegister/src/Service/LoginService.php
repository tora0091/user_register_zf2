<?php

namespace UserRegister\Service;

use UserRegister\Common\Util\Password;
use UserRegister\Service\AbstractService;

class LoginService extends AbstractService
{
    /**
     * ログイン可否
     * @param string $user user
     * @param string $password password
     * @return boolean|array
     */
    public function isAuthSuccess($user, $password)
    {
        // admin テーブルより入力されたユーザのデータ取得
        $userData = $this->getTable('AdminTable')->findByUser($user);
        if (count($userData) <= 0) {
            return false;
        }

        // 入力されたパスワードが登録されているパスワードと同じことを確認        
        if (!Password::isVerity($password, $userData['password'])) {
            return false;
        }
        return $userData;
    }
}