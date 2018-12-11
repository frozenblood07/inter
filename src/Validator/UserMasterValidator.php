<?php

namespace App\Validator;


use App\Constant\Constant;
use App\Utility\ResponseUtility;

class UserMasterValidator
{
    /**
     * @param $parameters
     * @return array
     */
    public function validateCreateUserParams($parameters) : array
    {
        if(!array_key_exists(Constant::USERNAME,$parameters)) {
            return ResponseUtility::failureResponse("Username is missing");
        }

        return ResponseUtility::successResponse();
    }
}