<?php

namespace UserRegister\Controller;

use UserRegister\Common\Messages;
use UserRegister\Form\InputFilter\Login\LoginInputFilter;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractController
{
    const URL_MENU_INDEX_ACTION = '/menu';
    const URL_INDEX_ACTION = '/';

    const TAMPLATE_INDEX = 'user-register/login/index';
    
    public function indexAction()
    {
        $view = new ViewModel();

        $session = $this->getSession();
        if (!empty($session->errMsg)) {
            $errMsg = $session->errMsg;
            $session->offsetUnset('errMsg');
            $view->setVariable('errMsg', $errMsg);
        }
        $this->token()->setToken($view, $session);
        $view->setTemplate(self::TAMPLATE_INDEX);
        return $view;
    }
    
    public function validateAction()
    {
        $session = $this->getSession();
        $this->token()->checkToken($this->getRequest(), $session);
        
        $input = $this->getInputFilter(new LoginInputFilter());
        if (!$input->isValid()) {
            $session->errMsg = Messages::LOGIN_INVALID;
            return $this->redirect()->toUrl(self::URL_INDEX_ACTION);
        }

        // admin テーブルに対して認証チェック
        $user = $input->getValue('user');
        $password = $input->getValue('password');
        $loginService = $this->getService('LoginService');
        $userInfo = $loginService->isAuthSuccess($user, $password);
        if (!$userInfo) {
            $session->errMsg = Messages::LOGIN_INVALID;
            return $this->redirect()->toUrl(self::URL_INDEX_ACTION);
        }

        // セッションにログイン情報を格納
        $this->getGlobalSession()->admin = [
            'user' => $userInfo['user'],
            'auth' => $userInfo['auth'],
        ];
        return $this->redirect()->toUrl(self::URL_MENU_INDEX_ACTION);
    }
}