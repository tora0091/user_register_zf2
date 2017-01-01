<?php

namespace UserRegister\TwigExtension;

use Twig_Extension;
use Twig_SimpleFunction;

class CommonExtension extends Twig_Extension
{
    /**
     * @see Twig_Extension::getFunctions()
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
