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
//    public function index(Request $request,ProductRepository $productRepository): Response
//    {
//        $searchTerm = $request->query->get('search');
//
//        $products = $searchTerm
//            ? $productRepository->findBySearch($searchTerm) // custom method
//            : $productRepository->findAll();
//
//        return $this->render('shop/shop.html.twig', [
//            'products' => $products,
//            'searchTerm' => $searchTerm,
//        ]);
//    }
    public function index(Request $request, ProductRepository $productRepository): Response
    {
        $search = $request->query->get('search');
        $category = $request->query->get('category');
        $minPrice = $request->query->get('min_price');
        $maxPrice = $request->query->get('max_price');

        $products = $productRepository->filterProducts($search, $category, $minPrice, $maxPrice);

        // Extract distinct categories from products for the filter menu
        $allCategories = $productRepository->findDistinctCategories();

        return $this->render('shop/shop.html.twig', [
            'products' => $products,
            'categories' => $allCategories,
            'filters' => [
                'search' => $search,
                'category' => $category,
                'min_price' => $minPrice,
                'max_price' => $maxPrice,
            ],
        ]);
    }
}
