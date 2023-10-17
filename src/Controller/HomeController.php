<?php

namespace App\Controller;

use App\Model\DataObject\TestClass;
use Exception;
use Pimcore\Bundle\ApplicationLoggerBundle\ApplicationLogger;
use Pimcore\Bundle\ApplicationLoggerBundle\FileObject;
use Pimcore\Model;
use Pimcore\Model\User;
use Pimcore\Controller\FrontendController;
use Pimcore\Model\Asset;
use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\TestCollection;
use Pimcore\Model\DataObject\Service;
use Pimcore\Model\Document\Link;
use Pimcore\SystemSettingsConfig;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends FrontendController
{
    #[Template('home/home.html.twig')]
    public function homeAction(Request $request)
    {
        $object = DataObject\Myblock::getById(5);
        $note = new Model\Element\Note();
        $note->setElement($object);
        $note->setDate(time());
        $note->setType("Note Events Create");
        $note->setTitle("Create Notes and Events Test!");
        $note->setUser(0);
        // you can add as much additional data to notes & events as you want
        $note->addData("myText", "text", "Notes and Events Test!");
        $note->addData("myObject", "object", Model\DataObject::getById(5));
        $note->addData("myDocument", "document", Model\Document::getById(13));
        $note->addData("myAsset", "asset", Model\Asset::getById(16));
        $note->save();

        $user = User::create([
            "parentId" => (0),
            "username" => "efrin",
            "password" => "efrin@123",
            "hasCredentials" => true,
            "active" => true
        ]);
        $object = new DataObject\Member();
        $object->setUser($user->getId());


        if ($request->hasSession()) {
            $session = $request->getSession();

            /** @var AttributeBag $bag */
            $bag = $session->getBag('session_cart');
            $bag->set('foo', 1);
        }

        $tag = new \Pimcore\Model\Element\Tag();
        try {
            $tag->setName('TestTag Created via API')->save();
            \Pimcore\Model\Element\Tag::addTagToElement('object', 9, $tag);
        } catch (Exception $e) {
            return "Given Id is Mismatch";
        }
        return [];
    }


    #[Route('/consent/{employeeFname}/{employeeLname}', 'name=employee_preview')]
    public function previewAction(Request $request)
    {
        $empData = DataObject\Consent::getById(9);
        return $this->render('home/showempdata.html.twig',['empData'=>$empData]);
    }
    public function employeeAction(Request $request)
    {
        $taskOject = DataObject\Myblock::getById(5);
        $structuredTable = $taskOject->getEmployee();
        $id = Link::getById(23);
        $employeeLink = $id->getHref();

        $testObject = new TestClass();
        $testObject->setAttribute('Your custom attribute value');
        $value = $testObject->getAttribute();

        return $this->render('home/employee.html.twig',[
            'structuredTable'=>$structuredTable,
            'link'=>$employeeLink,
            'value'=>$value,
        ]);
    }

    public function footerAction (Request $request)
    {
        return $this->render('home/footer.html.twig');
    }

    public function documentAction (Request $request, SystemSettingsConfig $config): Response
    {
        $config = $config->getSystemSettingsConfig();
        $bar = $config['general']['valid_languages'];
        $asset = Asset::getById(21);
        $vdoAsset = Asset::getById(34);
        $websiteSettings = \Pimcore\Model\WebsiteSetting::getByName('text', null, 'en');
        $currentnumber = $websiteSettings->getData();
        return $this->render('home/document.html.twig',['asset'=>$asset,
            'websiteSettings' => $currentnumber,
            'bar'=>$bar,
            'vdoAsset'=>$vdoAsset]);
    }

    public function attendenceAction()
    {
        $taskOject = DataObject\Myblock::getById(5);
        $task = $taskOject->getTask();
        return $this->render('home/attendence.html.twig',[
            'task'=>$task,
        ]);
    }

    public function leaveAction(ApplicationLogger $logger)
    {
        $fileObject = new FileObject('some interesting data');
        $myObject   = DataObject::getById(17);

        $logger->error('my error message', [
            'fileObject'    => $fileObject,
            'relatedObject' => $myObject,
            'component'     => 'different component',
            'source'        => 'Stack trace or context-relevant information' ]);

        $employee = DataObject\Mybrick::getById(8);
        $employeeBrick = $employee->getTestbrick();
        return $this->render('home/Leave.html.twig',[
            'employeeBrick' => $employeeBrick,
        ]);
    }

    public function aboutAction()
    {
        $link = DataObject\Myblock::getById(5);
        $frData = $link->getAbout('fr');
        $links = $link->getPimcore();
        $test = TestCollection::getById(7);

        return $this->render('home/About.html.twig',[
            'link'=>$links,
            'frData'=>$frData,
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

    #[Route('/get-previous-version/{objectId}', name: 'get_previous_version')]
    public function getPreviousVersionAction(Request $request): Response
    {
        $currentObject = DataObject\Myblock::getById(5);
        if (!$currentObject) {
            return new JsonResponse(['message' => 'Given Object is not Found!'], 404);
        }

        $version = $currentObject->getVersions();
        if (count($version) < 2) {
            return new JsonResponse(['message' => 'No previous Version Available!'], 404);
        }

        $previousversion = $version[count($version) - 2];
        $previousObject = $previousversion->getData();

        return $this->render('version/previous_version.html.twig', [
            'previousObject' => $previousObject,
        ]);
    }
}
