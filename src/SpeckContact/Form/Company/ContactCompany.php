<?php

namespace SpeckContact\Form\Company;

use Zend\Form\Form;

class ContactCompany extends Base
{
    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            'name' => 'contact_id',
            'type' => 'hidden',
        ));
    }
}
