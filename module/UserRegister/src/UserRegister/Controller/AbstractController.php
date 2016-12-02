<?php

namespace UserRegister\Controller;

use UserRegister\Utils\ContainerTrait;
use Zend\InputFilter\InputFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

class AbstractController extends AbstractActionController
{
    use ContainerTrait;

    /** @var $serviceLocator */
    protected $serviceLocator;

    /** @var $adapter */
    private $adapter;

    /**
     * Construt
     * @param ServiceLocatorInterface $serviceLocator
     */    
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * 環境定義変数を取得する
     * @param string $name 環境変数
     * @return array 対象環境変数の値
     */
    public function getConfig($name = 'default')
    {
        $config = $this->serviceLocator->get('config');
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
    public function clearSession($name)
    {
        $this->clearContainer($name);
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
        $this->clearContainer();
    }
    
    /**
     * DB Adapter
     * @return Adapter
     */
    private function getAdapter()
    {
        if ($this->adapter == null) {
            $this->adapter = GlobalAdapterFeature::getStaticAdapter();
        }
        return $this->adapter;
    }

    /**
     * db connection
     * @return ConnectionInterface
     */
    public function connection()
    {
        return $this->getAdapter()->getDriver()->getConnection();
    }
    
    /**
     * begin
     */
    public function begin()
    {
        $this->connection()->beginTransaction();
    }

    /**
     * commit
     */
    public function commit()
    {
        $this->connection()->commit();
    }

    /**
     * rollback
     */
    public function rollback()
    {
        $this->connection()->rollback();
    }
}
