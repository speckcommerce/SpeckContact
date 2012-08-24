<?php

namespace SpeckContact\Form\Url;

use Zend\InputFilter\InputFilter;
use Zend\Uri\Http;

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
            'name' => 'url',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'Uri',
                    'options' => array(
                        'allowRelative' => false,
                        'uriHandler' => new Http,
                    ),
                ),
            ),
        ));
    }
}
