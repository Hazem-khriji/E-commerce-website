<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Product;
use App\Repository\ProductRepository;

final class ProductController extends AbstractController
{
    #[Route('/product/{id}', name: 'app_product')]
    public function index(Product $product): Response
    {
        return $this->render('product/product.html.twig', [
            'controller_name' => 'ProductController',
            'product' => $product,
        ]);
    }
}
