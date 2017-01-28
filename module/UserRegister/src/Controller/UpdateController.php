<?php

namespace UserRegister\Controller;

use Zend\View\Model\ViewModel;

class UpdateController extends AbstractController
{
    const TAMPLATE_INDEX = 'user-register/update/index';
    
    public function indexAction()
    {
        $view = new ViewModel();
        $view->setTemplate(self::TAMPLATE_INDEX);
        return $view;
    }
}
