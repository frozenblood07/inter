<?php
/**
 * File: GroupMasterValidator.php
 * User: karan.tuteja26@gmail.com
 * Description:
 */

namespace App\Validator;

use App\Constant\Constant;
use App\Utility\ResponseUtility;

class GroupMasterValidator
{
    /**
     * @param $parameters
     * @return array
     */
    public function validateCreateGroupParams($parameters) : array
    {
        if(!array_key_exists(Constant::USERNAME,$parameters)) {
            return ResponseUtility::failureResponse("Group name is missing");
        }

        return ResponseUtility::successResponse();
    }

}