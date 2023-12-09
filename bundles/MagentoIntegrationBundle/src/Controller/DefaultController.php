<?php

namespace MagentoIntegrationBundle\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends FrontendController
{
    /**
     * @Route("/magento_integration")
     */
    public function indexAction(Request $request): Response
    {
        return new Response('Hello world from magento_integration');
    }
}
