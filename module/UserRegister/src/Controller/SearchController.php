<?php

namespace UserRegister\Controller;

use UserRegister\Common\Exception\FileNotFoundException;
use Zend\View\Model\ViewModel;

class SearchController extends AbstractController
{
    const TAMPLATE_INDEX = 'user-register/search/index';
    const TAMPLATE_USER = 'user-register/search/user';

    public function indexAction()
    {
        $view = new ViewModel();
        $session = $this->getSession();
        $searchList = [];

        // 検索ボタン押下
        if ($this->getRequest()->isPost()) {
            $this->token()->checkToken($this->getRequest(), $session);

            $searchData = [];
            $paramNames = ['number', 'section_id'];
            foreach ($paramNames as $name) {
                if ($this->params()->fromPost($name) !== null && $this->params()->fromPost($name) !== '') {
                    $searchData[$name] = $this->params()->fromPost($name);
                }
            }
            // 検索処理
            $searchList = $this->getService('SearchService')->search($searchData);
            $view->setVariable('inputs', $searchData);
        }
        $this->token()->setToken($view, $session);
        $view->setVariable('searchList', $searchList);
        $view->setVariable('sectionList', $this->getSectionList());
        $view->setTemplate(self::TAMPLATE_INDEX);
        return $view;
    }
    
    public function userAction()
    {
        $view = new ViewModel();

        $number = $this->params()->fromRoute('number', null);
        if ($number === null) {
            throw new FileNotFoundException();
        }

        $inputs = $this->getService('UpdateService')->findByNumber($number);
        if (count($inputs) <= 0) {
            throw new FileNotFoundException();
        }
        // 郵便番号分割
        if (isset($inputs['post_code']) && strlen($inputs['post_code']) > 0) {
            $inputs += $this->splitPostCode($inputs['post_code']);
        }
        $inputs['prefectureText'] = $this->getCodeText($inputs['prefecture_id'], $this->getPrefectureList());
        $inputs['sectionText'] = $this->getCodeText($inputs['section_id'], $this->getSectionList());
        $view->setVariable('inputs', $inputs);
        $view->setTemplate(self::TAMPLATE_USER);
        return $view;
    }
}
