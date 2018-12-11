<?php
/**
 * File: UserGroupMappingService.php
 * User: karan.tuteja26@gmail.com
 * Description:
 */

namespace App\Service;


use App\Entity\UserGroupMapping;
use App\Repository\UserGroupMappingRepository;
use App\Utility\ResponseUtility;
use App\Validator\UserGroupMappingValidator;

class UserGroupMappingService
{
    private $userGroupMappingRepository;
    private $userGroupMappingValidator;

    /**
     * UserGroupMappingService constructor.
     * @param UserGroupMappingRepository $userGroupMappingService
     * @param UserGroupMappingValidator $userGroupMappingValidator
     */
    public function __construct(UserGroupMappingRepository $userGroupMappingService, UserGroupMappingValidator $userGroupMappingValidator)
    {
        $this->userGroupMappingRepository = $userGroupMappingService;
        $this->userGroupMappingValidator = $userGroupMappingValidator;
    }

    public function validateUserMappingGroupParams($parameters)
    {
        return $this->userGroupMappingValidator->validateUserMappingGroupParams($parameters);
    }

    public function mapUserGroup(UserGroupMapping $userGroupMapping) : array
    {
        $this->userGroupMappingRepository->mapUserGroup($userGroupMapping);
        return ResponseUtility::successResponseFromObject($userGroupMapping);
    }

    public function createNewMappingObject($parameters)
    {
        $userGroupMapping = new UserGroupMapping();

        $userGroupMapping->setUId($parameters['userId']);
        $userGroupMapping->setGId($parameters['groupId']);

        return $userGroupMapping;
    }

    public function getGroupMappingDetails($groupId) : array
    {
        return $this->userGroupMappingRepository->findBy(["gId" => $groupId]);
    }

    public function checkMappingExists($userId,$groupId) : bool
    {
        $exeUserGrpData = $this->userGroupMappingRepository->findOneBy(["uId" => $userId,"gId" => $groupId]);
        return is_null($exeUserGrpData);
    }

    public function deleteUserGroupMapping($mapId) : array
    {   
        $this->userGroupMappingRepository->delete($mapId);
        return ResponseUtility::successResponse(array());
    }
}