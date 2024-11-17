<?php

namespace app\validation;

use Symfony\Component\HttpFoundation\Request;

class UserProfileValidator
{
    public static function validateJsonDataForCreateUserProfile(Request $request): array
    {
        $errors = [];
        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Invalid JSON payload');
        }

        $fields = [
            'firstName' => [
                'required' => true,
                'maxLength' => 50,
                'pattern' => '/^[a-zA-Zа-яА-ЯёЁіІїЇєЄґҐ\s]+$/u',
                'errorMessages' => [
                    'required' => "First name is required.",
                    'maxLength' => "First name must be 50 characters or less.",
                    'pattern' => "First name must contain only letters.",
                ],
            ],
            'lastName' => [
                'required' => true,
                'maxLength' => 50,
                'pattern' => '/^[a-zA-Zа-яА-ЯёЁіІїЇєЄґҐ\s]+$/u',
                'errorMessages' => [
                    'required' => "Last name is required.",
                    'maxLength' => "Last name must be 50 characters or less.",
                    'pattern' => "Last name must contain only letters.",
                ],
            ],
            'birthDate' => [
                'required' => true,
                'pattern' => '/^\d{4}-\d{2}-\d{2}$/',
                'errorMessages' => [
                    'required' => "Birth date is required.",
                    'pattern' => "Birth date must be in the format YYYY-MM-DD.",
                ],
            ],
            'region' => [
                'required' => false,
                'maxLength' => 100,
                'errorMessages' => [
                    'maxLength' => "Region must be 100 characters or less.",
                ],
            ],
            'city' => [
                'required' => false,
                'maxLength' => 100,
                'errorMessages' => [
                    'maxLength' => "City must be 100 characters or less.",
                ],
            ],
            'address' => [
                'required' => false,
                'maxLength' => 255,
                'errorMessages' => [
                    'maxLength' => "Address must be 255 characters or less.",
                ],
            ],
            'phoneNumber' => [
                'required' => true,
                'maxLength' => 20,
                'pattern' => '/^[\d\+\-\(\)\s]+$/',
                'errorMessages' => [
                    'required' => "Phone number is required.",
                    'maxLength' => "Phone number must be 20 characters or less.",
                    'pattern' => "Phone number must be in a valid format (e.g., +380671234567).",
                ],
            ],
        ];

        foreach ($fields as $field => $rules) {
            $value = $data[$field] ?? null;

            if ($rules['required'] && empty($value)) {
                $errors[] = $rules['errorMessages']['required'];
                continue;
            }

            if (!empty($value)) {
                if (!empty($rules['maxLength']) && strlen($value) > $rules['maxLength']) {
                    $errors[] = $rules['errorMessages']['maxLength'];
                }
                if (!empty($rules['pattern']) && !preg_match($rules['pattern'], $value)) {
                    $errors[] = $rules['errorMessages']['pattern'];
                }
            }
        }

        return $errors;
    }
}