<?php

namespace SpeckContact\Mapper;

use SpeckContact\Entity\Contact;

use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Stdlib\Hydrator\ClassMethods;

use ZfcBase\Mapper\AbstractDbMapper;

class ContactMapper extends AbstractDbMapper
{
    public function __construct()
    {
        $this->setHydrator(new ClassMethods);
        $this->setEntityPrototype(new Contact);
    }

    public function findById($id)
    {
        $select = new Select;
        $select->from('contact');

        $where = new Where;
        $where->equalTo('contact_id', $id);

        return $this->selectWith($select->where($where))->current();
    }

    public function findByCompanyId($id)
    {
        $select = new Select;
        $select->from('contact_companies')
            ->join('contact', 'contact.contact_id = contact_companies.contact_id');

        $where = new Where;
        $where->equalTo('contact_companies.company_id', $id);

        return $this->selectWith($select->where($where));
    }

    public function fetch($filter = null)
    {
        $select = new Select;
        $select->from('contact')
            ->order('name');

        if ($filter !== null) {
            $where = new Where;
            $where->like('name', '%' . $filter . '%')
                ->OR
                ->like('display_name', '%' . $filter . '%');

            return $this->selectWith($select->where($where));
        } else {
            return $this->selectWith($select);
        }
    }
}
