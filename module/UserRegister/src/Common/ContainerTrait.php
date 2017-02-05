<?php

namespace UserRegister\Common;

use Zend\Session\Container;

trait ContainerTrait
{
    /**
     * セッション情報取得
     * @param string $namespace セッション名
     * @return Container
     */
    public function getContainer($namespace = null)
    {
        if ($namespace === null) {
            $namespace = get_class($this);
        }
        return new Container($namespace);
    }
    
    /**
     * セッションクリア
     * @param string $namespace
     * @return void
     */
    public function clearContainer($namespace = null)
    {
        if ($namespace === null) {
            $namespace = get_class($this);
        }
        $this->getContainer()->getManager()->getStorage()->clear($namespace);
    }

    /**
     * セッションオールクリア
     * @return void
     */
    public function clearAllContainer()
    {
        $this->getContainer()->getManager()->getStorage()->clear();
    }
}
