<?php

namespace SpeckContact\Entity;

use SpeckAddress\Entity\Address as SpeckAddressAddress;

class Address extends SpeckAddressAddress
{
    protected $tag;

    public function getTag()
    {
        return $this->tag;
    }

    public function setTag($tag)
    {
        $this->tag = $tag;
        return $this;
    }
}
