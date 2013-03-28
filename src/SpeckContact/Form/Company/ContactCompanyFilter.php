<?php

namespace SpeckContact\Form\Company;

use Zend\InputFilter\InputFilter;

class ContactCompanyFilter extends BaseFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'contact_id',
            'required' => true,
            //'validators' => array(
            //    array(
            //        'name' => 'StringLength',
            //        'options' => array(
            //            'min' => 3,
            //            'max' => 255,
            //        ),
            //    ),
            //),
        ));
    }
}

