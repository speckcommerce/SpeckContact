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

    public function findById($id)
    {
        $select = new Select;
        $select->from('contact_company')
            ->order('name')
            ->where(array('company_id' => $id));
        return $this->select($select)->current();
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

    public function persist($company, $contactId = null)
    {
        if ($company->getCompanyId() > 0) {
            $where = new Where;
            $where->equalTo('company_id', $company->getCompanyId());
            $this->update($company, $where, 'contact_company');
        } else {
            $result = $this->insert($company, 'contact_company');
            $company->setCompanyId($result->getGeneratedValue());
            if ($contactId) {
                $linker = array(
                    'company_id' => $company->getCompanyId(),
                    'contact_id' => $contactId,
                );
                $this->insert($linker, 'contact_companies');
            }
        }

        return $company;
    }
}
