<?php

namespace App\Repository;

use App\Entity\Tickets;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Tickets|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tickets|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tickets[]    findAll()
 * @method Tickets[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tickets::class);
    }

    // /**
    //  * @return Tickets[] Returns an array of Tickets objects
    //  */

    public function findByCustomerId($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.customer = :val')
            ->andWhere('t.status != 5')
            ->setParameter('val', $value)
            ->orderBy('t.datetime', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult()
        ;
    }
    public function findAssignedToMe($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.assignee = :val')
            ->setParameter('val', $value)
            ->orderBy('t.datetime', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByAssigneeId($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.assignee = :val')
            ->setParameter('val', $value)
            ->orderBy('t.priority', 'DESC')
            //->addOrderBy('t.datetime', 'DESC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByNull()
    {
        return $this->createQueryBuilder('t')
            ->where('t.assignee IS NULL')
            ->orderBy('t.priority', 'DESC')
            //->addOrderBy('t.datetime', 'DESC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByLine($value)
    {
        return $this->createQueryBuilder('t')
            ->where('t.assignee IS NULL')
            ->andWhere('t.line = :val')
            ->andWhere('t.status != 5')
            ->andWhere('t.status != 4')
            ->setParameter('val', $value)
            ->orderBy('t.priority', 'DESC')
            //->addOrderBy('t.datetime', 'DESC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult()
            ;
    }

   public function findByTicketId($value)
   {
       return $this->createQueryBuilder('t')
           ->andWhere('t.id = :val')
           ->setParameter('val', $value)
           ->getQuery()
           ->getOneOrNullResult()
       ;
   }

    public function findByStatus($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.status = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findClosedWf()
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.status != 5 && t.status != 4')
            ->setParameter('val', $value)
            ->orderBy('t.datetime', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult()
            ;
    }

    /*
    public function findOneBySomeField($value): ?Tickets
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
