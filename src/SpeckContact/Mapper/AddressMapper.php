<?php

namespace SpeckContact\Mapper;

use SpeckAddress\Entity\Address;

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

    public function link($contact_id, $address_id)
    {
        $data = compact('contact_id', 'address_id');

        try {
          $this->insert($data, 'contact_addresses');
        } catch (\Exception $e) {
            // already inserted, but that's okay
            return;
        }
    }

    public function unlink($contactId, $addressId)
    {
        $adapter = $this->getDbAdapter();
        $statement = $adapter->createStatement();

        $where = new Where;
        $where->equalTo('contact_id', $contactId)
            ->equalTo('address_id', $addressId);

        $delete = new Delete;
        $delete->from('contact_addresses')
            ->where($where);

        $delete->prepareStatement($adapter, $statement);
        $result = $statement->execute();
        return $result;
    }
}
