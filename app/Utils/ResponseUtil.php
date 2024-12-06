<?php

namespace App\Utils;

class ResponseUtil
{
    /**
     * @param  mixed  $data
     */
    public static function makeResponse(string $message, $data): array
    {
        return [
            'success' => true,
            'data' => $data,
            'message' => $message,
        ];
    }

    public static function makeError(string $message, array $data = []): array
    {
        $res = [
            'success' => false,
            'message' => $message,
        ];

        if (! empty($data)) {
            $res['data'] = $data;
        }

        return $res;
    }
}
