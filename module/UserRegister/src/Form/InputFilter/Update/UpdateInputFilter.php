<?php

namespace UserRegister\Form\InputFilter\Update;

use UserRegister\Form\InputFilter\Register\RegisterInputFilter;
use UserRegister\Common\Messages;
use Zend\Validator\InArray;
use Zend\Validator\NotEmpty;

class UpdateInputFilter extends RegisterInputFilter
{
    public function __construct()
    {
        parent::__construct();

        // ステータス
        $this->add([
            'name' => 'status',
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
                            NotEmpty::IS_EMPTY => Messages::STATUS_IS_EMPTY,
                        ],
                    ],
                ],
                [
                    'name' => 'InArray',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'haystack' => ['0', '1'],       // 0:無効 1:有効
                        'messages' => [
                            InArray::NOT_IN_ARRAY => Messages::STATUS_NOT_IN_ARRAY,
                        ],
                    ],
                ],
            ],
        ]);
    }
}