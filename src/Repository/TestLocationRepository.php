<?php

namespace App\Repository;

use App\Entity\TestLocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method TestLocation|null find($id, $lockMode = null, $lockVersion = null)
 * @method TestLocation|null findOneBy(array $criteria, array $orderBy = null)
 * @method TestLocation[]    findAll()
 * @method TestLocation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestLocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestLocation::class);
    }

    /**
     * @param string|null $term
     */
    public function getWithSearchQueryBuilder(?string $term): QueryBuilder
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
        ->select('tl','a')
        ->from('App\Entity\TestLocation', 'tl')
        ->leftJoin('tl.address', 'a')
        ->orderBy('tl.id', 'ASC');

        return $qb;

    }
    // /**
    //  * @return TestLocation[] Returns an array of TestLocation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TestLocation
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
