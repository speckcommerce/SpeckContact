<?php

namespace SpeckContact\Mapper;

use SpeckContact\Entity\Url;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Stdlib\Hydrator\ClassMethods;

use ZfcBase\Mapper\AbstractDbMapper;

class UrlMapper extends AbstractDbMapper
{
    public function __construct()
    {
        $this->setHydrator(new ClassMethods);
        $this->setEntityPrototype(new Url);
    }

    public function findByContactId($id)
    {
        $sql = new Select;
        $sql->from('contact_url');

        $where = new Where;
        $where->equalTo('contact_id', $id);

        return $this->select($sql->where($where));
    }

    public function persist($url)
    {
        try {
            $this->insert($url, 'contact_url');
        } catch (\Exception $e) {
            $where = new Where;
            $where->equalTo('contact_id', $url->getContactId())
                ->equalTo('tag', $url->getTag());

            $this->update($url, $where, 'contact_url');
        }

        return $url;
    }
}


