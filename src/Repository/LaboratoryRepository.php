<?php

namespace App\Repository;

use App\Entity\Laboratory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Laboratory|null find($id, $lockMode = null, $lockVersion = null)
 * @method Laboratory|null findOneBy(array $criteria, array $orderBy = null)
 * @method Laboratory[]    findAll()
 * @method Laboratory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LaboratoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Laboratory::class);
    }

    /**
     * @param string|null $term
     */
    public function getWithSearchQueryBuilder(?string $term): QueryBuilder
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
        ->select('l','a')
        ->from('App\Entity\Laboratory', 'l')
        ->leftJoin('l.address', 'a')
        ->orderBy('l.id', 'ASC');

        return $qb;

    }
    // /**
    //  * @return Laboratory[] Returns an array of Laboratory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Laboratory
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
