<?php

namespace SpeckContact\Hydrator;

use Zend\Stdlib\Hydrator\HydratorInterface;

class CompanyHydrator implements HydratorInterface
{
    public function extract($object)
    {
        $result = array(
            'company_id'   => $object->getCompanyId(),
            'name'         => $object->getName(),
            'display_name' => $object->getDisplayName(),
        );

        return $result;
    }

    public function hydrate(array $data, $object)
    {
        $object->setName($data['name'])
            ->setDisplayName($data['display_name']);

        if (array_key_exists('company_id', $data)) {
            $object->setCompanyId($data['company_id']);
        }

        return $object;
    }
}
