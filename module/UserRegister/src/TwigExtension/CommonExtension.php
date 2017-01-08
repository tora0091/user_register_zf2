<?php

namespace UserRegister\TwigExtension;

use Twig_Extension;
use Twig_SimpleFunction;
use UserRegister\Common\Type\Sex;

class CommonExtension extends Twig_Extension
{
    /**
     * @return array
     */
    public function getGlobals()
    {
        return [
            'sexFunction' => new Sex(),
        ];
    }

    /**
     * @return array
     */
    public function getFunctions() 
    {
        return [
            new Twig_SimpleFunction('showBranchName', [$this, 'showBranchName']),
        ];
    }

    /**
     * アプリケーションのURLを取得する
     * @return string
     */
    public function showBranchName()
    {
        
    }
}
