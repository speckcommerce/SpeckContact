<?php

namespace SpeckContact\Form\Contact;

use Zend\Form\Form;

class CompanyContact extends Base
{
    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            'name' => 'company_id',
            'type' => 'hidden',
        ));
    }
}
