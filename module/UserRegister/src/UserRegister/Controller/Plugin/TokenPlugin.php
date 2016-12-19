<?php

namespace UserRegister\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class TokenPlugin extends AbstractPlugin
{
    public function __invoke(ViewModel $view, Container $session)
    {
        $token = md5(uniqid(rand(), true));
        
        $session->token = $token;
        $view->setVariable('token', $token);
    }
}
