<?php

namespace App\Utility;


class ResponseUtility
{
    /**
     * @param $data
     * @return array
     */
    public static function successResponse($data = array()) : array
    {
        return array('status' => true, 'data' => $data);
    }

    /**
     * @param $message
     * @return array
     */
    public static function failureResponse($message) : array
    {
        return array('status' => false, 'error' => $message);
    }

    /**
     * @param $object
     * @return array
     */
    public static function successResponseFromObject($object) :array
    {
        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        $array = $serializer->toArray($object);

        return self::successResponse($array);
    }


}