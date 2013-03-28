<?php

namespace SpeckContact\Form\Contact;

use Zend\InputFilter\InputFilter;

class CompanyContactFilter extends BaseFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'company_id',
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
