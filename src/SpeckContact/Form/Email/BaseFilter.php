<?php

namespace SpeckContact\Form\Email;

use Zend\InputFilter\InputFilter;

class BaseFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'tag',
            'required' => false,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 0,
                        'max' => 255,
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'email',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'EmailAddress',
                ),
            ),
        ));
    }
}
