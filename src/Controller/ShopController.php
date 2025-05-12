<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\RequestHandlerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ShopController extends AbstractController
{
    #[Route('/shop', name: 'app_shop'),IsGranted("ROLE_USER")]
    public function index(Request $request,ProductRepository $productRepository,RequestHandlerService $handlerService): Response
    {

        $result=$handlerService->handleRequest($request->query,$productRepository);

        return $this->render('shop/shop.html.twig', [
            'products' => $result["Products"],
            'selectedCategory' => $result["SelectedCategory"]  ,
            'categories' => $result["Categories"]
        ]);
    }
}
