<?php

namespace App\Repository;

use App\Entity\Programme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Programme>
 */
class ProgrammeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Programme::class);
    }
    public function findNonProgrammes($sessionId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $subQb = $this->getEntityManager()->createQueryBuilder();
        $subQb->select('IDENTITY(p.module)')
              ->from('App\Entity\Programme', 'p')
              ->where('p.session = :sessionId');

        $qb->select('m')
           ->from('App\Entity\Module', 'm')
           ->where($qb->expr()->notIn('m.id', $subQb->getDQL()))
           ->setParameter('sessionId', $sessionId);

        return $qb->getQuery()->getResult();
    }
    //    /**
    //     * @return Programme[] Returns an array of Programme objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Programme
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
