<?php

namespace SpeckContact\Form\Phone;

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
            'name' => 'phone',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 5,
                        'max' => 30,
                    ),
                ),
            ),
        ));
    }
}
