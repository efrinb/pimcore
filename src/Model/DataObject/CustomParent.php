<?php

namespace App\Model\DataObject;

use Pimcore\Model\DataObject\Concrete;

class CustomParent extends Concrete
{
    protected ?string $CustomAttribute;

    public function getAttribute(): ?string
    {
        return $this->CustomAttribute;
    }

    public function setAttribute(string $value): void
    {
        $this->CustomAttribute = $value;
    }
}
