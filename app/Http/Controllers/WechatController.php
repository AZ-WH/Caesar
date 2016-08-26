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
                "key"  => "http://caesar.preview.jisxu.com/wechat/login"
            ]
        ];

        $menu->add($buttons);
     }

     /**
      * 微信登录
      */
      public function anyLogin(){
          $app      = new Application(Config::get('wechat'));
          $oauth    = $app->oauth;

          return $oauth->redirect();

      }

     /**
      * 微信登录回调
      */
      public function anyLoginCallback(){
          $app      = new Application(Config::get('wechat'));
          $oauth    = $app->oauth;

          $user     = $oauth->user();

          Log::info(json_encode($user));
      }



}
