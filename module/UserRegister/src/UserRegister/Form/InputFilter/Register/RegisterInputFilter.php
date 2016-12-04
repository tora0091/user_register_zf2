<?php

namespace UserRegister\Form\InputFilter\Register;

use UserRegister\Form\InputFilter\AbstractInputFilter;
use UserRegister\Common\Messages;
use Zend\Validator\NotEmpty;

class RegisterInputFilter extends AbstractInputFilter
{
    public function __construct()
    {
        // 社員番号
        $this->add([
            'name' => 'number',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => Messages::NUMBER_IS_EMPTY,
                        ],
                    ],
                ],
                [
                    'name' => 'UserRegister\Form\Validator\NumberFormat',
                ],
            ],
        ]);

        // 名前（姓）        
        $this->add([
            'name' => 'family_name',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => Messages::FAMILY_NAME_IS_EMPTY,
                        ],
                    ],
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
            ],
        ]);

        // 名前（名）
        $this->add([
            'name' => 'last_name',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => Messages::LAST_NAME_IS_EMPTY,
                        ],
                    ],
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
            ],
        ]);

        // 名前（セイ）
        $this->add([
            'name' => 'family_name_kana',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => Messages::FAMILY_NAME_KANA_IS_EMPTY,
                        ],
                    ],
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 40,
                    ],
                ],
            ],
        ]);

        // 名前（メイ）
        $this->add([
            'name' => 'last_name_kana',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => Messages::LAST_NAME_KANA_IS_EMPTY,
                        ],
                    ],
                ],
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 40,
                    ],
                ],
            ],
        ]);
    }
}