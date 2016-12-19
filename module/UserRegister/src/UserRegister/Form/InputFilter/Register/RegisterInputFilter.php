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
                [
                    'name' => 'Callback',
                    'options' => [
                        'callback' => 'mb_convert_kana',
                        'callback_params' => 'KVA',
                    ],
                ],
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
                [
                    'name' => 'Callback',
                    'options' => [
                        'callback' => 'mb_convert_kana',
                        'callback_params' => 'KVA',
                    ],
                ],
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
                [
                    'name' => 'Callback',
                    'options' => [
                        'callback' => 'mb_convert_kana',
                        'callback_params' => 'KVA',
                    ],
                ],
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
                [
                    'name' => 'UserRegister\Form\Validator\StringKatakana',
                    'break_chain_on_failure' => true,
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
                [
                    'name' => 'Callback',
                    'options' => [
                        'callback' => 'mb_convert_kana',
                        'callback_params' => 'KVA',
                    ],
                ],
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
                [
                    'name' => 'UserRegister\Form\Validator\StringKatakana',
                    'break_chain_on_failure' => true,
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
        
        // 郵便番号１
        $this->add([
            'name' => 'post_code1',
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
                            NotEmpty::IS_EMPTY => Messages::POST_CODE_IS_EMPTY,
                        ],
                    ],
                ],
                [
                    'name' => 'StringLength',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'min' => 3,
                        'max' => 3,
                        'message' => [
                            StringLength::TOO_SHORT => Messages::POST_CODE_LENGTH,
                            StringLength::TOO_LONG => Messages::POST_CODE_LENGTH,
                        ],
                    ],
                ],
                [
                    'name' => 'Digits',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'messages' => [
                            Digits::NOT_DIGITS => Messages::POST_CODE_NOT_DIGITS,
                        ],
                    ],
                ],
            ],
        ]);
        
        // 郵便番号２
        $this->add([
            'name' => 'post_code2',
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
                            NotEmpty::IS_EMPTY => Messages::POST_CODE_IS_EMPTY,
                        ],
                    ],
                ],
                [
                    'name' => 'StringLength',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'min' => 4,
                        'max' => 4,
                        'message' => [
                            StringLength::TOO_SHORT => Messages::POST_CODE_LENGTH,
                            StringLength::TOO_LONG => Messages::POST_CODE_LENGTH,
                        ],
                    ],
                ],
                [
                    'name' => 'Digits',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'messages' => [
                            Digits::NOT_DIGITS => Messages::POST_CODE_NOT_DIGITS,
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
        
        // 市区町村
        $this->add([
            'name' => 'address_city',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
                [
                    'name' => 'Callback',
                    'options' => [
                        'callback' => 'mb_convert_kana',
                        'callback_params' => 'KVA',
                    ],
                ],
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => Messages::ADDRESS_CITY_IS_EMPTY,
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
                            StringLength::TOO_SHORT => Messages::ADDRESS_CITY_LENGTH,
                            StringLength::TOO_LONG => Messages::ADDRESS_CITY_LENGTH,
                        ],
                    ],
                ],
            ],
        ]);

        // 住所その他
        $this->add([
            'name' => 'address_other',
            'required' => false,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
                [
                    'name' => 'Callback',
                    'options' => [
                        'callback' => 'mb_convert_kana',
                        'callback_params' => 'KVA',
                    ],
                ],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'min' => 1,
                        'max' => 40,
                        'message' => [
                            StringLength::TOO_SHORT => Messages::ADDRESS_CITY_OTHER,
                            StringLength::TOO_LONG => Messages::ADDRESS_CITY_OTHER,
                        ],
                    ],
                ],
            ],
        ]);

        // 所属部署
        $this->add([
            'name' => 'section',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
        ]);
    }
}