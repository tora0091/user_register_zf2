<?php

namespace UserRegister\Form\InputFilter\Register;

use UserRegister\Form\InputFilter\AbstractInputFilter;
use UserRegister\Common\Messages;
use Zend\Validator\Between;
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
                    'break_chain_on_failure' => true,
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => Messages::NUMBER_IS_EMPTY,
                        ],
                    ],
                ],
                [
                    'name' => 'UserRegister\Form\Validator\NumberFormat',
                    'break_chain_on_failure' => true,
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
                    'break_chain_on_failure' => true,
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => Messages::FAMILY_NAME_IS_EMPTY,
                        ],
                    ],
                ],
                [
                    'name' => 'StringLength',
                    'break_chain_on_failure' => true,
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
                    'break_chain_on_failure' => true,
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => Messages::LAST_NAME_IS_EMPTY,
                        ],
                    ],
                ],
                [
                    'name' => 'StringLength',
                    'break_chain_on_failure' => true,
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
                    'break_chain_on_failure' => true,
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => Messages::FAMILY_NAME_KANA_IS_EMPTY,
                        ],
                    ],
                ],
                [
                    'name' => 'StringLength',
                    'break_chain_on_failure' => true,
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
                    'break_chain_on_failure' => true,
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => Messages::LAST_NAME_KANA_IS_EMPTY,
                        ],
                    ],
                ],
                [
                    'name' => 'StringLength',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'min' => 1,
                        'max' => 40,
                    ],
                ],
            ],
        ]);
        



        
        // 都道府県
        $this->add([
            'name' => 'prefecture',
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
                            NotEmpty::IS_EMPTY => Messages::PREFECTURE_IS_EMPTY,
                        ],
                    ],
                ],
                [
                    'name' => 'Between',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'inclusive' => false,
                        'min' => '1',
                        'max' => '47',
                        'messages' => [
                            Between::NOT_BETWEEN_STRICT => Messages::PREFECTURE_INVAL_DATA,
                        ],
                    ],
                ],
            ],
        ]);
    }
}