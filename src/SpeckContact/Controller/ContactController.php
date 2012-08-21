<?php

namespace SpeckContact\Controller;

use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;

class ContactController extends AbstractActionController
{
    public function indexAction()
    {
        $service = $this->getServiceLocator()->get('SpeckContact\Service\ContactService');
    }
}
