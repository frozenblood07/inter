<?php

namespace App\Controller;

use App\Service\GroupService;
use App\Service\UserGroupMappingService;
use App\Service\UserService;
use App\Utility\ResponseUtility;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\AdminService;


class AdminController extends AbstractController
{
    private $userService;
    private $groupService;
    private $userGroupMappingService;
    private $adminService;


    public function __construct(UserService $userService, GroupService $groupService, UserGroupMappingService $userGroupMappingService, AdminService $adminService)
    {
        $this->userService = $userService;
        $this->groupService = $groupService;
        $this->userGroupMappingService = $userGroupMappingService;
        $this->adminService = $adminService;
    }

    /**
     * @param mixed ...$args
     * @return bool
     */
    private function is_JSON(...$args) : bool
    {
        json_decode(...$args);
        return (json_last_error()===JSON_ERROR_NONE);
    }

    /**
     * @param Request $request
     * @return array
     */
    private function checkRequestBodyContent(Request $request) : array
    {
        $content = $request->getContent();

        if(empty($content)){
            return ResponseUtility::failureResponse("Content empty");
        }

        if(!$this->is_JSON($content)){
            return ResponseUtility::failureResponse("Content is not a valid json");
        }

        return ResponseUtility::successResponse();
    }

    /**
     * @param Request $request
     * @return array
     */
    private function getRequestContent(Request $request) : array
    {
        return json_decode($request->getContent(),true);
    }

    /**
     * @param $response
     * @param $errorCode
     * @return int
     */
    private function getStatusCode($response, $errorCode, $successCode=JsonResponse::HTTP_OK) : int
    {
        if(!$response['status']) {
            $statusCode = $errorCode;
        } else {
            $statusCode = $successCode;
        }
        return $statusCode;
    }

    /**
     * @param $response
     * @return array
     */
    private function getResponseContent($response) : array
    {
        if($response['status']) {
            return $response['data'];
        }
        return $response;
    }

    /**
     * @Route("/admin/user/create", name="createUser", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function createUser(Request $request) : JsonResponse
    {
        $respReqCheck = $this->checkRequestBodyContent($request);

        if(!$respReqCheck['status']) {
            $response = $respReqCheck;
        }else {
            $parameters = $this->getRequestContent($request);
            $response = $this->adminService->createUser($parameters);
        }

        return new JsonResponse($response, $this->getStatusCode($response, JsonResponse::HTTP_BAD_REQUEST, JsonResponse::HTTP_CREATED));
    }

    /**
     * @Route("/admin/group/create", name="createGroup", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function createGroup(Request $request) : JsonResponse
    {
        $respReqCheck = $this->checkRequestBodyContent($request);

        if(!$respReqCheck['status']) {
            $response = $respReqCheck;
        }else {
            $parameters = $this->getRequestContent($request);
            $response = $this->groupService->createGroup($parameters);
        }

        return new JsonResponse($response, $this->getStatusCode($response, JsonResponse::HTTP_BAD_REQUEST, JsonResponse::HTTP_CREATED));
    }

    /**
     * @Route("/admin/group/{groupId}", name="deleteGroup", methods={"DELETE"})
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteGroup(Request $request, $groupId) : JsonResponse
    {
        $response = $this->adminService->deleteGroup($groupId);
        return new JsonResponse($response, $this->getStatusCode($response, JsonResponse::HTTP_BAD_REQUEST, JsonResponse::HTTP_ACCEPTED));
    }

    /**
     * @Route("/admin/user/group/map", name="mapUserGroup", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function mapUserGroup(Request $request) : JsonResponse
    {
        $respReqCheck = $this->checkRequestBodyContent($request);

        if(!$respReqCheck['status']) {
            $response = $respReqCheck;
        }else {
            $parameters = $this->getRequestContent($request);
            $response = $this->adminService->mapUserGroup($parameters);
        }

        return new JsonResponse($response, $this->getStatusCode($response, JsonResponse::HTTP_BAD_REQUEST, JsonResponse::HTTP_CREATED));
    }

    /**
     * @Route("/admin/users", name="listUser", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function listUsers(Request $request) : JsonResponse
    {
        $response = $this->adminService->listAllUsers();

        return new JsonResponse($response, $this->getStatusCode($response, JsonResponse::HTTP_INTERNAL_SERVER_ERROR));
    }

    /**
     * @Route("/admin/user/group/map/{mapId}", name="deleteUserGroupMapping", methods={"DELETE"})
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteUserGroupMapping(Request $request,int $mapId) : JsonResponse
    {
        $response = $this->adminService->deleteUserGroupMapping($mapId);
        return new JsonResponse($response, $this->getStatusCode($response, JsonResponse::HTTP_BAD_REQUEST,JsonResponse::HTTP_ACCEPTED));
    }

    /**
     * @Route("/admin/user/{userId}", name="deleteUser", methods={"DELETE"})
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteUser(Request $request, int $userId) : JsonResponse
    {
        $response = $this->adminService->deleteUser($userId);
        return new JsonResponse($response,$this->getStatusCode($response, JsonResponse::HTTP_BAD_REQUEST,JsonResponse::HTTP_ACCEPTED));
    }
}


