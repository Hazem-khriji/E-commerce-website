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
    #[Route('/shop/{page?1}/{nbre?12}', name: 'app_shop'),IsGranted("ROLE_USER")]
    public function index(Request $request, ProductRepository $productRepository,int $page,
                          int $nbre,RequestHandlerService $handlerService): Response
    {
        $result = $handlerService->handleRequest($request->query,$page,$nbre);

        $allCategories = $productRepository->findDistinctCategories();

        return $this->render('shop/shop.html.twig', [
            'products' => $result['products'],
            'categories' => $allCategories,
            'filters' => $result['filters'],
            'page' => $page,
            'nbre' => $nbre,
            'isPaginated'=>true,
            "nbPages" => $result['nbPages'],
        ]);
    }

}
