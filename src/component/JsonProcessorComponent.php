<?php

namespace app\component;

use Symfony\Component\HttpFoundation\Request;

class JsonProcessorComponent
{
    /**
     * Decode and validate JSON data from a request.
     *
     * @param Request $request
     * @return array
     * @throws \InvalidArgumentException
     */
    public static function decode(Request $request): array
    {
        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Invalid JSON payload');
        }

        return $data;
    }
}