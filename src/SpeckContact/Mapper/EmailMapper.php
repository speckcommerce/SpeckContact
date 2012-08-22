<?php

namespace SpeckContact\Mapper;

use SpeckContact\Entity\Email;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Stdlib\Hydrator\ClassMethods;

use ZfcBase\Mapper\AbstractDbMapper;

class EmailMapper extends AbstractDbMapper
{
    public function __construct()
    {
        $this->setHydrator(new ClassMethods);
        $this->setEntityPrototype(new Email);
    }

    public function findByContactId($id)
    {
        $sql = new Select;
        $sql->from('contact_email');

        $where = new Where;
        $where->equalTo('contact_id', $id);

        return $this->selectWith($sql->where($where));
    }
}
