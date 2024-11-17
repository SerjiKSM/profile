<?php

namespace app\controller;

use Symfony\Component\HttpFoundation\JsonResponse;

abstract class BaseController
{
    protected function json(array $data, int $status = 200): JsonResponse
    {
        return new JsonResponse($data, $status);
    }

    protected function handleError(string $message, int $statusCode): JsonResponse
    {
        return $this->json(['message' => $message], $statusCode);
    }
}
