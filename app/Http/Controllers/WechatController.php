<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use Config , Log;

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
                "type" => "view",
                "name" => "商城",
                "key"  => "https://open.weixin.qq.com/connect/oauth2/authorize?
                            appid=wx40bf86f9bf3f1c1e
                            &redirect_uri=http://caesar.preview.jisxu.com/wechat/login
                            &response_type=code&scope=snsapi_userinfo
                            &state=pub#wechat_redirect"
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

     /**
      * 微信登录回调
      */
      public function anyLogin(){
          $app      = new Application(Config::get('wechat'));
          $oauth    = $app->oauth;

          $user     = $oauth->user();

          Log::info(json_encode($user));
      }



}
