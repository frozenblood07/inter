<?php
/**
 * File: UserGroupMappingValidator.php
 * User: karan.tuteja26@gmail.com
 * Description:
 */

namespace App\Validator;


use App\Constant\Constant;
use App\Utility\ResponseUtility;

class UserGroupMappingValidator
{
    /**
     * @param $parameters
     * @return array
     */
    public function validateUserMappingGroupParams($parameters) : array
    {
        if(!is_int($parameters['groupId'])) {
            return ResponseUtility::failureResponse("group id should be int");
        }
        if(!is_int($parameters['userId'])) {
            return ResponseUtility::failureResponse("user id should be int");
        }

        return ResponseUtility::successResponse();
    }
}