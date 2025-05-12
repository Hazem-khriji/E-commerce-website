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


    public function findByFilters(?string $query, ?string $category, ?float $minPrice, ?float $maxPrice): array
    {

        $qb = $this->createQueryBuilder('p');
        $qb->select('p');

        if ($query) {
            $qb->andWhere('p.name LIKE :query')
                ->setParameter('query', '%' . $query . '%');
        }

        if ($category) {
            $qb->andWhere('p.category = :category')
                ->setParameter('category', $category);
        }

        if ($minPrice !== 0.0) {
            $qb->andWhere('p.price >= :minPrice')
                ->setParameter('minPrice', $minPrice);
        }

        if ($maxPrice !== 0.0) {
            $qb->andWhere('p.price <= :maxPrice')
                ->setParameter('maxPrice', $maxPrice);
        }

        return $qb->getQuery()->getResult();
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

    //    public function findOneBySomeField($value): ?Product
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
