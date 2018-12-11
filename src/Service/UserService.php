<?php 
namespace App\Service;

use App\Constant\Constant;
use App\Entity\UserMaster;
use App\Repository\UserMasterRepository;
use App\Utility\ResponseUtility;
use App\Validator\UserMasterValidator;


class UserService
{
    private $userRepository;
    private $userValidator;


    public function __construct(UserMasterRepository $userRepository, UserMasterValidator $userValidator)
    {
        $this->userRepository = $userRepository;
        $this->userValidator = $userValidator;
    }

    /**
     * @param $parameters
     * @return array
     */
    public function createUser($parameters)
    {
        $respValidator = $this->userValidator->validateCreateUserParams($parameters);

        if(!$respValidator['status']) {
            return $respValidator;
        }

        $user = $this->createNewUserObject($parameters);
        $this->userRepository->save($user);

        return ResponseUtility::successResponseFromObject($user);
    }

    /**
     * @param $parameters
     * @return UserMaster
     */
    private function createNewUserObject($parameters) : UserMaster
    {
        $user = new UserMaster();
        $user->setName($parameters['name']);
        $user->setEmail($parameters['email']);
        $user->setStatus(Constant::ACTIVE_STATUS);

        return $user;
    }

    /**
     * @param $userId
     * @return UserMaster|null
     */
    public function getUserDetails($userId) : ?UserMaster
    {
        return $this->userRepository->findOneBy(["id" => $userId]);
    }


    public function listAllUsers() : array
    {
        return ResponseUtility::successResponse($this->userRepository->listAllUsers());
    }

    public function deleteUser($userId) : array
    {
        $this->userRepository->delete($userId);
        return ResponseUtility::successResponse(array());
    }
}