<?php

namespace SpeckContact\Service;

use SpeckContact\Entity\Contact;
use SpeckContact\Entity\Company;
use SpeckContact\Entity\Email;
use SpeckContact\Entity\Phone;
use SpeckContact\Entity\Url;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class ContactService implements ServiceManagerAwareInterface
{
    protected $companyMapper;
    protected $contactMapper;
    protected $addressMapper;
    protected $emailMapper;
    protected $phoneMapper;
    protected $urlMapper;
    protected $serviceManager;

    public function findById($id)
    {
        $contact = $this->contactMapper->findById($id);
        $contact = $this->getExtras($contact);

        return $contact;
    }

    public function findCompanyById($companyId)
    {
        $company = $this->getCompanyMapper()->findById($companyId);
        $company = $this->getCompanyExtras($company);

        return $company;
    }

    public function findByCompanyId($companyId, $extra = false)
    {
        $contacts = $this->contactMapper->findByCompanyId($companyId);

        $result = array();
        foreach ($contacts as $contact) {
            $result[] = $contact;
        }

        if ($extra) {
            foreach ($result as $contact) {
                $this->getExtras($contact);
            }
        }

        return $result;
    }

    public function getContacts($extra = false, $filter = null)
    {
        $contacts = $this->contactMapper->fetch($filter);

        $result = array();
        foreach ($contacts as $contact) {
            $result[] = $contact;
        }

        if ($extra) {
            foreach ($result as $contact) {
                $this->getExtras($contact);
            }
        }

        return $result;
    }

    public function getExtras(Contact $contact)
    {
        $id = $contact->getContactId();

        $addresses = $this->addressMapper->findByContactId($id);
        foreach ($addresses as $i) {
            $contact->addAddress($i);
        }

        $companies = $this->companyMapper->findByContactId($id);
        foreach ($companies as $i) {
            $contact->addCompany($i);
        }

        $emails = $this->emailMapper->findByContactId($id);
        foreach ($emails as $i) {
            $contact->addEmail($i);
        }

        $phones = $this->phoneMapper->findByContactId($id);
        foreach ($phones as $i) {
            $contact->addPhone($i);
        }

        $urls = $this->urlMapper->findByContactId($id);
        foreach ($urls as $i) {
            $contact->addUrl($i);
        }

        return $contact;
    }

    public function getCompanyExtras(Company $company)
    {
        $id = $company->getCompanyId();

        $contacts = $this->getContactMapper()->findByCompanyId($id);
        foreach ($contacts as $i) {
            $company->addContact($i);
        }

        return $company;
    }

    public function listCompanies($filter = null)
    {
        return $this->companyMapper->fetch($filter);
    }

    public function createContact($data)
    {
        $contact = new Contact;
        $hydrator = new ClassMethods;

        $contact = $hydrator->hydrate($data, $contact);

        return $this->contactMapper->persist($contact);
    }

    public function createCompany($data)
    {
        $company = new Company;
        $hydrator = new ClassMethods;

        $company = $hydrator->hydrate($data, $company);

        if (isset($data['contact_id'])) {
            $contact = $this->findById($data['contact_id']);
            if (!$contact) {
                throw new \Exception (sprintf(
                    'cannot create company with contact linker because contact with id: %s doesnt exist',
                    $data['contact_id']
                ));
            };
            return $this->companyMapper->persist($company, $contact->getContactId());
        }

        return $this->companyMapper->persist($company);
    }

    public function createEmail($data, $contactId)
    {
        $email = new Email;
        $email->setTag($data['tag'])
            ->setEmail($data['email'])
            ->setContactId($contactId);

        return $this->emailMapper->persist($email);
    }

    public function createPhone($data, $contactId)
    {
        $phone = new Phone;
        $phone->setTag($data['tag'])
            ->setPhone($data['phone'])
            ->setContactId($contactId);

        return $this->phoneMapper->persist($phone);
    }

    public function createUrl($data, $contactId)
    {
        $url = new Url;
        $url->setTag($data['tag'])
            ->setUrl($data['url'])
            ->setContactId($contactId);

        return $this->urlMapper->persist($url);
    }

    public function createAddress($data, $contactId)
    {
        $addressService = $this->serviceManager->get('SpeckAddress\Service\Address');
        $address = $addressService->create($data);

        return $this->addressMapper->link($contactId, $address->getAddressId());
    }

    /*************************
     * Mapper getter/setters
     *************************/
    public function getContactMapper()
    {
        return $this->contactMapper;
    }

    public function setContactMapper($contactMapper)
    {
        $this->contactMapper = $contactMapper;
        return $this;
    }

    public function getAddressMapper()
    {
        return $this->addressMapper;
    }

    public function setAddressMapper($addressMapper)
    {
        $this->addressMapper = $addressMapper;
        return $this;
    }

    public function getCompanyMapper()
    {
        return $this->companyMapper;
    }

    public function setCompanyMapper($companyMapper)
    {
        $this->companyMapper = $companyMapper;
        return $this;
    }

    public function getEmailMapper()
    {
        return $this->emailMapper;
    }

    public function setEmailMapper($emailMapper)
    {
        $this->emailMapper = $emailMapper;
        return $this;
    }

    public function getPhoneMapper()
    {
        return $this->phoneMapper;
    }

    public function setPhoneMapper($phoneMapper)
    {
        $this->phoneMapper = $phoneMapper;
        return $this;
    }

    public function getUrlMapper()
    {
        return $this->urlMapper;
    }

    public function setUrlMapper($urlMapper)
    {
        $this->urlMapper = $urlMapper;
        return $this;
    }

    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    public function setServiceManager(ServiceManager $sm)
    {
        $this->serviceManager = $sm;
        return $this;
    }
}
