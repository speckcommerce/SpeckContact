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
use SpeckContact\Form\Company\Base as CompanyBase;
use SpeckContact\Form\Company\BaseFilter as CompanyBaseFilter;
use SpeckContact\Form\Company\ContactCompany;
use SpeckContact\Form\Company\ContactCompanyFilter;
use SpeckContact\Form\Contact\CompanyContact;
use SpeckContact\Form\Contact\CompanyContactFilter;

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
            'company' => $service->findCompanyById($id),
        ));
        $vm->setTemplate('speck-contact/contact/view-company');

        return $vm;
    }

    public function viewAction()
    {
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $service = $this->getServiceLocator()->get('SpeckContact\Service\ContactService');

        $vm = new ViewModel(array(
            'contact' => $service->findById($id),
        ));
        $vm->setTemplate('speck-contact/contact/view-contact');

        return $vm;
    }

    public function addContactAction()
    {
        $companyId = $this->params('id');
        if ($companyId) {
            $form = new CompanyContact;
            $form->setInputFilter(new CompanyContactFilter);
            $form->get('company_id')->setValue($companyId);
            $prg = $this->prg('/contact/company/' . $companyId . '/add-contact', true);
        } else {
            $form = new ContactBase;
            $form->setInputFilter(new ContactBaseFilter);
            $prg = $this->prg('contact/add-contact');
        }

        if ($prg instanceof Response) {
            return $prg;
        } else if ($prg === false) {
            return array('form' => $form, 'companyId' => $companyId);
        }

        $form->setData($prg);

        if (!$form->isValid()) {
            var_dump($form->getMessages());
            die('form invalid');
            return array('form' => $form, 'companyId' => $companyId, 'messages' => 'form invalid');
        }

        $service = $this->getServiceLocator()->get('SpeckContact\Service\ContactService');
        $contact = $service->createContact($form->getData());

        if ($companyId) {
            return $this->redirect()->toRoute('contact/company/view', array('id' => $companyId));
        } else {
            return $this->redirect()->toRoute('contact/contact', array('id' => $contact->getContactId()));
        }
    }

    public function addCompanyAction()
    {
        $contactId = $this->params('id');
        if ($contactId) {
            $form = new ContactCompany;
            $form->setInputFilter(new ContactCompanyFilter);
            $form->get('contact_id')->setValue($contactId);
            $prg = $this->prg('/contact/' . $contactId . '/add-company', true);
        } else {
            $form = new CompanyBase;
            $form->setInputFilter(new CompanyBaseFilter);
            $prg = $this->prg('contact/company/add-company');
        }

        if ($prg instanceof Response) {
            return $prg;
        } else if ($prg === false) {
            return new ViewModel(array('form' => $form, 'contactId' => $contactId));
        }

        $form->setData($prg);

        if (!$form->isValid()) {
            return array('form' => $form, 'contactId' => $contactId);
        }

        $service = $this->getServiceLocator()->get('SpeckContact\Service\ContactService');
        $company = $service->createCompany($form->getData());

        if ($contactId) {
            return $this->redirect()->toRoute('contact/contact', array('id' => $contactId));
        } else {
            return $this->redirect()->toRoute('contact/company/view', array('id' => $company->getCompanyId()));
        }
    }

    public function addAddressAction()
    {
        $vm = new ViewModel();
        $vm->setTemplate('speck-address/address/add');

        $id = $this->getEvent()->getRouteMatch()->getParam('id');

        $form = $this->getServiceLocator()->get('SpeckAddress\Form\Address');
        $form->setInputFilter($this->getServiceLocator()->get('SpeckAddress\Form\AddressFilter'));

        $prg = $this->prg($this->url()->fromRoute('contact/contact/add-address', array('id' => $id)), true);

        if ($prg instanceof Response) {
            return $prg;
        } else if ($prg === false) {
            $vm->form = $form;
            return $vm;
        }

        $form->setData($prg);

        if (!$form->isValid()) {
            $vm->form = $form;
            return $vm;
        }

        $service = $this->getServiceLocator()->get('SpeckContact\Service\ContactService');
        $service->createAddress($prg, $id);

        return $this->redirect()->toRoute('contact/contact', array('id' => $id));
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
