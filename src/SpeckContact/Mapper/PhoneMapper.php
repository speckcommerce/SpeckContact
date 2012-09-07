<?php

namespace SpeckContact\Mapper;

use SpeckContact\Entity\Phone;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Stdlib\Hydrator\ClassMethods;

use ZfcBase\Mapper\AbstractDbMapper;

class PhoneMapper extends AbstractDbMapper
{
    public function __construct()
    {
        $this->setHydrator(new ClassMethods);
        $this->setEntityPrototype(new Phone);
    }

    public function findByContactId($id)
    {
        $sql = new Select;
        $sql->from('contact_phone');

        $where = new Where;
        $where->equalTo('contact_id', $id);

        return $this->select($sql->where($where));
    }

    public function persist($phone)
    {
        try {
            $this->insert($phone, 'contact_phone');
        } catch (\Exception $e) {
            $where = new Where;
            $where->equalTo('contact_id', $phone->getContactId())
                ->equalTo('tag', $phone->getTag());

            $this->update($phone, $where, 'contact_phone');
        }

        return $phone;
    }
}

