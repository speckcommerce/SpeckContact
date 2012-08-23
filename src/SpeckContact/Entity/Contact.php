<?php

namespace SpeckContact\Entity;

class Contact
{
    protected $contactId;
    protected $name;
    protected $displayName;

    protected $companies = array();
    protected $emails = array();
    protected $phones = array();
    protected $urls = array();
    protected $addresses = array();

    public function getContactId()
    {
        return $this->contactId;
    }

    public function setContactId($contactId)
    {
        $this->contactId = $contactId;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getDisplayName()
    {
        return $this->displayName;
    }

    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
        return $this;
    }

    public function getCompanies()
    {
        return $this->companies;
    }

    public function setCompanies($companies)
    {
        $this->companies = $companies;
        return $this;
    }

    public function addCompany($company)
    {
        $this->companies[] = $company;
        return $this;
    }

    public function getEmails()
    {
        return $this->emails;
    }

    public function setEmails($emails)
    {
        $this->emails = $emails;
        return $this;
    }

    public function addEmail($email)
    {
        $this->emails[] = $email;
    }

    public function getPhones()
    {
        return $this->phones;
    }

    public function setPhones($phones)
    {
        $this->phones = $phones;
        return $this;
    }

    public function addPhone($phone)
    {
        $this->phones[] = $phone;
        return $this;
    }

    public function getUrls()
    {
        return $this->urls;
    }

    public function setUrls($urls)
    {
        $this->urls = $urls;
        return $this;
    }

    public function addUrl($url)
    {
        $this->urls[] = $url;
        return $this;
    }

    public function getAddresses()
    {
        return $this->addresses;
    }

    public function setAddresses($addresses)
    {
        $this->addresses = $addresses;
        return $this;
    }

    public function addAddress($address)
    {
        $this->addresses[] = $address;
        return $this;
    }
}
