<?php

namespace app\controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use app\service\UserProfileService;
use app\dto\UserProfileDto;
use app\validation\UserProfileValidator;
use app\component\JsonProcessorComponent;

class UserProfileController extends BaseController
{
    private UserProfileService $userProfileService;

    public function __construct(UserProfileService $userProfileService)
    {
        $this->userProfileService = $userProfileService;
    }

    public function index(): Response
    {
        // Render an HTML view
        ob_start();
        include __DIR__ . '/../../views/file.html';
        $htmlContent = ob_get_clean();
        return new Response($htmlContent);
    }

    public function createUserProfile(Request $request): Response
    {
        try {
            $validationErrors = UserProfileValidator::validateJsonDataForCreateUserProfile($request);
            if (!empty($validationErrors)) {
                return $this->json(["message" => $validationErrors], Response::HTTP_BAD_REQUEST);
            }

            $data = JsonProcessorComponent::decode($request);
            $userProfileDto = UserProfileDto::toUserProfileDtoFromJson($data);
            if ($this->userProfileService->findUserProfileByPhoneNumber($userProfileDto->getPhoneNumber())) {
                return $this->json(
                    ["message" => "Duplicate records found for the provided phone number!"], Response::HTTP_CONFLICT);
            }

            $userProfile = $this->userProfileService->saveUserProfile($userProfileDto);
            return $this->json(["message" => "UserProfile created successfully",
                "userProfile" => UserProfileDto::fromUserProfileDtoToArray($userProfile)],
                Response::HTTP_CREATED
            );
        } catch (\InvalidArgumentException $e) {
            return $this->handleError($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return $this->handleError("Server error", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUsersProfile(): Response
    {
        $usersProfileCollection = $this->userProfileService->getAllUsersProfile();

        if ($usersProfileCollection->isEmpty()) {
            return $this->json(["message" => "UsersProfile not found!"], Response::HTTP_NOT_FOUND);
        }

        $usersProfile = UserProfileDto::fromUserProfileDtoCollectionToArray($usersProfileCollection);

        return $this->json(["usersProfile" => $usersProfile], Response::HTTP_OK);
    }
}