<?php

namespace UserRegister\Form\InputFilter\Login;

use UserRegister\Form\InputFilter\AbstractInputFilter;
use UserRegister\Common\Messages;
use Zend\Validator\NotEmpty;

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
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => Messages::LOGIN_INVALID,
                        ],
                    ],
                ],
                [
                    'name' => 'UserRegister\Form\Validator\UserFormat',
                    'break_chain_on_failure' => true,
                ],
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
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => Messages::LOGIN_INVALID,
                        ],
                    ],
                ],
                [
                    'name' => 'UserRegister\Form\Validator\PasswordFormat',
                    'break_chain_on_failure' => true,
                ],
            ],
        ]);
    }
}
