<?php

namespace App\Http\Middleware;

use App\Http\Models\ADM\StudentAdmission\Whitelist_Ip_Dns;
use Closure;

use Illuminate\Support\Facades\App;

class WhiteListIPClient
{
    public function handle($request, Closure $next)
    {
        //get ip client from database framework
        $dataIp = Whitelist_Ip_Dns::all();

        //tmp ip whitelist from database
        $whitelist = ['127.0.0.1', '::1','https://be-trisakti.amisbudi.cloud','202.46.68.61'];

        foreach ($dataIp as $key => $value) {
            array_push($whitelist, $value['ip_address']);
        }

        $requestIP = $request->ip();

        if (in_array($requestIP, $whitelist)) {
            return $next($request);
        } else {
            return response()->json('IP Address Rejected/Blocked ' . $requestIP, 403.6);
        }
    }
}