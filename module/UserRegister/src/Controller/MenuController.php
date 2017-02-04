<?php

namespace UserRegister\Controller;

use Zend\View\Model\ViewModel;

class MenuController extends AbstractController
{
    /** @var tamplate index */
    const TAMPLATE_INDEX = 'user-register/menu/index';
    
    public function indexAction()
    {
        $view = new ViewModel();
        $view->setVariable("infomation", $this->getService("InfomationService")->getInfomationList());
        $view->setTemplate(self::TAMPLATE_INDEX);
        return $view;
    }
}
