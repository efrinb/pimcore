<?php

namespace ProductBundle\Controller;

//use Pimcore\Controller\FrontendController;
use Pimcore\Model\DataObject\Product;
use ProductBundle\Model\Vote\Listing;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/{productId}")
     */
    public function indexAction(Request $request, $productId): Response
    {
        $product = Product::getById($productId);
        return $this->render('@ProductBundle/product.html.twig', [
            'product' => $product
        ]);
    }

    /**
     * @Route("/vote")
    */
    public function daoAction()
    {
        $vote = new \ProductBundle\Model\Vote();
        $vote->setScore(3);
        $vote->setUsername('efrin!'.mt_rand(1, 999));
        $vote->save();
        return $this->render("@ProductBundle/vote/votes.html.twig",[
            'vote' => $vote
        ]);
    }

    /**
     * @Route("/listingvote")
     */
    public function listAction(): Response
    {
        $list = new Listing();
        $list->setCondition("score > ?", array(1));
        $votesList = $list->load();
        return $this->render('@ProductBundle/vote/listing.html.twig', [
            'voteList' => $votesList
        ]);
    }
}
