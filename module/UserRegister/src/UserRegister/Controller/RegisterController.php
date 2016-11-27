<?php

namespace UserRegister\Controller;

use Zend\View\Model\ViewModel;

class RegisterController extends AbstractController
{
    /**
     * 登録アクション
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel();
    }
    
    /**
     * バリデーション
     */
    public function validateAction()
    {

    }
}
