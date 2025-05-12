<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ShopController extends AbstractController
{
    #[Route('/shop', name: 'app_shop'),IsGranted("ROLE_USER")]
    public function index(Request $request,ProductRepository $productRepository): Response
    {
        $searchTerm = $request->query->get('query');

        if ($searchTerm) {
            $products = $productRepository->findBySearchQuery($searchTerm);
        } else {
            $products = $productRepository->findAll();
        }



        return $this->render('shop/shop.html.twig', [
            'controller_name' => 'ShopController',
            'products' => $products,
        ]);
    }
}
