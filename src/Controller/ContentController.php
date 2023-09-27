<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Component\HttpFoundation\Request;

class ContentController extends FrontendController
{
    #[Template('content/default.html.twig')]
    public function defaultAction(Request $request): array
    {
        return [];
    }

    public function movieAction(Request $request)
    {
        return $this->render('content/movie.html.twig');
    }
}
