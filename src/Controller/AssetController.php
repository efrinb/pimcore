<?php

namespace App\Controller;

use Pimcore\Model\Asset;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AssetController extends AbstractController
{
    /**
     * Create and save a new asset.
     *
     * @Route("/create-asset", name="create_asset")
     * @throws \Exception
     */
    public function createAsset(): JsonResponse
    {
        $newAsset = new Asset();
        $newAsset->setParentId(1);
        $newAsset->setFilename("e10.jpg");
        $newAsset->setData(file_get_contents($_SERVER['DOCUMENT_ROOT']. '/images/e10.jpg'));
        $newAsset->setParent(Asset::getByPath("/images"));

        $newAsset->save(["versionNote" => "my new version"]);

        return new JsonResponse(['message'=> 'Success']);
    }
}
