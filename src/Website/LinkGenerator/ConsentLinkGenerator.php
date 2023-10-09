<?php

namespace App\Website\LinkGenerator;


use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\ClassDefinition\LinkGeneratorInterface;
use Pimcore\Model\DataObject\Concrete;

class ConsentLinkGenerator implements LinkGeneratorInterface
{
    public function generate(object $object, array $params = []): string
    {
        if (!($object instanceof \Pimcore\Model\DataObject\Consent)) {
            throw new \InvalidArgumentException('Given object is not an Consent Object');
        }

        return $this->doGenerate($object, $params);
    }

    protected function doGenerate(\Pimcore\Model\DataObject\Consent $object, array $params): string
    {
        // Retrieve the employee name from the Employee object
        $employeeFname = $object->getFirstname();
        $employeeLname = $object->getLastname();

        $url = '/consent/' . $employeeFname . '/' . $employeeLname;

        return $url;
    }
}
