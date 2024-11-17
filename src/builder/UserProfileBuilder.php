<?php

namespace app\builder;

use app\model\UserProfile;
use DateTime;

class UserProfileBuilder
{
    private $id;
    private string $firstName;
    private string $lastName;
    private DateTime $dateOfBirth;
    private string $region;
    private string $city;
    private string $address;
    private string $phoneNumber;

    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setFirstName($firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function setLastName($lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function setDateOfBirth(DateTime $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }

    public function setRegion($region): self
    {
        $this->region = $region;
        return $this;
    }

    public function setCity($city): self
    {
        $this->city = $city;
        return $this;
    }

    public function setAddress($address): self
    {
        $this->address = $address;
        return $this;
    }

    public function setPhoneNumber($phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function build(): UserProfile
    {
        $userProfile = new UserProfile();
        $userProfile->setFirstName($this->firstName);
        $userProfile->setLastName($this->lastName);
        $userProfile->setDateOfBirth($this->dateOfBirth);
        $userProfile->setRegion($this->region);
        $userProfile->setCity($this->city);
        $userProfile->setAddress($this->address);
        $userProfile->setPhoneNumber($this->phoneNumber);
        return $userProfile;
    }
}