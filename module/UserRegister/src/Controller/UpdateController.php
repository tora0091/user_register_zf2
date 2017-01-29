<?php

namespace UserRegister\Controller;

use UserRegister\Form\InputFilter\Update\UpdateInputFilter;
use UserRegister\Common\Exception\FileNotFoundException;
use Zend\View\Model\ViewModel;

class UpdateController extends AbstractController
{
    const URL_INDEX_ACTION = '/update';
    const URL_CONFIRM_ACTION = '/update/confirm';
    const URL_COMPLETE_ACTION = '/update/complete';

    const TAMPLATE_INDEX = 'user-register/update/index';
    const TEMPLATE_CONFIRM = 'user-register/update/confirm';
    const TEMPLATE_COMPLETE = 'user-register/update/complete';
    
    public function indexAction()
    {
        $view = new ViewModel();
        $view->setVariable('prefectureList', $this->getPrefectureList());
        $view->setVariable('sectionList', $this->getSectionList());

        $session = $this->getSession();
        if (!empty($session->errMsg)) {
            $errMsg = $session->errMsg;
            $session->offsetUnset('errMsg');
            $view->setVariable('errMsg', $errMsg);
        }

        // パラメータ確認
        $number = ($this->params()->fromPost('number') === null) ? $session->inputs['number'] : $this->params()->fromPost('number');
        if ($number === null) {
            $this->redirectPage();
        }
        $view->setVariable('number', $number);

        // 登録データ取得
        $inputs = $session->inputs;
        if ($inputs === null) {
            $updateService = $this->getService('UpdateService');
            $inputs = $updateService->findByNumber($number);
            if (count($inputs) <= 0) {
                $this->redirectPage();
            }
        }

        // 郵便番号分割
        if (isset($inputs['post_code']) && strlen($inputs['post_code']) > 0) {
            $inputs['post_code1'] = substr($inputs['post_code'], 0, 3);
            $inputs['post_code2'] = substr($inputs['post_code'], 3, 4);
        }
        $view->setVariable('inputs', $inputs);
        
        $this->token()->setToken($view, $session);
        $view->setTemplate(self::TAMPLATE_INDEX);
        return $view;
    }
    
    public function validateAction()
    {
        $session = $this->getSession();
        $this->token()->checkToken($this->getRequest(), $session);
        
        $input = $this->getInputFilter(new UpdateInputFilter());
        $session->inputs = $input->getValues();
        
        if (!$input->isValid()) {
            $session->errMsg = $input->getMessages();
            return $this->redirect()->toUrl(self::URL_INDEX_ACTION);
        }
        return $this->redirect()->toUrl(self::URL_CONFIRM_ACTION);
    }
    
    public function confirmAction()
    {
        $view = new ViewModel();
        $this->token()->setToken($view, $this->getSession());
        
        $inputs = $this->getSession()->inputs;
        if (count($inputs) <= 0) {
            throw new FileNotFoundException();
        }
        $inputs['prefectureText'] = $this->getCodeText($inputs['prefecture_id'], $this->getPrefectureList());
        $inputs['sectionText'] = $this->getCodeText($inputs['section_id'], $this->getSectionList());
        $view->setVariable('inputs', $inputs);
        $view->setTemplate(self::TEMPLATE_CONFIRM);
        return $view;
    }

    private function redirectPage()
    {
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Location', '/menu');
        $response->setStatusCode(302);
    }
}
