<?php

namespace App\Repository;

use App\Entity\InfectedLocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method InfectedLocation|null find($id, $lockMode = null, $lockVersion = null)
 * @method InfectedLocation|null findOneBy(array $criteria, array $orderBy = null)
 * @method InfectedLocation[]    findAll()
 * @method InfectedLocation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfectedLocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InfectedLocation::class);
    }

    /**
     * @param string|null $term
     */
    public function getWithSearchQueryBuilder(?string $term): QueryBuilder
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
        ->select('il','ch','inf')
        ->from('App\Entity\InfectedLocation', 'il')
        ->leftJoin('il.contacthistory', 'ch')
        ->leftJoin('il.infection', 'inf')
        ->where('inf.recoveredtest is NULL')
        ->orderBy('il.id', 'ASC');

        return $qb;

    }


    /**
     * @param string|null $term
     */
    public function getWithSearchQueryBuilderLatitude(?string $term): QueryBuilder
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
        ->select('ch.latitude')
        ->from('App\Entity\InfectedLocation', 'il')
        ->leftJoin('il.contacthistory', 'ch')
        ->leftJoin('ch.client', 'c')
        ->leftJoin('c.address', 'a')
        ->orderBy('il.id', 'ASC');
        
        return $qb;

    }

    /**
     * @param string|null $term
     */
    public function getWithSearchQueryBuilderLongitude(?string $term): QueryBuilder
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
        ->select('ch.longitude')
        ->from('App\Entity\InfectedLocation', 'il')
        ->leftJoin('il.contacthistory', 'ch')
        ->leftJoin('ch.client', 'c')
        ->leftJoin('c.address', 'a')
        ->orderBy('il.id', 'ASC');

        return $qb;

    }

    // /**
    //  * @return InfectedLocation[] Returns an array of InfectedLocation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InfectedLocation
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
