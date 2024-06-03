<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Session>
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }


    public function findNonInscrits($sessionId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $subQb = $this->getEntityManager()->createQueryBuilder();
        $subQb->select('s.id')
            ->from('App\Entity\Inscrire', 'i')
            ->innerJoin('i.stagiaire', 's')
            ->where('i.session = :sessionId');

        $qb->select('st')
            ->from('App\Entity\Stagiaire', 'st')
            ->where($qb->expr()->notIn('st.id', $subQb->getDQL()))
            ->setParameter('sessionId', $sessionId)
            ->orderBy('st.nom');

        return $qb->getQuery()->getResult();
    }
    //    /**
    //     * @return Session[] Returns an array of Session objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Session
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
