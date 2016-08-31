<?php

namespace App\Http\Controllers\Wechat;

use EasyWeChat\Foundation\Application;
use App\Http\Controllers\Controller;
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
                "url"  => "http://caesar.preview.jisxu.com/wechat/oauth/callback"
            ],
            [
                "name"       => "其他",
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
      * 跳转微信登录
      */
      public function anyLogin(){
          $app      = new Application(Config::get('wechat'));
          $oauth    = $app->oauth;
          return $oauth->redirect();
      }

     /**
      * 微信登录成功后的回调
      */
      public function anyOauthCallback(){
          $app      = new Application(Config::get('wechat'));
          $oauth    = $app->oauth;
          $user     = $oauth->user();
          Log::info($user->toArray());
          return "登录成功";
      }

}
