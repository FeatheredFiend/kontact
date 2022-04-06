<?php

namespace App\Repository;

use App\Entity\TestHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method TestHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method TestHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method TestHistory[]    findAll()
 * @method TestHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestHistory::class);
    }

    /**
     * @param string|null $term
     */
    public function getWithSearchQueryBuilder(?string $term): QueryBuilder
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
        ->select('th','tc','c','tl','l')
        ->from('App\Entity\TestHistory', 'th')
        ->leftJoin('th.testcategory', 'tc')
        ->leftJoin('th.client', 'c')
        ->leftJoin('th.testlocation', 'tl')
        ->leftJoin('th.laboratory', 'l')
        ->orderBy('th.id', 'ASC');

        return $qb;

    }

    // /**
    //  * @return TestHistory[] Returns an array of TestHistory objects
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
    public function findOneBySomeField($value): ?TestHistory
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
