<?php

namespace UserRegister\Controller;

use Zend\View\Model\ViewModel;

class MainController extends AbstractController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}
