<?php

namespace UserRegister\Form\InputFilter\Register;

use UserRegister\Form\InputFilter\AbstractInputFilter;

class RegisterInputFilter extends AbstractInputFilter
{
    public function __construct()
    {
        $this->add([
            'name' => 'number',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'UserRegister\Form\Validator\NumberFormat',
                ],
            ],
        ]);
    }
}