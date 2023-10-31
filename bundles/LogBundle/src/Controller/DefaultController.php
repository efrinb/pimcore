<?php

namespace LogBundle\Controller;

use LogBundle\Model\Activity\LogListing;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends FrontendController
{
    /**
     * @Route("/log")
     */
    public function indexAction(Request $request): Response
    {
        return new Response('Hello world from log');
    }

    /**
     * @Route("/listinglog")
     */
    public function listAction(Request $request): Response
    {
        $logList = new LogListing();
        $logList->setCondition("id > ?", array(1));
        $totalRecords = count($logList->load());
        $logListArray = [];
        foreach ($logList->load() as $log) {
            $logListArray[] = [
                'id' => $log->getId(),
                'userid' => $log->getUserId(),
                'action' => $log->getAction(),
                'timestamp' => $log->getTimestamp(),
            ];
        }

        $page = $request->query->get('page', 1);
        $pageSize = 50;
        $offset = ($page - 1) * $pageSize;
        $pagedData = array_slice($logListArray, $offset, $pageSize);
        return new JsonResponse([
            'total' => $totalRecords,
            'data' => $pagedData,
        ]);
    }
}
