<?php

namespace App\Repository;

use App\Entity\Wine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Wine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wine[]    findAll()
 * @method Wine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wine::class);
    }

    // /**
    //  * @return Wine[] Returns an array of Wine objects
    //  */
    public function readWines()
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.imageFilename IS NOT NULL')
            ->orderBy('w.date_modified', 'ASC')
            ->setMaxResults(6) 
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function readWine($value): ?Wine
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
