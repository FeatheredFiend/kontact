<?php

namespace App\Repository;

use App\Entity\Decommissioned;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Decommissioned|null find($id, $lockMode = null, $lockVersion = null)
 * @method Decommissioned|null findOneBy(array $criteria, array $orderBy = null)
 * @method Decommissioned[]    findAll()
 * @method Decommissioned[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DecommissionedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Decommissioned::class);
    }

    /**
     * @param string|null $term
     */
    public function getWithSearchQueryBuilder(?string $term): QueryBuilder
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
        ->select('d','u','dt')
        ->from('App\Entity\Decommissioned', 'd')
        ->leftJoin('d.user', 'u')
        ->leftJoin('d.datatable', 'dt')
        ->orderBy('d.id', 'ASC');

        return $qb;

    }

    // /**
    //  * @return Decommissioned[] Returns an array of Decommissioned objects
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
    public function findOneBySomeField($value): ?Decommissioned
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
