<?php

namespace UserRegister\Controller\Plugin;

use UserRegister\Common\Exception\NotTokenException;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Http\Request;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class TokenPlugin extends AbstractPlugin
{
    public function __invoke()
    {
        return $this;
    }
    
    /**
     * setToken
     * @param ViewModel $view
     * @param Container $session
     */
    public function setToken(ViewModel $view, Container $session)
    {
        $token = md5(uniqid(rand(), true));
        
        $session->token = $token;
        $view->setVariable('token', $token);
    }

    /**
     * checkToken
     * @param Request $request
     * @param Container $session
     * @throws NotTokenException
     */    
    public function checkToken(Request $request, Container $session)
    {
        $postToken = $request->getPost('token');
        $sessionToken = $session->token;
        
        if ($postToken !== $sessionToken) {
            throw new NotTokenException();
        }
    }
}
