<?php

namespace ProductBundle\Model\Employee\AdminStyle;

use Pimcore\Model\DataObject;
use Pimcore\Model\Element\AdminStyle;
use Pimcore\Model\Element\ElementInterface;

class Employee extends AdminStyle
{
    protected ElementInterface $element;

    public function __construct(ElementInterface $element)
    {
        parent::__construct($element);

        $this->element = $element;

        if ($element instanceof DataObject\Testclass) {
            DataObject\Service::useInheritedValues(true, function () use ($element) {
                if ($element->getId() == 14) {
                    $this->elementIcon = '/bundles/pimcoreadmin/img/twemoji/1f697.svg';
                }
            });
        }
    }
    /**
     * {@inheritdoc}
     */
    public function getElementQtipConfig(): ?array
    {
        if ($this->element instanceof DataObject\Testclass) {
            $element = $this->element;

            return DataObject\Service::useInheritedValues(true, function () use ($element) {
                $text = '<h1>' . $element->getName() . '</h1>';
                $text .= wordwrap($this->element->getDescription(), 50, "<br>");
                $mainImage = $element->getImage();
                if ($mainImage) {
                    $thumbnail = $mainImage->getThumbnail("content");
                    $text .= '<p><img src="' . $thumbnail . '" width="150" height="150"/></p>';
                }
                return [
                    "title" => "ID: " . $element->getId() . " - Year: " . $element->getCreationDate(),
                    "text" => $text,
                ];
            });
        }

        return parent::getElementQtipConfig();
    }
}
