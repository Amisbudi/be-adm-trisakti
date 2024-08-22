<?php

namespace Package\DR\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

use Package\DR\Models\Urls;

class DRController extends Controller
{
    public function DRLoad()
    {
        $list = Urls::GetPrimaryUrls();

        foreach ($list as $key => $val) 
        {
            if ($val['url_method'] === 'GET') 
            {
                Route::get(''.$val['url_masked_name'].''.$val['url_parameter'].'', ''.$val['controller_namespaces'].'@'.$val['function_name'].'');
            }
            elseif ($val['url_method'] === 'POST') 
            {
                Route::post(''.$val['url_masked_name'].''.$val['url_parameter'].'', ''.$val['controller_namespaces'].'@'.$val['function_name'].'')->name(''.$val['url_name'].'');
            }
            elseif ($val['url_method'] === 'PUT') 
            {
                Route::put(''.$val['url_masked_name'].''.$val['url_parameter'].'', ''.$val['controller_namespaces'].'@'.$val['function_name'].'')->name(''.$val['url_name'].'');
            }
            else 
            {
                Route::delete(''.$val['url_masked_name'].''.$val['url_parameter'].'', ''.$val['controller_namespaces'].'@'.$val['function_name'].'')->name(''.$val['url_name'].'');
            }

        }
    }
}