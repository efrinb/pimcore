<?php

use Pimcore\Bundle\ApplicationLoggerBundle\PimcoreApplicationLoggerBundle;
use Pimcore\Bundle\BundleGeneratorBundle\PimcoreBundleGeneratorBundle;
use Pimcore\Bundle\CustomReportsBundle\PimcoreCustomReportsBundle;
use Pimcore\Bundle\SimpleBackendSearchBundle\PimcoreSimpleBackendSearchBundle;

return [
    PimcoreCustomReportsBundle::class => ['all' => true],
    PimcoreApplicationLoggerBundle::class => ['all' => true],
    PimcoreSimpleBackendSearchBundle::class => ['all' => true],
    PimcoreBundleGeneratorBundle::class => ['all' => true],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['all' => true],
    EmployeeBundle\EmployeeBundle::class => ['all' => true],
    CustomBundle\CustomBundle::class => ['all' => true],
    ProductBundle\ProductBundle::class => ['all' => true],
    LogBundle\LogBundle::class => ['all' => true],
    AdminConfBundle\AdminConfBundle::class => ['all' => true],
];
