<?php
declare(strict_types=1);

/**
 * @category    integration-configuration class
 * @date        28/11/2023
 * @author      Efrin Babu <efrin.b@codilar.com>
 * @copyright   Copyright (c) 2023 Codilar (https://www.codilar.com/)
 */

namespace MagentoIntegrationBundle\Tool;

use Exception;
use Pimcore\Cache;
use Pimcore\Extension\Bundle\Installer\AbstractInstaller;
use Pimcore\Model\DataObject\ClassDefinition;
use Pimcore\Model\DataObject\ClassDefinition\Service;
use Pimcore\Model\DataObject\Exception\DefinitionWriteException;
use Symfony\Component\Config\FileLocatorInterface;

class Installer extends AbstractInstaller
{
    private const CONFIGURATION_CLASS_NAME = 'MagentoIntegration';
    private const CLASS_DEFINITION_FILE_PATH = '@MagentoIntegrationBundle/config/install/classes/Magento_Integration_class.json';

    /** @var FileLocatorInterface */
    private FileLocatorInterface $fileLocator;

    public function __construct(FileLocatorInterface $fileLocator)
    {
        $this->fileLocator = $fileLocator;
        parent::__construct();
    }

    /**
     * @throws DefinitionWriteException
     */
    public function install(): void
    {
        $this->updateClassDefinition('install');
    }

    /**
     * @throws DefinitionWriteException
     */
    public function uninstall(): void
    {
        $this->updateClassDefinition('uninstall');
    }

    /**
     * @throws DefinitionWriteException
     * @throws Exception
     */
    private function updateClassDefinition(string $operation): void
    {
        Cache::disable();

        $class = ClassDefinition::getByName(self::CONFIGURATION_CLASS_NAME);

        if ($operation === 'install' && !$class) {
            $filePath = $this->locateClassDefinitionFile();
            $class = new ClassDefinition();
            $class->setName(self::CONFIGURATION_CLASS_NAME);
            $data = file_get_contents($filePath);
            Service::importClassDefinitionFromJson($class, $data);
        } elseif ($operation === 'uninstall' && $class) {
            $class->delete();
        }

        Cache::enable();
    }

    protected function locateClassDefinitionFile(): string
    {
        return $this->fileLocator->locate(self::CLASS_DEFINITION_FILE_PATH);
    }

    /**
     * @throws Exception
     */
    public function canBeInstalled(): bool
    {
        return !ClassDefinition::getByName(self::CONFIGURATION_CLASS_NAME);
    }

    /**
     * @throws Exception
     */
    public function canBeUninstalled(): bool
    {
        return ClassDefinition::getByName(self::CONFIGURATION_CLASS_NAME) instanceof ClassDefinition;
    }

    /**
     * @throws Exception
     */
    public function isInstalled(): bool
    {
        return $this->canBeUninstalled();
    }
}
