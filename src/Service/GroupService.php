<?php
/**
 * File: GroupService.php
 * User: karan.tuteja26@gmail.com
 * Description:
 */

namespace App\Service;


use App\Constant\Constant;
use App\Entity\GroupMaster;
use App\Repository\GroupMasterRepository;
use App\Utility\ResponseUtility;
use App\Validator\GroupMasterValidator;
use Hoa\Exception\Group;

class GroupService
{
    private $groupRepository;
    private $groupValidator;

    public function __construct(GroupMasterRepository $groupRepository, GroupMasterValidator $groupValidator)
    {
        $this->groupRepository = $groupRepository;
        $this->groupValidator = $groupValidator;
    }


    public function createGroup($parameters)
    {
        $respValidator = $this->groupValidator->validateCreateGroupParams($parameters);

        if(!$respValidator['status']) {
            return $respValidator;
        }

        $group = $this->createNewGroupObject($parameters);

        try {
            $this->groupRepository->createNewGroup($group);
        } catch (\Exception $e) {
            return ResponseUtility::failureResponse($e->getMessage());
        }

        return ResponseUtility::successResponseFromObject($group);
    }

    private function createNewGroupObject($parameters)
    {
        $group = new GroupMaster();
        $group->setName($parameters['name']);
        $group->setStatus(Constant::ACTIVE_STATUS);

        return $group;
    }

    /**
     * @param $groupId
     * @return GroupMaster|null
     */
    public function getGroupDetails($groupId) : ?GroupMaster
    {
        return $this->groupRepository->findOneBy(["id" => $groupId]);
    }

    /**
     * @param $groupId
     */
    public function deleteGroup(GroupMaster $group)
    {
        $this->groupRepository->deleteGroup($group);
    }


}