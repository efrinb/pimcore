<?php

namespace App\EventListener;

use App\Model\Employee\AdminStyle\Employee;
use Pimcore\Model\DataObject\Myblock;


class AdminStyleListener
{
    public function onResolveElementAdminStyle(\Pimcore\Bundle\AdminBundle\Event\ElementAdminStyleEvent $event): void
    {
        $element = $event->getElement();
        if ($element instanceof Myblock) {
            $event->setAdminStyle(new Employee($element));
        }
    }


}
