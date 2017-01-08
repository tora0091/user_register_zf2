<?php

namespace UserRegister\Form\InputFilter\Login;

use UserRegister\Form\InputFilter\AbstractInputFilter;

class LoginInputFilter extends AbstractInputFilter
{
    public function __construct()
    {
        // ログイン名
        // ※半角英大文字、半角英小文字、半角数字
        $this->add([
            'name' => 'user',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
        ]);

        // パスワード
        // ※半角英大文字、半角英小文字、半角数字、半角記号（+ * ? @ ! $ % & - = ~ : ;）
        $this->add([
            'name' => 'user',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
        ]);
    }
}
