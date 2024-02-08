<?php

namespace App\Http\Controllers;

use App\Http\Requests\LogValidationRequest;
use App\Services\TrafficLogService;
use App\Models\Log;

class TrafficLightController extends Controller
{
    private $trafficLogService;

    /**
     * TrafficLightController constructor.
     *
     * @param TrafficLogService $trafficLogService
     */
    public function __construct(TrafficLogService $trafficLogService)
    {
        $this->trafficLogService = $trafficLogService;
    }

    /**
     * Show the traffic lights page.
     */
    public function index()
    {
        return view('traffic.index');
    }

    /**
     * Log the button click and return the updated logs.
     *
     * @param LogValidationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function log(LogValidationRequest $request)
    {
        // Retrieve the 'message' from the request
        $message = $request->input('message');

        // Log the button click using the TrafficLogService
        $message = $this->trafficLogService->saveLogTraffic($message);

        // Get the latest 20 logs from the database
        $logs = Log::latest()->take(20)->get();

        // Return JSON response with message and logs
        if ($message) {
            return response()->json(['message' => $message, 'logs' => $logs]);
        }

        // Return JSON response with errors if message is empty
        return response()->json(['errors' => true, $message], 403);
    }
}
