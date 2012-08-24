<?php

namespace SpeckContact\Form\Phone;

use Zend\Form\Form;

class Base extends Form
{
    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            'name' => 'tag',
            'options' => array(
                'label' => 'Label',
            ),
        ));

        $this->add(array(
            'name' => 'phone',
            'options' => array(
                'label' => 'Phone',
            ),
        ));
    }
}
