<?php

namespace App\Repository;

use App\Entity\ClientInfected;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClientInfected|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientInfected|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClientInfected[]    findAll()
 * @method ClientInfected[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientInfectedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClientInfected::class);
    }

    // /**
    //  * @return ClientInfected[] Returns an array of ClientInfected objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ClientInfected
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
