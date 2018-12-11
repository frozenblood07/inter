<?php

namespace App\Repository;

use App\Entity\UserMaster;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Constant\Constant;

/**
 * @method UserMaster|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserMaster|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserMaster[]    findAll()
 * @method UserMaster[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserMasterRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(RegistryInterface $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, UserMaster::class);
        $this->em = $em;
    }

    // /**
    //  * @return UserMaster[] Returns an array of UserMaster objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserMaster
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function save(UserMaster $user)
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    public function listAllUsers() : ?array
    {
        $sql = "select u.id as userId,u.name as userName,u.email,g.id as groupId,g.name as groupName, ug.id as mapId, u.status as userStatus,g.status as groupStatus "
        ."from UserMaster u left join UserGroupMapping ug on (u.id=ug.uId) left join GroupMaster g on (ug.gId = g.id)";
        
        $stmt = $this->em->getConnection()->prepare($sql);
        
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function delete($userId)
    {
        $user = $this->find($userId);

        if (!$user) {
            return;
        }
        $user->setStatus(Constant::INACTIVE_STATUS);
        $this->em->persist($user);
        $this->em->flush();
    }

}
