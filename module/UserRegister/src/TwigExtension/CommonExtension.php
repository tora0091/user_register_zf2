<?php

namespace UserRegister\TwigExtension;

use Twig_Extension;
use Twig_SimpleFunction;
use UserRegister\Common\Type\Auth;
use UserRegister\Common\Type\Sex;
use UserRegister\Common\Type\Status;

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
        ];
    }

    /**
     * @return array
     */
    public function getFunctions() 
    {
        return [
            new Twig_SimpleFunction('section_text', [$this, 'getSectionText']),
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
}
