<?php

namespace App\Repository;

use App\Entity\TicketComments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TicketComments|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketComments|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicketComments[]    findAll()
 * @method TicketComments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketCommentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TicketComments::class);
    }

    public function findAssociatedWithTicket($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.ticket = :val')
            ->setParameter('val', $value)
            ->orderBy('c.datetime', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return TicketComments[] Returns an array of TicketComments objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TicketComments
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
