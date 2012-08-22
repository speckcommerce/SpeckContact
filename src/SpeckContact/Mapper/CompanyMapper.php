<?php

namespace SpeckContact\Mapper;

use SpeckContact\Entity\Company;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Stdlib\Hydrator\ClassMethods;

use ZfcBase\Mapper\AbstractDbMapper;

class CompanyMapper extends AbstractDbMapper
{
    public function __construct()
    {
        $this->setHydrator(new ClassMethods);
        $this->setEntityPrototype(new Company);
    }

    public function findByContactId($id)
    {
        $sql = new Select;
        $sql->from(array('cc' => 'contact_companies'))
            ->join(array('c' => 'contact_company'), 'c.company_id = cc.company_id');

        $where = new Where;
        $where->equalTo('cc.contact_id', $id);

        return $this->selectWith($sql->where($where));
    }
}
