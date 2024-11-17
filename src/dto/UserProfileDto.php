<?php

namespace app\dto;

use DateTime;

use app\model\UserProfile;
use Illuminate\Support\Collection;

class UserProfileDto
{
    private ?int $id;
    private string $firstName;
    private string $lastName;
    private DateTime $dateOfBirth;
    private string $region;
    private string $city;
    private string $address;
    private string $phoneNumber;

    public function __construct(?int   $id, string $firstName, string $lastName, DateTime $dateOfBirth,
                                string $region, string $city, string $address, string $phoneNumber)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->dateOfBirth = $dateOfBirth;
        $this->region = $region;
        $this->city = $city;
        $this->address = $address;
        $this->phoneNumber = $phoneNumber;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getDateOfBirth(): DateTime
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(DateTime $dateOfBirth): void
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    public function getRegion(): string
    {
        return $this->region;
    }

    public function setRegion(string $region): void
    {
        $this->region = $region;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public static function fromUserProfile(UserProfile $userProfile): UserProfileDto
    {
        return new UserProfileDto(
            $userProfile->getId(),
            $userProfile->getFirstName(),
            $userProfile->getLastName(),
            $userProfile->getDateOfBirth(),
            $userProfile->getRegion(),
            $userProfile->getCity(),
            $userProfile->getAddress(),
            $userProfile->getPhoneNumber()
        );
    }

    public function toUserProfile(UserProfileDto $userProfileDto): UserProfile
    {
        return UserProfile::builder()
            ->setId($userProfileDto->getId())
            ->setFirstName($userProfileDto->getFirstName())
            ->setLastName($userProfileDto->getLastName())
            ->setDateOfBirth($userProfileDto->getDateOfBirth())
            ->setRegion($userProfileDto->getRegion())
            ->setCity($userProfileDto->getCity())
            ->setAddress($userProfileDto->getAddress())
            ->setPhoneNumber($userProfileDto->getPhoneNumber())
            ->build();
    }

    /**
     * Map JSON data to a UserProfileDto object.
     *
     * @param array $data
     * @return UserProfileDto
     */
    public static function toUserProfileDtoFromJson(array $data): UserProfileDto
    {
        $firstName = $data['firstName'] ?? null;
        $lastName = $data['lastName'] ?? null;
        $birthDate = $data['birthDate'] ?? null;
        $region = $data['region'] ?? null;
        $city = $data['city'] ?? null;
        $address = $data['address'] ?? null;
        $phoneNumber = $data['phoneNumber'] ?? null;

        return new UserProfileDto(
            null,
            $firstName,
            $lastName,
            new DateTime($birthDate),
            $region,
            $city,
            $address,
            $phoneNumber
        );
    }

    public static function fromUserProfileDtoToArray(UserProfileDto $userProfileDto): array
    {
        return array(
            'firstName' => $userProfileDto->firstName,
            'lastName' => $userProfileDto->lastName,
            'dateOfBirth' => $userProfileDto->dateOfBirth->format('Y-m-d'),
            'region' => $userProfileDto->region,
            'city' => $userProfileDto->city,
            'address' => $userProfileDto->address,
            'phoneNumber' => $userProfileDto->phoneNumber,
        );
    }

    public static function fromUserProfileDtoCollectionToArray(Collection $usersProfileDto): array
    {
        return $usersProfileDto->map(function (UserProfileDto $userProfile) {
            return [
                'id' => $userProfile->getId(),
                'firstName' => $userProfile->getFirstName(),
                'lastName' => $userProfile->getLastName(),
                'dateOfBirth' => $userProfile->getDateOfBirth()->format('Y-m-d'),
                'region' => $userProfile->getRegion(),
                'city' => $userProfile->getCity(),
                'address' => $userProfile->getAddress(),
                'phoneNumber' => $userProfile->getPhoneNumber(),
            ];
        })->toArray();
    }
}