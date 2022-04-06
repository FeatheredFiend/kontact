<?php

namespace App\Repository;

use App\Entity\DiseaseSymptom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method DiseaseSymptom|null find($id, $lockMode = null, $lockVersion = null)
 * @method DiseaseSymptom|null findOneBy(array $criteria, array $orderBy = null)
 * @method DiseaseSymptom[]    findAll()
 * @method DiseaseSymptom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiseaseSymptomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DiseaseSymptom::class);
    }

    /**
     * @param string|null $term
     */
    public function getWithSearchQueryBuilder(?string $term): QueryBuilder
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
        ->select('ds','d','s')
        ->from('App\Entity\DiseaseSymptom', 'ds')
        ->leftJoin('ds.disease', 'd')
        ->leftJoin('ds.symptom', 's')
        ->orderBy('ds.id', 'ASC');

        return $qb;

    }

    // /**
    //  * @return DiseaseSymptom[] Returns an array of DiseaseSymptom objects
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
    public function findOneBySomeField($value): ?DiseaseSymptom
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
