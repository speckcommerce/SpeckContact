<?php

namespace SpeckContact\Controller;

use SpeckContact\Form\Contact\Base as ContactBase;
use SpeckContact\Form\Contact\BaseFilter as ContactBaseFilter;
use SpeckContact\Form\Email\Base as EmailBase;
use SpeckContact\Form\Email\BaseFilter as EmailBaseFilter;
use SpeckContact\Form\Phone\Base as PhoneBase;
use SpeckContact\Form\Phone\BaseFilter as PhoneBaseFilter;
use SpeckContact\Form\Url\Base as UrlBase;
use SpeckContact\Form\Url\BaseFilter as UrlBaseFilter;

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

        return $this->redirect()->toRoute('contact/contact', array('id' => $contact->getContactId()));
    }

    public function addCompanyAction()
    {
    }

    public function addAddressAction()
    {
    }

    public function addEmailAction()
    {
        $form = new EmailBase;
        $form->setInputFilter(new EmailBaseFilter);

        $id = $this->getEvent()->getRouteMatch()->getParam('id');

        $prg = $this->prg($this->url()->fromRoute('contact/contact/add-email', array('id' => $id)), true);

        if ($prg instanceof Response) {
            return $prg;
        } else if ($prg === false) {
            return array('form' => $form, 'id' => $id);
        }

        $form->setData($prg);

        if (!$form->isValid()) {
            return array('form' => $form, 'id' => $id);
        }

        $service = $this->getServiceLocator()->get('SpeckContact\Service\ContactService');
        $service->createEmail($form->getData(), $id);

        return $this->redirect()->toRoute('contact/contact', array('id' => $id));
    }

    public function addPhoneAction()
    {
        $form = new PhoneBase;
        $form->setInputFilter(new PhoneBaseFilter);

        $id = $this->getEvent()->getRouteMatch()->getParam('id');

        $prg = $this->prg($this->url()->fromRoute('contact/contact/add-phone', array('id' => $id)), true);

        if ($prg instanceof Response) {
            return $prg;
        } else if ($prg === false) {
            return array('form' => $form, 'id' => $id);
        }

        $form->setData($prg);

        if (!$form->isValid()) {
            return array('form' => $form, 'id' => $id);
        }

        $service = $this->getServiceLocator()->get('SpeckContact\Service\ContactService');
        $service->createPhone($form->getData(), $id);

        return $this->redirect()->toRoute('contact/contact', array('id' => $id));
    }

    public function addUrlAction()
    {
        $form = new UrlBase;
        $form->setInputFilter(new UrlBaseFilter);

        $id = $this->getEvent()->getRouteMatch()->getParam('id');

        $prg = $this->prg($this->url()->fromRoute('contact/contact/add-url', array('id' => $id)), true);

        if ($prg instanceof Response) {
            return $prg;
        } else if ($prg === false) {
            return array('form' => $form, 'id' => $id);
        }

        $form->setData($prg);

        if (!$form->isValid()) {
            return array('form' => $form, 'id' => $id);
        }

        $service = $this->getServiceLocator()->get('SpeckContact\Service\ContactService');
        $service->createUrl($form->getData(), $id);

        return $this->redirect()->toRoute('contact/contact', array('id' => $id));
    }
}
