<?php

namespace UserRegister\TwigExtension;

use Twig_Extension;
use Twig_SimpleFunction;
use UserRegister\Common\Type\Auth;
use UserRegister\Common\Type\Sex;
use UserRegister\Common\Type\Status;
use UserRegister\Common\Util\Environment;

class CommonExtension extends Twig_Extension
{    
    /**
     * @return array
     */
    public function getGlobals()
    {
        return [
            'sex_func' => new Sex(),
            'status_func' => new Status(),
            'auth' => new Auth(),
            'env' => new Environment(),
        ];
    }

    /**
     * @return array
     */
    public function getFunctions() 
    {
        return [
            new Twig_SimpleFunction('section_text', [$this, 'getSectionText']),
            new Twig_SimpleFunction('php_*', [$this, 'phpFunctions'], ['is_safe' => null]),
        ];
    }

    /**
     * セクション名取得
     * @return string
     */
    public function getSectionText($id, array $sections = null)
    {
        foreach ($sections as $section) {
            if ($section['id'] === $id) {
                return $section['name'];
            }
        }
        return '';
    }

    /**
     * twigでphp関数の利用を可能とする
     */
    public function phpFunctions()
    {
        $arg_list = func_get_args();
        $function = array_shift($arg_list);

        $allowFunctions = [
            'var_dump',
        ];
        if (in_array($function, $allowFunctions) == false) {
            return null;
        }
        if (is_callable($function)) {
            return call_user_func_array($function, $arg_list);
        }

        $errMsg = 'Called to an undefined function : <b>php_' . $function . "</b> ";

        trigger_error($errMsg, E_USER_NOTICE);

        return null;
    }
}
