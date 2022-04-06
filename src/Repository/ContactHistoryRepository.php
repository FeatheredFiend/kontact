<?php

namespace App\Repository;

use App\Entity\ContactHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method ContactHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactHistory[]    findAll()
 * @method ContactHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactHistory::class);
    }

    /**
     * @param string|null $term
     */
    public function getWithSearchQueryBuilder(?string $term): QueryBuilder
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
        ->select('ch','c')
        ->from('App\Entity\ContactHistory', 'ch')
        ->leftJoin('ch.client', 'c')
        ->orderBy('ch.id', 'ASC');

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
        ->from('App\Entity\ContactHistory', 'ch')
        ->leftJoin('ch.client', 'c')
        ->orderBy('ch.id', 'ASC');

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
        ->from('App\Entity\ContactHistory', 'ch')
        ->leftJoin('ch.client', 'c')
        ->orderBy('ch.id', 'ASC');

        return $qb;

    }

    // /**
    //  * @return ContactHistory[] Returns an array of ContactHistory objects
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
    public function findOneBySomeField($value): ?ContactHistory
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
