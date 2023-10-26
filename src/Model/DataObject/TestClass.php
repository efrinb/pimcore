<?php

namespace ProductBundle\Model\DataObject;
class TestClass extends \Pimcore\Model\DataObject\Testclass
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
