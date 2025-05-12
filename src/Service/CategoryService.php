<?php

namespace App\Service;

class CategoryService
{

    private array $categories;

    public function __construct(){
        $this->categories =[
            'Living Room' => [
                'Sofas & Couches' => 'Sofas & Couches',
                'Recliners' => 'Recliners'
            ],
            'Bedroom' => [
                'Beds' => 'Beds',
                'Wardrobes' => 'Wardrobes'
            ],
            'Dining Room' => [
                'Dining Tables' => 'Dining Tables',
                'Dining Chairs' => 'Dining Chairs'
            ],
            'Office' => [
                'Desks' => 'Desks',
                'Office Chairs' => 'Office Chairs'
            ]];
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
    }


}