<?php

namespace UserRegister\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class AbstractController extends AbstractActionController
{
    /**
     * 環境定義変数を取得する
     * @param string $name 環境変数
     * @return array 対象環境変数の値
     */
    public function getConfig($name = 'default')
    {
        $config = $this->getEvent()->getApplication()->getConfig();
        if (isset($config[$name])) {
            return $config[$name];
        }
        return [];
    }
}
