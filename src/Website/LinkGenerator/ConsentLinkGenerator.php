<?php

namespace App\Website\LinkGenerator;

use Pimcore\Model\DataObject\ClassDefinition\LinkGeneratorInterface;

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
        $employeeFname = $object->getFirstname();
        $employeeLname = $object->getLastname();

        $linkGeneratedUrl = '/consent/'. $employeeFname . '/' . $employeeLname;

        return $linkGeneratedUrl;
    }
}
