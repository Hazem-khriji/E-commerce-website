<?php

namespace App\Service;

use App\Repository\ProductRepository;

use Symfony\Component\HttpFoundation\InputBag;

class RequestHandlerService
{
    public function __construct(private CategoryService $categoryService, private ProductRepository $productRepository){}

    public function handleRequest( InputBag $query): array
    {
        $categories=$this->categoryService->getCategories();
        $Query = $query->get('query');
        $category = $query->get('category');
        $minPrice = $query->get('min_price');
        $maxPrice = $query->get('max_price');


        $products = $this->productRepository->findByFilters($Query, $category, (float)$minPrice, (float)$maxPrice);

        return ["Products"=>$products,"Categories"=> $categories,"SelectedCategory"=>$category];
    }
}