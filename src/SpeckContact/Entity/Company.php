<?php

namespace SpeckContact\Entity;

class Company
{
    protected $companyId;
    protected $name;
    protected $displayName;
    protected $contacts = array();

    public function getCompanyId()
    {
        return $this->companyId;
    }

    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;
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

    /**
     * @return contacts
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact)
    {
        $this->contacts[] = $contact;
        return $this;
    }

    /**
     * @param $contacts
     * @return self
     */
    public function setContacts($contacts)
    {
        $this->contacts = array();
        foreach ($contacts as $contact) {
            $this->addContact($contact);
        }
        return $this;
    }
}
