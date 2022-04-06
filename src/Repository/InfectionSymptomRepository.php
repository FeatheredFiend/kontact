<?php

namespace App\Repository;

use App\Entity\InfectionSymptom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method InfectionSymptom|null find($id, $lockMode = null, $lockVersion = null)
 * @method InfectionSymptom|null findOneBy(array $criteria, array $orderBy = null)
 * @method InfectionSymptom[]    findAll()
 * @method InfectionSymptom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfectionSymptomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InfectionSymptom::class);
    }

    /**
     * @param string|null $term
     */
    public function getWithSearchQueryBuilder(?string $term): QueryBuilder
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
        ->select('ifs','i','s')
        ->from('App\Entity\InfectionSymptom', 'ifs')
        ->leftJoin('ifs.infection', 'i')
        ->leftJoin('ifs.symptom', 's')
        ->orderBy('ifs.id', 'ASC');

        return $qb;

    }

    // /**
    //  * @return InfectionSymptom[] Returns an array of InfectionSymptom objects
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
    public function findOneBySomeField($value): ?InfectionSymptom
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
