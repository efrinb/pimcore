<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Pimcore\Model\Asset;
use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\TestCollection;
use Pimcore\Model\DataObject\Service;
use Pimcore\Model\Document\Editable\Block;
use Pimcore\Model\Document\Link;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends FrontendController
{
    #[Template('home/home.html.twig')]
    public function homeAction(Request $request)
    {
        return [];
    }

    public function employeeAction(Request $request)
    {
        $taskOject = DataObject\Myblock::getById(5);
        $structuredTable = $taskOject->getEmployee();
        $id = Link::getById(23);
        $link = $id->getHref();
        return $this->render('home/employee.html.twig',[
            'structuredTable'=>$structuredTable,
            'link'=>$link
        ]);
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
        $taskOject = DataObject\Myblock::getById(5);
        $task = $taskOject->getTask();
        /*$salaryObject = DataObject\Consent::getById(9);
        $salary = $salaryObject->getStore();*/
        return $this->render('home/attendence.html.twig',[
            'task'=>$task,

            /*'salary'=> $salary,*/
        ]);
    }

    public function leaveAction()
    {
        $employee = DataObject\Mybrick::getById(8);
        $employeeBrick = $employee->getTestbrick();
/*        if ($employeeBrick === null) {
            throw $this->createNotFoundException('Employee not found');
        }*/
        return $this->render('home/Leave.html.twig',[
            'employeeBrick' => $employeeBrick,
        ]);
    }

    public function aboutAction()
    {
        $link = DataObject\Myblock::getById(5);
        $links = $link->getPimcore();
        $test = TestCollection::getById(7);

        return $this->render('home/About.html.twig',[
            'link'=>$links,
            'test'=>$test,
        ]);
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

    /**
     * @Route("/iframe/summary")
     */
    public function summaryAction(Request $request): Response
    {
        $context = json_decode($request->get("context"), true);
        $objectId = $context["objectId"];

        $language = $context["language"] ?? "default_language";

        $object = Service::getElementFromSession('object', $objectId, '');

        if ($object === null) {
            $object = Service::getElementById('object', $objectId);
        }

        $response = '<h1>Title for language "' . $language . '": ' . $object->getData($language) . "</h1>";

        $response .= '<h2>Context</h2>';
        $response .= array_to_html_attribute_string($context);
        return new Response($response);
    }

    public function lockFieldsAction(Request $request)
    {
        $dataObject = DataObject\Myblock::getById($request->get('Id'));
        $fields = $dataObject->getFieldDefinitions();
        foreach ($fields as $field) {
            $field->setLocked(true);
        }
        $dataObject->save();
    }
}
