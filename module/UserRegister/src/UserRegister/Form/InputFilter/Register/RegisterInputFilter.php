<?php

namespace UserRegister\Form\InputFilter\Register;

use UserRegister\Form\InputFilter\AbstractInputFilter;
use UserRegister\Common\Messages;
use Zend\Validator\Between;
use Zend\Validator\Digits;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;

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
                        'message' => [
                            StringLength::TOO_SHORT => Messages::FAMILY_NAME_TOO_SHORT,
                            StringLength::TOO_LONG => Messages::FAMILY_NAME_TOO_LONG,
                        ],
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
                        'message' => [
                            StringLength::TOO_SHORT => Messages::LAST_NAME_TOO_SHORT,
                            StringLength::TOO_LONG => Messages::LAST_NAME_TOO_LONG,
                        ],
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
                        'message' => [
                            StringLength::TOO_SHORT => Messages::FAMILY_NAME_KANA_TOO_SHORT,
                            StringLength::TOO_LONG => Messages::FAMILY_NAME_KANA_TOO_LONG,
                        ],
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
                        'message' => [
                            StringLength::TOO_SHORT => Messages::LAST_NAME_KANA_TOO_SHORT,
                            StringLength::TOO_LONG => Messages::LAST_NAME_KANA_TOO_LONG,
                        ],
                    ],
                ],
            ],
        ]);
        
        // 電話番号
        $this->add([
            'name' => 'phone_number',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'UserRegister\Form\Validator\NotEmptyOthers',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'conditionKeys' => [
                            'mobile_phone_number',
                        ],
                        'messages' => [
                            NotEmpty::IS_EMPTY => Messages::PHONE_NUMBER_IS_EMPTY,
                        ],
                    ],
                ],
                [
                    'name' => 'UserRegister\Form\Validator\StringLengthEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'min' => 10,
                        'max' => 10,
                        'message' => [
                            StringLength::TOO_SHORT => Messages::PHONE_NUMBER_LENGTH,
                            StringLength::TOO_LONG => Messages::PHONE_NUMBER_LENGTH,
                        ],
                    ],
                ],
                [
                    'name' => 'UserRegister\Form\Validator\DigitsEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'messages' => [
                            Digits::NOT_DIGITS => Messages::PHONE_NUMBER_NOT_DIGITS,
                        ],
                    ],
                ],
            ],
        ]);
        
        // 携帯電話番号
        $this->add([
            'name' => 'mobile_phone_number',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'UserRegister\Form\Validator\NotEmptyOthers',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'conditionKeys' => [
                            'phone_number',
                        ],
                        'messages' => [
                            NotEmpty::IS_EMPTY => Messages::MOBILE_PHONE_NUMBER_IS_EMPTY,
                        ],
                    ],
                ],
                [
                    'name' => 'UserRegister\Form\Validator\StringLengthEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'min' => 11,
                        'max' => 11,
                        'message' => [
                            StringLength::TOO_SHORT => Messages::MOBILE_PHONE_NUMBER_LENGTH,
                            StringLength::TOO_LONG => Messages::MOBILE_PHONE_NUMBER_LENGTH,
                        ],
                    ],
                ],
                [
                    'name' => 'UserRegister\Form\Validator\DigitsEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'messages' => [
                            Digits::NOT_DIGITS => Messages::MOBILE_PHONE_NUMBER_NOT_DIGITS,
                        ],
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
                        'inclusive' => true,
                        'min' => '1',
                        'max' => '47',
                        'messages' => [
                            Between::NOT_BETWEEN => Messages::PREFECTURE_INVAL_DATA,
                        ],
                    ],
                ],
            ],
        ]);
    }
}