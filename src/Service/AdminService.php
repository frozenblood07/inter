<?php
/**
 * File: AdminService.php
 * User: karan.tuteja26@gmail.com
 * Description:
 */

namespace App\Service;

use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use App\Utility\ResponseUtility;

class AdminService
{
    private $userService;
    private $groupService;
    private $userGroupMappingService;
    private $em;

    public function __construct(UserService $userService, GroupService $groupService, UserGroupMappingService $userGroupMappingService, EntityManagerInterface $em)
    {
        $this->userService = $userService;
        $this->groupService = $groupService;
        $this->userGroupMappingService = $userGroupMappingService;
        $this->em = $em;
    }
    
    public function listAllUsers() : array
    {
        return $this->userService->listAllUsers();
    }

    public function createUser($parameters) : array
    {
        return $this->userService->createUser($parameters);
    }

    public function createGroup($parameters) : array
    {
        return $this->groupService->createGroup($parameters);
    }

    public function deleteGroup($groupId) : array
    {
        $this->em->getConnection()->beginTransaction();

        try {
            $groupMapping = $this->userGroupMappingService->getGroupMappingDetails($groupId);

            if(count($groupMapping) > 0) {
               throw new \Exception("Cannot delete group. Group is not empty.");
            }

            $group = $this->groupService->getGroupDetails(["id" => $groupId]);

            if(is_null($group)) {
                throw new \Exception("Group doesn't exists.");
            }

            $this->groupService->deleteGroup($group);
            $this->em->getConnection()->commit();
            return ResponseUtility::successResponse(array());
        } catch (\Exception $e) {
            $this->em->getConnection()->rollBack();
            return ResponseUtility::failureResponse($e->getMessage());
        }
    }

    public function mapUserGroup($parameters) : array
    {
        $this->em->getConnection()->beginTransaction();
        try {

            $respValidator = $this->userGroupMappingService->validateUserMappingGroupParams($parameters);
    
            if(!$respValidator['status']) {
                return $respValidator;
            }

            $userGroupMapping = $this->userGroupMappingService->createNewMappingObject($parameters);
            $userData = $this->userService->getUserDetails($userGroupMapping->getUId());

            if(is_null($userData)) {
                throw new \Exception("User not found.");
            }

            $groupData = $this->groupService->getGroupDetails($userGroupMapping->getGId());

            if(is_null($groupData)) {
                throw new \Exception("Group not found.");
            }

            if(!$this->userGroupMappingService->checkMappingExists($userGroupMapping->getUId(),$userGroupMapping->getGId())) {
                throw  new \Exception("User Group Mapping already exists");
            }
            $response = $this->userGroupMappingService->mapUserGroup($userGroupMapping);
            $this->em->getConnection()->commit();
            return $response;
        } catch (\Exception $e) {
            $this->em->getConnection()->rollBack();
            return ResponseUtility::failureResponse($e->getMessage());
        }

    }

    public function deleteUserGroupMapping($mapId) : array
    {   
        return $this->userGroupMappingService->deleteUserGroupMapping($mapId);
    }

    public function deleteUser($userId) : array
    {
        return $this->userService->deleteUser($userId);
    }
}