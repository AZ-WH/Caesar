<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use Config;

class WechatController extends Controller
{

    public function __construct(){

    }

    /**
     *
     * 微信验证token
     */
    public function anyToken(){

        $signature      = $_GET['signature'];
        $timestamp      = $_GET['timestamp'];
        $nonce          = $_GET['nonce'];
        $token          = Config::get('wechat.token');
        $tmpArr = array($token , $timestamp , $nonce);
        sort($tmpArr);

        if(sha1(implode($tmpArr)) == $signature){
            echo $_GET['echostr'];exit;
        }else{
            return false;
        }
    }

    /**
     * 菜单
     */
     public function anyMenu(){

        $app = new Application(Config::get('wechat'));

        $menu = $app->menu;

        $buttons = [
            [
                "type" => "click",
                "name" => "今日歌曲",
                "key"  => "V1001_TODAY_MUSIC"
            ],
            [
                "name"       => "菜单",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "搜索",
                        "url"  => "http://www.soso.com/"
                    ],
                    [
                        "type" => "view",
                        "name" => "视频",
                        "url"  => "http://v.qq.com/"
                    ],
                    [
                        "type" => "click",
                        "name" => "赞一下我们",
                        "key" => "V1001_GOOD"
                    ],
                ],
            ],
        ];

        $menu->add($buttons);
     }

    


}
