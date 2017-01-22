<?php

namespace UserRegister\Controller;

use Zend\View\Model\ViewModel;

class SearchController extends AbstractController
{
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
        return $view;
    }
}
