<?php

namespace SpeckContact\Service;

use SpeckContact\Entity\Contact;

class ContactService
{
    protected $companyMapper;
    protected $contactMapper;
    protected $addressMapper;
    protected $emailMapper;
    protected $phoneMapper;
    protected $urlMapper;

    public function findById($id)
    {
        $contact = $this->contactMapper->findById($id);
        $contact = $this->getExtras($contact);

        return $contact;
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

    public function listCompanies($filter = null)
    {
        return $this->companyMapper->fetch($filter);
    }

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
}
