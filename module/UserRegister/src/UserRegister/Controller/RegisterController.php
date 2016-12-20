<?php

namespace UserRegister\Controller;

use UserRegister\Form\InputFilter\Register\RegisterInputFilter;
use Zend\View\Model\ViewModel;

class RegisterController extends AbstractController
{
    /** url path */
    const URL_INDEX_ACTION = '/register';
    const URL_CONFIRM_ACTION = '/register/confirm';

    /** template name */
    const TEMPLATE_INDEX = 'user-register/register/index';
    const TEMPLATE_CONFIRM = 'user-register/register/confirm';
    
    /**
     * 登録アクション
     * @return ViewModel $view
     */
    public function indexAction()
    {
        $view = new ViewModel();
        
        /** @var \UserRegister\Service\RegisterServicve $registerService */
        $registerService = $this->getService('RegisterService');
        $prefectureList = $registerService->getPrefecture();
        $view->setVariable('prefectureList', $prefectureList);

        $session = $this->getSession();
        if (!empty($session->errMsg)) {
            $errMsg = $session->errMsg;
            $session->offsetUnset('errMsg');
            $view->setVariable('errMsg', $errMsg);
        }
        $this->token()->setToken($view, $session);
        
        $view->setVariable('inputs', $session->inputs);
        $view->setTemplate(self::TEMPLATE_INDEX);
        return $view;
    }
    
    /**
     * バリデーション
     * @return Response
     */
    public function validateAction()
    {
        $session = $this->getSession();
        $this->token()->checkToken($this->getRequest(), $session);
        
        $input = $this->getInputFilter(new RegisterInputFilter());
        $session->inputs = $input->getValues();
        
        if (!$input->isValid()) {
            // エラーの場合は入力画面へ戻る
            $session->errMsg = $input->getMessages();
            return $this->redirect()->toUrl(self::URL_INDEX_ACTION);
        }
        return $this->redirect()->toUrl(self::URL_CONFIRM_ACTION);
    }

    /**
     * 確認画面アクション
     * @return ViewModel $view
     */
    public function confirmAction()
    {
        $view = new ViewModel();
        $this->token()->setToken($view, $this->getSession());
        $view->setVariable('inputs', $this->getSession()->inputs);
        $view->setTemplate(self::TEMPLATE_CONFIRM);
        return $view;
    }
    
    /**
     * 更新処理
     * @return Response
     */
    public function updateAction()
    {
        
    }
    
    /**
     * 完了画面アクション
     * @return ViewModel $view
     */
    public function complete()
    {
        
    }
}
