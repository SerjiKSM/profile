<?php

namespace app\service;

use app\dto\UserProfileDto;
use app\repository\UserProfileRepository;
use Illuminate\Support\Collection;

class UserProfileService
{
    protected UserProfileRepository $userProfileRepository;

    public function __construct(UserProfileRepository $userProfileRepository)
    {
        $this->userProfileRepository = $userProfileRepository;
    }

    public function saveUserProfile(UserProfileDto $userProfileDto): ?UserProfileDto
    {
        $userProfile = $userProfileDto->toUserProfile($userProfileDto);
        $newUserProfile = $this->userProfileRepository->create($userProfile);
        return UserProfileDto::fromUserProfile($newUserProfile);
    }

    public function findUserProfileByPhoneNumber(string $getPhoneNumber): bool
    {
        return $this->userProfileRepository->findByPhoneNumber($getPhoneNumber);
    }

    public function getAllUsersProfile(): Collection
    {
        return $this->userProfileRepository->findAll();
    }
}