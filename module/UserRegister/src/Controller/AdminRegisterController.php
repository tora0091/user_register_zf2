<?php

namespace UserRegister\Controller;

use Zend\View\Model\ViewModel;

class AdminRegisterController extends AbstractController
{
    const TAMPLATE_INDEX = 'user-register/admin/register/index';

    public function indexAction()
    {
        $view = new ViewModel();
        $adminRegisterService = $this->getService('AdminRegisterService');
        $adminList = $adminRegisterService->getAdminList();

        $view->setVariable('adminList', $adminList);
        $view->setTemplate(self::TAMPLATE_INDEX);
        return $view;
    }
}
