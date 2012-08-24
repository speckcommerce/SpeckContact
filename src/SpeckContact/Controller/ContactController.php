<?php

namespace SpeckContact\Controller;

use SpeckContact\Form\Contact\Base as ContactBase;
use SpeckContact\Form\Contact\BaseFilter as ContactBaseFilter;

use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ContactController extends AbstractActionController
{
    public function indexAction()
    {
        $service = $this->getServiceLocator()->get('SpeckContact\Service\ContactService');
        $contacts = $service->getContacts(false);

        return array('contacts' => $contacts);
    }

    public function listCompaniesAction()
    {
        $service = $this->getServiceLocator()->get('SpeckContact\Service\ContactService');
        $companies = $service->listCompanies();

        return array('companies' => $companies);
    }

    public function viewCompanyAction()
    {
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $service = $this->getServiceLocator()->get('SpeckContact\Service\ContactService');

        $vm = new ViewModel(array(
            'contacts' => $service->findByCompanyId($id),
        ));
        $vm->setTemplate('speck-contact/contact/index');

        return $vm;
    }

    public function viewAction()
    {
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $service = $this->getServiceLocator()->get('SpeckContact\Service\ContactService');

        return array(
            'contact' => $service->findById($id),
        );
    }

    public function addContactAction()
    {
        $form = new ContactBase;
        $form->setInputFilter(new ContactBaseFilter);

        $prg = $this->prg('contact/add-contact');

        if ($prg instanceof Response) {
            return $prg;
        } else if ($prg === false) {
            return array('form' => $form);
        }

        $form->setData($prg);

        if (!$form->isValid()) {
            return array('form' => $form);
        }

        $service = $this->getServiceLocator()->get('SpeckContact\Service\ContactService');
        $contact = $service->createContact($form->getData());

        return $this->redirect()->toRoute('contact/view', array('id' => $contact->getContactId()));
    }
}
