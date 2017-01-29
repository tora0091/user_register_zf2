<?php

namespace UserRegister\Controller;

use Zend\View\Model\ViewModel;

class UpdateController extends AbstractController
{
    const TAMPLATE_INDEX = 'user-register/update/index';
    
    public function indexAction()
    {
        $view = new ViewModel();
        $view->setVariable('prefectureList', $this->getPrefectureList());
        $view->setVariable('sectionList', $this->getSectionList());

        // パラメータ確認
        $number = $this->params()->fromPost('number');
        if ($number === null) {
            $this->redirectPage();
        }

        // 登録データ取得
        $updateService = $this->getService('UpdateService');
        $inputs = $updateService->findByNumber($number);
        if (count($inputs) <= 0) {
            $this->redirectPage();
        }

        // 郵便番号分割
        if (strlen($inputs['post_code']) > 0) {
            $inputs['post_code1'] = substr($inputs['post_code'], 0, 3);
            $inputs['post_code2'] = substr($inputs['post_code'], 3, 4);
        }
        $view->setVariable('inputs', $inputs);
        
        $session = $this->getSession();
        $this->token()->setToken($view, $session);
        $view->setTemplate(self::TAMPLATE_INDEX);
        return $view;
    }
    
    private function redirectPage()
    {
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Location', '/menu');
        $response->setStatusCode(302);
    }
}
