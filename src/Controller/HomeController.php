<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Pimcore\Model\Asset;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends FrontendController
{
    #[Template('home/home.html.twig')]
    public function homeAction(Request $request)
    {
        return [];
    }

    public function employeeAction(Request $request)
    {
        return $this->render('home/employee.html.twig');
    }

    public function footerAction (Request $request)
    {
        return $this->render('home/footer.html.twig');
    }

    public function documentAction (Request $request)
    {
        return $this->render('home/document.html.twig');
    }

    public function attendenceAction()
    {
        return $this->render('home/attendence.html.twig');
    }

    public function leaveAction()
    {
        return $this->render('home/Leave.html.twig');
    }

    #[Template('home/gallery_renderlet.html.twig')]
    public function myGalleryAction(Request $request): array
    {
        if ('asset' === $request->get('type')) {
            $asset = Asset::getById((int) $request->get('id'));
            if ('folder' === $asset->getType()) {
                return [
                    'assets' => $asset->getChildren()
                ];
            }
        }

        return [];
    }

}
