<?php

namespace UserRegister\Controller;

use UserRegister\Common\ContainerTrait;
use UserRegister\Common\LoggingTrait;
use Zend\InputFilter\InputFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractController extends AbstractActionController
{
    use ContainerTrait;
    use LoggingTrait;

    const SERVICE_PATH = 'UserRegister\Service\\';
    
    /** @var \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator */
    protected $serviceLocator;

    /** @var $prefectureList */
    private $prefectureList;

    /** @var $sectionList */
    private $sectionList;
    
    /**
     * Construt
     * @param ServiceLocatorInterface $serviceLocator
     */    
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * getServiceLocator
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
    
    /**
     * サービス取得
     * @param string $name サービス名
     * @return object
     */
    public function getService($name)
    {
        if (!strpos(self::SERVICE_PATH, $name)) {
            $name = self::SERVICE_PATH . $name;
        }
        return $this->getServiceLocator()->get($name);
    }
    
    /**
     * 環境定義変数を取得する
     * @param string $name 環境変数
     * @return array 対象環境変数の値
     */
    public function getConfig($name = 'default')
    {
        $config = $this->getServiceLocator()->get('config');
        if (isset($config[$name])) {
            return $config[$name];
        }
        return [];
    }
    
    /**
     * 入力バリデーション設定および取得
     * @param InputFilter $input バリデーションオブジェクト
     * @return InputFilter
     */
    public function getInputFilter(InputFilter $input)
    {
        $input->setData($this->getRequest()->getPost());
        return $input;
    }
    
    /**
     * セッション取得
     * @param string $name セッション名
     * @return Container
     */
    public function getSession($name = null)
    {
        return $this->getContainer($name);
    }

    /**
     * Globalセッション取得
     * @return Container
     */    
    public function getGlobalSession()
    {
        return $this->getSession('global');
    }
    
    /**
     * セッション削除
     * @param string $name セッション名
     */
    public function clearSession()
    {
        $this->clearContainer();
    }
    
    /**
     * セッション削除
     */
    public function clearGlobalSession()
    {
        $this->clearContainer('global');
    }
    
    /**
     * セッション全削除
     */
    public function clearAll()
    {
        $this->clearAllContainer();
    }
    
    /**
     * 都道府県リスト取得
     * @return array 都道府県リスト
     */
    public function getPrefectureList()
    {
        if ($this->prefectureList === null) {
            $this->prefectureList = $this->getService('RegisterService')->getPrefecture();
        }
        return $this->prefectureList;
    }
    
    /**
     * 部署名リスト取得
     * @return array 部署名リスト
     */
    public function getSectionList()
    {
        if ($this->sectionList === null) {
            $this->sectionList = $this->getService('RegisterService')->getSection();
        }
        return $this->sectionList;
    }

    /**
     * リストから対象のテキストを取得
     * @param string $code 取得するID
     * @param array $lists 対象リスト
     * @return string 対象テキスト
     */
    protected function getCodeText($code, $lists)
    {
        foreach ($lists as $list) {
            if ((int) $list['id'] === (int) $code) {
                return $list['name'];
            }
        }
        return "";
    }

    /**
     * 郵便番号分割
     * @param string $postCode 郵便番号
     * @return array
     */
    protected function splitPostCode($postCode)
    {
        $data['post_code1'] = "";
        $data['post_code2'] = "";
        if (isset($postCode) && strlen($postCode) > 0) {
            $data['post_code1'] = substr($postCode, 0, 3);
            $data['post_code2'] = substr($postCode, 3, 4);
        }
        return $data;
    }
}
