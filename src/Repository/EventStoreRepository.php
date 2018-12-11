<?php

namespace App\Repository;

use App\Entity\EventStore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EventStore|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventStore|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventStore[]    findAll()
 * @method EventStore[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventStoreRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(RegistryInterface $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, EventStore::class);
        $this->em = $em;
    }

    // /**
    //  * @return EventStore[] Returns an array of EventStore objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EventStore
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function save(EventStore $eventStore){
        $this->em->persist($eventStore);
        $this->em->flush();
    }
}
