<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    //    /**
    //     * @return Product[] Returns an array of Product objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

//    public function findBySearch(string $term): array
//    {
//        $term = trim(mb_strtolower($term));
//
//        return $this->createQueryBuilder('p')
//            ->where('LOWER(p.name) LIKE :term OR LOWER(p.description) LIKE :term OR LOWER(p.category) LIKE :term')
//            ->setParameter('term', '%' . $term . '%')
//            ->getQuery()
//            ->getResult();
//    }
    public function filterProducts($search, $category, $minPrice, $maxPrice): array
    {
        $qb = $this->createQueryBuilder('p');

        if ($search) {
            $search = trim(mb_strtolower($search));
            $qb->andWhere('LOWER(p.name) LIKE :search OR LOWER(p.description) LIKE :search OR LOWER(p.category) LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        if ($category) {
            $qb->andWhere('p.category = :category')
                ->setParameter('category', $category);
        }

        if ($minPrice) {
            $qb->andWhere('p.price >= :minPrice')
                ->setParameter('minPrice', $minPrice);
        }

        if ($maxPrice) {
            $qb->andWhere('p.price <= :maxPrice')
                ->setParameter('maxPrice', $maxPrice);
        }

        return $qb->getQuery()->getResult();
    }
    public function findDistinctCategories(): array
    {
        $qb = $this->createQueryBuilder('p')
            ->select('DISTINCT p.category')
            ->orderBy('p.category', 'ASC');

        return array_column($qb->getQuery()->getArrayResult(), 'category');
    }



}
