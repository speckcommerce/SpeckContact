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

    public function fetch($filter = null)
    {
        $select = new Select;
        $select->from('contact_company')
            ->order('name');

        if ($filter !== null) {
            $where = new Where;
            $where->like('name', '%' . $filter . '%')
                ->OR
                ->like('display_name', '%' . $filter . '%');

            return $this->select($select->where($where));
        } else {
            return $this->select($select);
        }
    }

    public function findByContactId($id)
    {
        $sql = new Select;
        $sql->from(array('cc' => 'contact_companies'))
            ->join(array('c' => 'contact_company'), 'c.company_id = cc.company_id');

        $where = new Where;
        $where->equalTo('cc.contact_id', $id);

        return $this->select($sql->where($where));
    }
}
