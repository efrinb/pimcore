<?php
declare(strict_types=1);

/**
 * @category    Product image update via command
 * @date        05/12/2023
 * @author      Efrin Babu <efrin.b@codilar.com>
 * @copyright   Copyright (c) 2023 Codilar (https://www.codilar.com/)
 */

namespace MagentoIntegrationBundle\Command;

use Exception;
use Pimcore\Model\Asset;
use Pimcore\Model\DataObject\ProductImage;
use Pimcore\Model\DataObject\Data\Hotspotimage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class UpdateProductImageName extends Command
{
    protected static $defaultName = 'app:update-product-image';

    protected function configure(): void
    {
        $this->setDescription('Update product with images and image gallery')
            ->addArgument('objectId', InputArgument::REQUIRED, 'Product object ID.');
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $objectId = $input->getArgument('objectId');
        $product = ProductImage::getById($objectId);

        if (!$product instanceof ProductImage) {
            $output->writeln('<error>Invalid product ID provided.</error>');
            return Command::FAILURE;
        }

        $productName = $product->getName();

        $asset = new Asset\Listing();
        $asset->setCondition("filename LIKE ? AND filename NOT LIKE ? AND filename NOT LIKE ?",
            [$productName . '%', $productName . '.%', $productName . '.%']
        );

        //retrieve the assets that match the conditions
        $matchingAssets = $asset->load();
        $productImageSet = false;
        $galleryItems = [];

        foreach ($matchingAssets as $matchingAsset) {
            if ($matchingAsset instanceof Asset\Image) {
                // Set the first image to the image field
                if (!$productImageSet) {
                    $product->setImage($matchingAsset);
                    $productImageSet = true;
                }

                // Create Hotspotimage object for each image in the gallery
                $imageData = new Hotspotimage();
                $imageData->setImage($matchingAsset);
                $galleryItems[] = $imageData;
            }
        }

        // Update product image gallery
        if (!empty($galleryItems)) {
            $gallery = $product->getImageGallery();
            if ($gallery === null) {
                $gallery = new \Pimcore\Model\DataObject\Data\ImageGallery();
            }

            // Set the updated gallery back to the product
            $gallery->setItems($galleryItems);
            $product->setImageGallery($gallery);
            $product->save(); // Save after all modifications

            $output->writeln('<info>Product image and gallery updated successfully.</info>');
        } else {
            $output->writeln('<info>No matching assets found for product image and gallery.</info>');
        }

        return Command::SUCCESS;
    }
}
