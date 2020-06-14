<?php

namespace App\Repository;

use App\Entity\Dose;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Dose|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dose|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dose[]    findAll()
 * @method Dose[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dose::class);
    }

    // /**
    //  * @return Dose[] Returns an array of Dose objects
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
    public function findOneBySomeField($value): ?Dose
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
