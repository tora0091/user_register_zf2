<?php

namespace UserRegister\Controller\Ajax;

use UserRegister\Controller\AbstractController;
use Zend\View\Model\JsonModel;

class CheckNumberController extends AbstractController
{
    public function indexAction()
    {
        $result = false;
        if ($this->getRequest()->isPost()) {
            $number = $this->params()->fromPost('number', null);
            if (!$this->getService('RegisterService')->isExist($number)) {
                // 社員番号が存在しない
                $result = true;
            }
        }
        $jsonModel = new JsonModel(['result' => $result]);
        return $jsonModel;
    }
}
