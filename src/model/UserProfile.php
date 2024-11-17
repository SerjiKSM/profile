<?php

namespace app\model;

use app\builder\UserProfileBuilder;
use DateTime;

class UserProfile
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private ?DateTime $dateOfBirth;
    private string $region;
    private string $city;
    private string $address;
    private string $phoneNumber;

    public function __construct(
        string    $firstName = '',
        string    $lastName = '',
        ?DateTime $dateOfBirth = null,
        string    $region = '',
        string    $city = '',
        string    $address = '',
        string    $phoneNumber = '')
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->dateOfBirth = $dateOfBirth;
        $this->region = $region;
        $this->city = $city;
        $this->address = $address;
        $this->phoneNumber = $phoneNumber;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getDateOfBirth(): DateTime
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(DateTime $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }

    public function getRegion(): string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;
        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;
        return $this;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public static function builder(): UserProfileBuilder
    {
        return new UserProfileBuilder();
    }
}