<?php

namespace CustomBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\PimcoreBundleAdminClassicInterface;
use Pimcore\Extension\Bundle\Traits\BundleAdminClassicTrait;

class CustomBundle extends AbstractPimcoreBundle implements PimcoreBundleAdminClassicInterface //for admin interface integration,
{
    //to include methods and functionality specific to admin classic bundles
    use BundleAdminClassicTrait;

    //method returns the path to the bundle's directory.
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
