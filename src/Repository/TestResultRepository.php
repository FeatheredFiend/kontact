<?php

namespace App\Repository;

use App\Entity\TestResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method TestResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method TestResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method TestResult[]    findAll()
 * @method TestResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestResult::class);
    }

    /**
     * @param string|null $term
     */
    public function getWithSearchQueryBuilder(?string $term): QueryBuilder
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
        ->select('tr','th','d')
        ->from('App\Entity\TestResult', 'tr')
        ->leftJoin('tr.testhistory', 'th')
        ->leftJoin('tr.disease', 'd')
        ->orderBy('tr.id', 'ASC');

        return $qb;

    }

    // /**
    //  * @return TestResult[] Returns an array of TestResult objects
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
    public function findOneBySomeField($value): ?TestResult
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
