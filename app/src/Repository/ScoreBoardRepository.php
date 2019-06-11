<?php

namespace App\Repository;

use App\Entity\ScoreBoard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ScoreBoard|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScoreBoard|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScoreBoard[]    findAll()
 * @method ScoreBoard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScoreBoardRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ScoreBoard::class);
    }

    // /**
    //  * @return ScoreBoard[] Returns an array of ScoreBoard objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ScoreBoard
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
