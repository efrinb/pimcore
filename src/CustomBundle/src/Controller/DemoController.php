<?php

namespace CustomBundle\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemoController extends FrontendController
{
    /**
     * @Route("/custom")
     */
    public function indexAction(Request $request): Response
    {
        return new Response('Hello world from employee');
    }
}
