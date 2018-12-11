<?php

namespace App\Repository;

use App\Constant\Constant;
use App\Entity\GroupMaster;
use App\Service\UserGroupMappingService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\ConnectionException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GroupMaster|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupMaster|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupMaster[]    findAll()
 * @method GroupMaster[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupMasterRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

//    private $userGroupMappingService;
//
//    public function __construct(RegistryInterface $registry, EntityManagerInterface $em, UserGroupMappingService $userGroupMappingService)
//    {
//        parent::__construct($registry, GroupMaster::class);
//        $this->em = $em;
//        $this->userGroupMappingService = $userGroupMappingService;
//    }

    public function __construct(RegistryInterface $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, GroupMaster::class);
        $this->em = $em;
    }


    // /**
    //  * @return GroupMaster[] Returns an array of GroupMaster objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GroupMaster
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function save(GroupMaster $group){
        $this->em->persist($group);
        $this->em->flush();
    }

    /**
     * @param GroupMaster $group
     * @throws ConnectionException
     * @throws \Exception
     */
    public function createNewGroup(GroupMaster $group)
    {
        $this->em->getConnection()->beginTransaction();
        try {

            $exeGroup = $this->findBy(["name" => $group->getName()]);

            if(count($exeGroup) > 0) {
                throw new \Exception("Group name already exists.");
            }

            $this->save($group);
            $this->em->getConnection()->commit();
        } catch (\Exception $e) {
            $this->em->getConnection()->rollBack();
            throw $e;
        }
    }

    public function deleteGroup(GroupMaster $group)
    {
            $group->setStatus(Constant::INACTIVE_STATUS);
            $this->save($group);
    }
}
