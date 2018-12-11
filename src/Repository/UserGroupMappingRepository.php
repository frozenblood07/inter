<?php

namespace App\Repository;

use App\Entity\UserGroupMapping;
use App\Service\GroupService;
use App\Service\UserService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserGroupMapping|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserGroupMapping|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserGroupMapping[]    findAll()
 * @method UserGroupMapping[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserGroupMappingRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    private $userService;

    private $groupService;

    public function __construct(RegistryInterface $registry, EntityManagerInterface $em, UserService $userService, GroupService $groupService)
    {
        parent::__construct($registry, UserGroupMapping::class);
        $this->em = $em;
        $this->userService = $userService;
        $this->groupService = $groupService;
    }

    // /**
    //  * @return UserGroupMapping[] Returns an array of UserGroupMapping objects
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
    public function findOneBySomeField($value): ?UserGroupMapping
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function save(UserGroupMapping $userGroupMapping) {
        $this->em->persist($userGroupMapping);
        $this->em->flush();
    }

    /**
     * @param UserGroupMapping $userGroupMapping
     */
    public function mapUserGroup(UserGroupMapping $userGroupMapping) {
        $this->save($userGroupMapping);
    }

    public function delete($mapId)
    {
        //var_dump($mapId);die();
        $mapping = $this->find($mapId);

        if (!$mapping) {
            return;
        }

        $this->em->remove($mapping);
        $this->em->flush();
    }
}
