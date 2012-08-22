<?php

namespace SpeckContact\Controller;

use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;

class ContactController extends AbstractActionController
{
    public function indexAction()
    {
        $service = $this->getServiceLocator()->get('SpeckContact\Service\ContactService');
        $contacts = $service->getContacts(false);

        return array('contacts' => $contacts);
    }

    public function viewAction()
    {
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $service = $this->getServiceLocator()->get('SpeckContact\Service\ContactService');

        return array(
            'contact' => $service->findById($id),
        );
    }
}
