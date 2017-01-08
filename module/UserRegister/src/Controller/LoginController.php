<?php

namespace UserRegister\Controller;

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
            $session->errMsg = $input->getMessages();
            return $this->redirect()->toUrl(self::URL_INDEX_ACTION);
        }
        return $this->redirect()->toUrl(self::URL_MENU_INDEX_ACTION);
    }
}