<?php

namespace App\Models\Log;

use Illuminate\Support\Facades\Log;

class ErrorLog{
    public static function catchException(\Exception $exception){
        Log::error($exception->getMessage());
        throw $exception;
    }
}
