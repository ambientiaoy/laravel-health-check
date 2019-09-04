<?php

namespace Ambientia\HealthCheck\Http\Controllers;

use Ambientia\HealthCheck\Model\Heartbeat;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class HealthCheckController extends Controller
{
    /**
     * Check if the server is ready to receive traffic
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function readiness()
    {
        return response('ok', 200);
    }

    /**
     * Check if the backend service is running without problems
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function livenessBackend()
    {
        return response('ok', 200);
    }

    /**
     * Check if the database service is running without problems
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function livenessDatabase()
    {
        // Check database connection
        try {
            DB::connection()->getPdo();
            return response('ok', 200);
        } catch (\Exception $exception) {
            return response("No database connection", 503);
        }
    }

    /**
     * Check if the schedule service is running without problems
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function livenessSchedule()
    {
        // Check scheduled tasks
        try {
            Heartbeat::where('type', Heartbeat::TYPE_SCHEDULE)
                ->where('updated_at', '>', Date::now()->sub('5 minutes')->toDateTimeString())
                ->firstOrFail();
            return response('ok', 200);
        } catch (\Exception $exception) {
            return response(
                "Heartbeat for scheduled tasks has delayed 5 minutes or more. Please check that scheduled tasks are running.",
                503
            );
        }
    }

    /**
     * Check if the queue service is running without problems
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function livenessQueue()
    {
        // Check queue worker
        try {
            Heartbeat::where('type', Heartbeat::TYPE_JOB)
                ->where('updated_at', '>', Date::now()->sub('5 minutes')->toDateTimeString())
                ->firstOrFail();
            return response('ok', 200);
        } catch (\Exception $exception) {
            return response(
                "Heartbeat for jobs has delayed 5 minutes or more. Please check that queue worker is running.",
                503
            );
        }
    }
}
