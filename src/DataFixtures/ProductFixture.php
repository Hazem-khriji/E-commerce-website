<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            "Sofa",
            "Armchair",
            "Coffee Table",
            "Dining Table",
            "Dining Chair",
            "Bookshelf",
            "TV Stand",
            "Bed Frame",
            "Nightstand",
            "Dresser",
            "Wardrobe",
            "Desk",
            "Office Chair",
            "Recliner",
            "Ottoman",
            "Console Table",
            "Bench",
            "Bar Stool",
            "Chest of Drawers",
            "Futon",
            "Loveseat",
            "Chaise Lounge",
            "Cabinet",
            "Side Table",
            "Hutch",
            "Vanity Table",
            "Kitchen Island",
            "Pantry Cabinet",
            "Sectional Sofa",
            "Bunk Bed"
        ];
        $categories = [
            'Sofas & Couches',
            'Recliners',
            'Beds',
            'Wardrobes',
            'Dining Tables',
            'Dining Chairs',
            'Desks',
            'Office Chairs'
        ];
        $descriptions = [
            "A spacious and comfortable sofa perfect for lounging and entertaining guests.",
            "A cozy armchair that adds charm and comfort to any living space.",
            "A sleek coffee table with ample surface space for drinks, books, and décor.",
            "A sturdy dining table ideal for family meals and gatherings.",
            "Elegant dining chairs designed for comfort and style during mealtime.",
            "A tall bookshelf with multiple shelves for storing books and decorative items.",
            "A modern TV stand with storage for electronics, games, and media.",
            "A durable bed frame that provides solid support and a stylish centerpiece for any bedroom.",
            "A compact nightstand with drawers to keep your bedtime essentials close.",
            "A spacious dresser with smooth drawers for organizing clothes and accessories.",
            "A large wardrobe for hanging and storing clothing, shoes, and more.",
            "A minimalist desk perfect for work, study, or creative projects.",
            "An ergonomic office chair that offers great back support for long workdays.",
            "A plush recliner that allows you to sit back and relax with a footrest.",
            "A versatile ottoman that doubles as a seat, footrest, or storage solution.",
            "A slim console table that fits neatly in entryways or behind sofas.",
            "A functional bench suitable for entryways, dining rooms, or at the end of a bed.",
            "A tall bar stool ideal for kitchen counters or high tables.",
            "A stylish chest of drawers for organizing linens, clothes, or daily items.",
            "A foldable futon that converts easily from a sofa to a guest bed.",
            "A compact loveseat that seats two and adds a romantic touch to any room.",
            "A luxurious chaise lounge for reclining in comfort and elegance.",
            "A multi-purpose cabinet that stores anything from dishes to office supplies.",
            "A charming side table that complements sofas and chairs with added surface space.",
            "A spacious hutch with upper shelves and lower cabinets for display and storage.",
            "A glamorous vanity table with a mirror and drawers for beauty essentials.",
            "A functional kitchen island that offers extra prep space and storage.",
            "A tall pantry cabinet for neatly organizing food and kitchen supplies.",
            "A modular sectional sofa that can be rearranged to fit any room layout.",
            "A space-saving bunk bed perfect for children's rooms or guest areas."
        ];
        for ($i = 0; $i < 30; $i++) {
            $product = new Product();
            $product->setName($products[$i]);
            $product->setCategory($categories[$i % count($categories)]);
            $product->setDescription($descriptions[$i]);
            $product->setPrice(rand(50, 200));
            $product->setStock(rand(0, 10));
            $product->setImageUrl("product-" . ($i % 3 + 1) . ".png");
            $manager->persist($product);
        }
        $manager->flush();
    }
    public static function getGroups(): array
    {
        return ['products'];
    }
}