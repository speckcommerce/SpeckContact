<?php

namespace SpeckContact\Service;

class ContactService
{
    protected $contactMapper;
    protected $addressMapper;
    protected $emailMapper;
    protected $phoneMapper;
    protected $urlMapper;

    public function findById($id)
    {
        $contact = $this->contactMapper->findById($id);

        $address = $this->addressMapper->findByContactId($id);
        $emails = $this->emailMapper->findByContactId($id);
        $phone = $this->phoneMapper->findByContactId($id);
        $url = $this->urlMapper->findByContactId($id);

        return $contact;
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
