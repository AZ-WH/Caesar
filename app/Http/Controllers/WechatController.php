<?php

namespace App\Http\Controllers;

use Log;
use App\Http\Controllers\Controller;

class WechatController extends Controller
{

    public function __construct(){

    }

    public function anyServe(){

        Log::info('request arrived.');

        $wechat = app('wechat');
        $wechat->server->setMessageHandler(function($message){
            return "欢迎关注 overtrue！";
        });

        Log::info('return response.');

        return $wechat->server->serve();
    }

}
