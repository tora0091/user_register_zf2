<?php

namespace UserRegister\Common;

/**
 * LoggingTrait
 * [注意点]
 * Traitを組み込む側に、getServiceLocator() が必ず存在すること
 * getServiceLocator() は ServiceLocatorInterface を返すこと
 * ログ出力先に設定したファイルは先に作成すること、ServiceManager 側でエラーになる（config.*.php）
 * また、ログ出力先は絶対バスで記載する
 * 
 * 動かない時の確認
 * try {
 *     $logger = $this->getServiceLocator()->get('Log\\App');
 * } catch (\Exception $e) {
 *     do {
 *         var_dump($e->getMessage());
 *     } while ($e = $e->getPrevious());
 * }
 */
trait LoggingTrait
{
    /**
     * infoログを出力
     * @param string $message
     * @return void
     */
    protected function infoLog($message)
    {
        $this->getLogger()->info($this->getRemoteInfo() . $message);
    }

    /**
     * warnログを出力
     * @param string $message
     * @return void
     */
    protected function warnLog($message)
    {
        $this->getLogger()->warn($this->getRemoteInfo() . $message);
    }

    /**
     * errorLogログを出力
     * @param string $message
     * @return void
     */
    protected function errorLog($message)
    {
        $this->getLogger()->err($this->getRemoteInfo() . $message);
    }

    /**
     * debugログを出力
     * @param string $message
     * @return void
     */
    protected function debugLog($message)
    {
        $this->getLogger()->debug($message);
    }

    /**
     * ロガーを取得
     * @return Logger
     */
    private function getLogger()
    {
        return $this->getServiceLocator()->get('Log\App');
    }
    
    /**
     * リモート情報を取得
     * @return string リモート情報
     */
    private function getRemoteInfo()
    {
        $request = $this->getServiceLocator()->get('request');
        
        // LB利用時は、x_forwarded_for を利用
        $xForwardedFor = $request->getServer()->get('HTTP_X_FORWARDED_FOR');
        $remoteAddr = $request->getServer()->get('REMOTE_ADDR');
        $ip = isset($xForwardedFor) ? $xForwardedFor : $remoteAddr;
        
        $remoteInfo = "\"" . $ip . "\" " . 
                "\"" . $request->getServer()->get('REQUEST_URL') . "\" " . 
                "\"" . $request->getServer()->get('HTTP_USER_AGENT') . "\" ";

        return $remoteInfo;
    }
}