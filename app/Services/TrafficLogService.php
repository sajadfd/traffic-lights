<?php

namespace App\Services;

use App\Models\Log;

class TrafficLogService
{
    public function saveLogTraffic($message)
    {
        // Save to database
        Log::create(['message' => $message]);
        
        return $message;
    }
}
