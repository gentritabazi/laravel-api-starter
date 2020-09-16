<?php

namespace Infrastructure\Http\Middlewares;

use Closure;
use DB;
use Illuminate\Http\Request;
use Log;

class Logger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  boolean  $dump
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $dump = false)
    {
        DB::enableQueryLog();

        $startTime = microtime(true);
        $response = $next($request);
        $queries = DB::getQueryLog();
        $countQueries = count($queries);
        $endTime = microtime(true);
        $responseTime = $endTime - $startTime;
        $requestUrl = $request->url();
        $requestMethod = $request->method();
        $logText = "Method: ". $requestMethod. ' - URL: '. $requestUrl. " - Total Queries Executed: $countQueries - Response Time: $responseTime";

        if ($countQueries) {
            if (app()->environment('production')) {
                Log::channel('slack')->info([$logText, $queries]);
            } else {
                ($dump) ? dump([$logText, $queries]) : Log::info([$logText, $queries]);
            }
        }
      
        return $response;
    }
}
