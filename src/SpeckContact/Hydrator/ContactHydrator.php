<?php

namespace SpeckContact\Hydrator;

use Zend\Stdlib\Hydrator\HydratorInterface;

class ContactHydrator implements HydratorInterface
{
    public function extract($object)
    {
        $result = array(
            'contact_id'   => $object->getContactId(),
            'name'         => $object->getName(),
            'display_name' => $object->getDisplayName(),
        );

        return $result;
    }

    public function hydrate(array $data, $object)
    {
        $object->setName($data['name'])
            ->setDisplayName($data['display_name']);

        if (array_key_exists('contact_id', $data)) {
            $object->setContactId($data['contact_id']);
        }

        return $object;
    }
}
