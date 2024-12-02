<?php
declare(strict_types=1);

/**
 * @category    integration-configuration class
 * @date        28/11/2023
 * @author      Efrin Babu <efrin.b@codilar.com>
 * @copyright   Copyright (c) 2023 Codilar (https://www.codilar.com/)
 */

namespace MagentoIntegrationBundle\Controller;

use MagentoIntegrationBundle\Service\ApiAuthentication;
use Pimcore\Event\Model\DataObjectEvent;
use Pimcore\Model\DataObject\Concrete;
use Pimcore\Model\DataObject\MagentoIntegration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ApiController extends AbstractController
{
    private ApiAuthentication $apiAuthKey;
    public function __construct(ApiAuthentication $apiAuthKey)
    {
        $this->apiAuthKey = $apiAuthKey;
    }

    #[Route('/api/integration-configurations/{name}', name: 'api_create_integration_configuration', methods: ['POST'])]
    public function createIntegrationConfiguration(Request $request, $name, EventDispatcherInterface $eventDispatcher): JsonResponse
    {
        $apiToken = $request->headers->get('API-INT');
        if (!$this->apiAuthKey->apiAuth($apiToken)) {
            return $this->json(['error' => 'Invalid or missing API token'], 401);
        }

        $dataObject = new MagentoIntegration();
        $dataObject->setKey($name);
        $dataObject->setParentId(1);

        try {
            $dataObject->save();
            $dataObject->setPublished(true);

            if ($dataObject->getId()){
                $event = new DataObjectEvent($dataObject);
                $eventDispatcher->dispatch($event, "pimcore.dataobject.postAdd");

                return $this->json(['message' => 'MagentoIntegration Object is created successfully']);
            } else
            {
                return $this->json(['error' => 'Error creating MagentoIntegration object'], 500);
            }

        } catch (\Exception $e) {
            return $this->json(['error' => 'Error creating MagentoIntegration object: ' . $e->getMessage()], 500);
        }
    }

    #[Route('/api/integrationConfigurations/{id}', name: 'api_get_integration_configuration', methods: ['GET'])]
    public function getIntegrationConfiguration($id, Request $request): JsonResponse
    {
        $apiToken = $request->headers->get('API-INT');
        if (!$this->apiAuthKey->apiAuth($apiToken)) {
            return $this->json(['error' => 'Invalid or missing API token'], 401);
        }

        $concreteObject = Concrete::getById($id);

        if (!$concreteObject) {
            return $this->json(['error' => 'DataObject is not found'], 404);
        }

        $data = [
            'objectId' => $concreteObject->getId(),
            'key' => $concreteObject->getKey(),
            'name' => "Efrin"
        ];

        return $this->json($data);
    }
}
