<?php

namespace App\Service;

use App\Repository\ProductRepository;

use Symfony\Component\HttpFoundation\InputBag;

class RequestHandlerService
{
    public function __construct(private ProductRepository $productRepository){}

    public function handleRequest( InputBag $query,int $page,int $nbre): array
    {
        $search = $query->get('search');
        $category = $query->get('category');
        $minPrice = $query->get('min_price');
        $maxPrice = $query->get('max_price');

        $filters=[
            'search' => $search,
            'category' => $category,
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
        ];

        $resultat = $this->productRepository->filterProducts($search, $category, $minPrice, $maxPrice,$nbre,($page - 1) * $nbre);
        $products = $resultat["products"];
        $total = $resultat["total"];
        $nbPage=ceil($total/$nbre);
        return ["products"=>$products,"nbPages"=>$nbPage,"filters"=>$filters];
    }
}