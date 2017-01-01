<?php

namespace UserRegister\Form\Validator;

use Zend\Validator\NotEmpty;

class NotEmptyOthers extends NotEmpty
{
    protected $options = [
        'conditionKeys' => [], 
    ];

    /**
     * NotEmptyWhen
     * @param string $value
     */
    public function isValid($value, $context = null)
    {
        // どれかに入力が存在すれば true を返す
        if (empty($value)) {
            foreach ($this->options['conditionKeys'] as $key) {
                if (!empty($context[$key])) {
                    return true;
                }
            }
        }
        return parent::isValid($value);
    }
}
