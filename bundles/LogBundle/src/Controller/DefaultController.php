<?php

namespace LogBundle\Controller;

use LogBundle\Model\Activity\LogListing;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
//use Pimcore\Security\User\TokenStorageUserResolver;

class DefaultController extends FrontendController
{

//    protected TokenStorageUserResolver $userResolver;
//    public function __construct(TokenStorageUserResolver $userResolver)
//    {
//        $this->userResolver = $userResolver;
//    }

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

//    /**
//     * @Route("/logdata")
//    */
//    public function logAction(Request $request, LoggerInterface $logger): Response
//    {
//        $logEntry = new Activity();
//        $timestamp = new \DateTime();
//        $time = $timestamp->format('Y-m-d H:i:s');
//        $user = $this->userResolver->getUser();
//        $logEntry->setTimestamp($time);
//        $logEntry->setAction($request->attributes->get('_controller'));
//        $logEntry->setUserId($user ? $user->getId() : -1);
//
//        $logEntry->save();
//
//        if ($logEntry->getId()){
//            $logger->info('Log entry saved with ID:'.$logEntry->getId());
//        }
//        else{
//            $logger->error('Failed to save');
//        }
//
//        var_dump($logEntry);
//        return  new Response('Hello world from log');
//    }
}
