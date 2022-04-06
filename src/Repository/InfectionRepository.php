<?php

namespace App\Repository;

use App\Entity\Infection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Infection|null find($id, $lockMode = null, $lockVersion = null)
 * @method Infection|null findOneBy(array $criteria, array $orderBy = null)
 * @method Infection[]    findAll()
 * @method Infection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Infection::class);
    }

    /**
     * @param string|null $term
     */
    public function getWithSearchQueryBuilder(?string $term): QueryBuilder
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
        ->select('i','c','d','it','rt')
        ->from('App\Entity\Infection', 'i')
        ->leftJoin('i.client', 'c')
        ->leftJoin('i.disease', 'd')
        ->leftJoin('i.infectiontest', 'it')
        ->leftJoin('i.recoveredtest', 'rt')
        ->orderBy('i.id', 'ASC');

        return $qb;

    }

    // /**
    //  * @return Infection[] Returns an array of Infection objects
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
    public function findOneBySomeField($value): ?Infection
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
