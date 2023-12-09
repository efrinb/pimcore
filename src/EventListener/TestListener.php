<?php

namespace App\EventListener;

use Pimcore\Event\Model\ElementEventInterface;
use Pimcore\Event\Model\DataObjectEvent;
use Pimcore\Event\Model\AssetEvent;
use Pimcore\Event\Model\DocumentEvent;
use Pimcore\Bundle\ApplicationLoggerBundle\ApplicationLogger;

class TestListener
{
    private $applicationLogger;

    public function __construct(ApplicationLogger $applicationLogger){
        $this->applicationLogger = $applicationLogger;
    }
    public function onPreUpdate(ElementEventInterface $event): void
    {
        if ($event instanceof AssetEvent){
            $asset = $event->getAsset();
            $this->applicationLogger->info('Asset being updated: ' . $asset->getFilename());
        } elseif ($event instanceof DocumentEvent){
            $document = $event->getDocument();
            $this->applicationLogger->info('Document being updated: ' . $document->getKey());
        } elseif ($event instanceof DataObjectEvent){
            $object = $event->getObject();
            $this->applicationLogger->info('Data Object being updated: ' . $object->getKey());
        }
    }
    public function onPreAdd(ElementEventInterface $event): void
    {
        if ($event instanceof AssetEvent){
            $asset = $event->getAsset();
            $this->applicationLogger->info('Asset was added: ' . $asset->getFilename());
        }elseif ($event instanceof DocumentEvent){
            $document = $event->getDocument();
            $this->applicationLogger->info('Document was added: ' . $document->getKey());
        } elseif ($event instanceof DataObjectEvent){
            $object = $event->getObject();
            $this->applicationLogger->info('Data Object was added: ' . $object->getKey());
        }
    }

    public function onPreDelete(ElementEventInterface $event): void
    {
        if ($event instanceof AssetEvent){
            $asset = $event->getAsset();
            $this->applicationLogger->info('Asset was deleted: ' . $asset->getFilename());
        }elseif ($event instanceof DocumentEvent){
            $document = $event->getDocument();
            $this->applicationLogger->info('Document was deleted: ' . $document->getKey());
        } elseif ($event instanceof DataObjectEvent){
            $object = $event->getObject();
            $this->applicationLogger->info('Data Object was deleted: ' . $object->getKey());
        }
    }
}
