<?php

namespace SpeckContact\Mapper;

use SpeckContact\Entity\Address;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Stdlib\Hydrator\ClassMethods;

use ZfcBase\Mapper\AbstractDbMapper;

class AddressMapper extends AbstractDbMapper
{
    public function __construct()
    {
        $this->setHydrator(new ClassMethods);
        $this->setEntityPrototype(new Address);
    }

    public function findByContactId($id)
    {
        $sql = new Select;
        $sql->from(array('ca' => 'contact_addresses'))
            ->join(array('a' => 'address'), 'a.address_id = ca.address_id');

        $where = new Where;
        $where->equalTo('ca.contact_id', $id);

        return $this->selectWith($sql->where($where));
    }
}
