<?php

namespace App\Repository;

use App\Entity\DataTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method DataTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method DataTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method DataTable[]    findAll()
 * @method DataTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataTable::class);
    }

    /**
     * @param string|null $term
     */
    public function getWithSearchQueryBuilder(?string $term): QueryBuilder
    {
        $qb = $this->createQueryBuilder('a')
        ->orderBy('a.id', 'ASC');

        return $qb;

    }
    
    // /**
    //  * @return DataTable[] Returns an array of DataTable objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DataTable
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
