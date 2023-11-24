<?php

namespace AdminConfBundle\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Yaml;

class DefaultController extends FrontendController
{
    /**
     * @Route("/admin_conf")
     */
    public function indexAction(Request $request): Response
    {
        $configPath = $this->getParameter('kernel.project_dir') . '/bundles/AdminConfBundle/config/system.yaml';
        if (file_exists($configPath)) {
            $yamlData = file_get_contents($configPath);
            $data = Yaml::parse($yamlData);
            if ($data['config_checked'] === true){
                return $this->render("@AdminConfBundle/configData.html.twig",[
                    'configData'=>$data
                ]);
            }
        }
        return new Response('No Data Found!');
    }

    /**
     * @Route("/admin_config")
    */
    public function saveConfigAction(Request $request): JsonResponse
    {
        $data = json_decode($request->get('data'), true);

        if ($data === null){
            return new JsonResponse(['Success'=>false, 'message'=>'invalid data']);
        }
        $configPath = $this->getParameter('kernel.project_dir') . '/bundles/AdminConfBundle/config/system.yaml';

        $yamlData = Yaml::dump($data, 4);

        file_put_contents($configPath, $yamlData);

        return new JsonResponse(['success' => true, 'message' => 'Data saved successfully']);
    }


    /**
     * @Route("/admin_get_config")
     */
    public function getConfigAction(): JsonResponse
    {
        $configPath = $this->getParameter('kernel.project_dir') . '/bundles/AdminConfBundle/config/system.yaml';

        if (file_exists($configPath)) {
            $yamlData = file_get_contents($configPath);
            $data = Yaml::parse($yamlData);
            return new JsonResponse($data);
        }
        return new JsonResponse([]);
    }
}
