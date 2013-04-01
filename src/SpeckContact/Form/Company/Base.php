<?php

namespace SpeckContact\Form\Company;

use Zend\Form\Form;

class Base extends Form
{
    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            'name' => 'name',
            'options' => array(
                'label' => 'Name',
            ),
        ));

        $this->add(array(
            'name' => 'display_name',
            'options' => array(
                'label' => 'Display Name',
            ),
        ));
    }
}
