<?php
declare(strict_types=1);

/**
 * @category    integration-configuration class
 * @date        28/11/2023
 * @author      Efrin Babu <efrin.b@codilar.com>
 * @copyright   Copyright (c) 2023 Codilar (https://www.codilar.com/)
 */

namespace MagentoIntegrationBundle\EventListener;

use Pimcore\Event\Model\DataObjectEvent;
use Pimcore\Model\DataObject\MagentoIntegration;
use Symfony\Component\HttpClient\HttpClient;
use Pimcore\Bundle\ApplicationLoggerBundle\ApplicationLogger;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ApiEventLister
{
    private ApplicationLogger $applicationLogger;

    public function __construct(ApplicationLogger $applicationLogger)
    {
        $this->applicationLogger = $applicationLogger;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function onPostAdd(DataObjectEvent $event)
    {
        $dataObject = $event->getObject();

        if ($dataObject instanceof MagentoIntegration)
        {
            $objectId = $dataObject->getId();
            $key      = $dataObject->getKey();
            $name     = 'Efrin';

            $endpoint   = 'https://codilar-pimcore-test.free.beeceptor.com/dataobjects/test';
            $httpClient = HttpClient::create();
            $response   = $httpClient->request('POST', $endpoint, [
                'json' => ['objectId' => $objectId, 'key' => $key, 'name' => $name],
            ]);

            $statusCode = $response->getStatusCode();
            $content    = $response->getContent();

            $logMessage = sprintf(
                'API request sent - objectId: %s, key: %s, name: %s, statusCode: %d, content: %s',
                $objectId,
                $key,
                $name,
                $statusCode,
                $content
            );
            $this->applicationLogger->info($logMessage);
        }
        else{
            $this->applicationLogger->info('Object is not saved and published');
        }
    }
}
