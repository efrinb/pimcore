<?php

namespace MagentoIntegrationBundle;

use MagentoIntegrationBundle\Tool\Installer;
use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\PimcoreBundleAdminClassicInterface;
use Pimcore\Extension\Bundle\Traits\BundleAdminClassicTrait;

class MagentoIntegrationBundle extends AbstractPimcoreBundle implements PimcoreBundleAdminClassicInterface
{
    use BundleAdminClassicTrait;

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function getJsPaths(): array
    {
        return [
            '/bundles/magentointegration/js/pimcore/startup.js'
        ];
    }

    public function getInstaller(): Installer
    {
        return $this->container->get(Installer::class);
    }

}
