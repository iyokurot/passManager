<?php

namespace App\Systems;

class Response
{
    /**
     * レスポンスを成型
     * @param array $responseData
     * @return array
     */
    public static function getResponse(array $responseData)
    {
        $response['action'] = $responseData;
        return response()->json($response,200);
    }
}
