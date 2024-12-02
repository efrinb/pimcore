<?php
declare(strict_types=1);

/**
 * @category    integration-configuration class
 * @date        28/11/2023
 * @author      Efrin Babu <efrin.b@codilar.com>
 * @copyright   Copyright (c) 2023 Codilar (https://www.codilar.com/)
 */

namespace MagentoIntegrationBundle\Service;

class ApiAuthentication
{
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function apiAuth(string $apiKey): bool
    {
        return $apiKey === $this->apiKey;
    }
}
