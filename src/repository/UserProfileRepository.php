<?php

namespace app\repository;

use app\dto\UserProfileDto;
use app\model\UserProfile;
use Illuminate\Support\Collection;
use app\database\DatabaseConnection;
use PDO;
use DateTime;

class UserProfileRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DatabaseConnection::getConnection();
    }

    public function create(UserProfile $userProfile): ?UserProfile
    {
        $sql = 'INSERT INTO user_profile(first_name, last_name, birth_date, region, city, address, phone_number) 
            VALUES(:first_name, :last_name, :birth_date, :region, :city, :address, :phone_number)';
        try {
            $this->pdo->beginTransaction();
            $statement = $this->pdo->prepare($sql);

            $statement->execute([
                ':first_name' => $userProfile->getFirstName(),
                ':last_name' => $userProfile->getLastName(),
                ':birth_date' => $userProfile->getDateOfBirth()->format('Y-m-d'),
                ':region' => $userProfile->getRegion(),
                ':city' => $userProfile->getCity(),
                ':address' => $userProfile->getAddress(),
                ':phone_number' => $userProfile->getPhoneNumber()
            ]);

            $userProfileId = $this->pdo->lastInsertId();
            $userProfile->setId($userProfileId);

            $this->pdo->commit();

            return $userProfile;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return null;
        }
    }

    public function findByPhoneNumber(string $phoneNumber): bool
    {
        $stmt = $this->pdo->prepare(
            'SELECT 1 FROM user_profile WHERE phone_number = :phone_number LIMIT 1'
        );
        $stmt->execute([':phone_number' => $phoneNumber]);
        return (bool)$stmt->fetchColumn();
    }

    public function findAll(): Collection
    {
        $stmt = $this->pdo
            ->query('SELECT 
                            id, 
                            first_name, 
                            last_name, 
                            birth_date, 
                            region, 
                            city, 
                            address, 
                            phone_number 
                        FROM user_profile');
        $usersProfileData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $usersProfileCollection = collect();
        foreach ($usersProfileData as $userProfileData) {
            try {
                $usersProfileCollection->push(
                    new UserProfileDto(
                        $userProfileData['id'],
                        $userProfileData['first_name'],
                        $userProfileData['last_name'],
                        new DateTime($userProfileData['birth_date']),
                        $userProfileData['region'],
                        $userProfileData['city'],
                        $userProfileData['address'],
                        $userProfileData['phone_number']
                    ));
            } catch (\DateMalformedStringException $e) {
                throw new \InvalidArgumentException('Invalid date string!');
            }
        }
        return $usersProfileCollection;
    }
}
