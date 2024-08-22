<?php

namespace App\Http\Middleware;

use Closure;

class WhiteListAgent
{
    public $agentlist = ['PostmanRuntime', 'GuzzleHttp'];

    public function handle($request, Closure $next)
    {
        $check = explode('/', $request->userAgent());

        //Check User Agent
        // if (in_array($check[0], $this->agentlist)) {
        //     return $next($request);
        // } else {
        //     return response()->json('Browser Rejected', 403.8);
        // }
        return $next($request);
    }
}