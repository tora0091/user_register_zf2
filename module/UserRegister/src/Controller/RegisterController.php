<?php

namespace UserRegister\Controller;

use UserRegister\Form\InputFilter\Register\RegisterInputFilter;
use UserRegister\Common\Exception\FileNotFoundException;
use Zend\View\Model\ViewModel;

class RegisterController extends AbstractController
{
    /** url path */
    const URL_INDEX_ACTION = '/register';
    const URL_CONFIRM_ACTION = '/register/confirm';
    const URL_COMPLETE_ACTION = '/register/complete';

    /** template name */
    const TEMPLATE_INDEX = 'user-register/register/index';
    const TEMPLATE_CONFIRM = 'user-register/register/confirm';
    const TEMPLATE_COMPLETE = 'user-register/register/complete';
    
    /**
     * 登録アクション
     * @return ViewModel $view
     */
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
    
    /**
     * 更新処理
     * @return Response
     */
    public function registerAction()
    {
        $session = $this->getSession();
        $this->token()->checkToken($this->getRequest(), $session);

        $registerService = $this->getService('RegisterService');
        $registerService->insert($session->inputs);
        $this->clearSession();

        return $this->redirect()->toUrl(self::URL_COMPLETE_ACTION);
    }
    
    /**
     * 完了画面アクション
     * @return ViewModel $view
     */
    public function completeAction()
    {
        $view = new ViewModel();
        $view->setTemplate(self::TEMPLATE_COMPLETE);
        return $view;
    }
    
    /**
     * リストから対象のテキストを取得
     * @param string $code 取得するID
     * @param array $lists 対象リスト
     * @return string 対象テキスト
     */
    private function getCodeText($code, $lists)
    {
        foreach ($lists as $list) {
            if ((int) $list['id'] === (int) $code) {
                return $list['name'];
            }
        }
        return "";
    }
}