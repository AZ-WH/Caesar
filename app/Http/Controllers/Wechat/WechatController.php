<?php

namespace App\Http\Controllers\Wechat;

use EasyWeChat\Foundation\Application;
use App\Http\Controllers\Controller;
use Config , Log;

use App\Models\User;


class WechatController extends Controller
{

    public function __construct(){

    }

    /**
     *
     * 微信验证token
     */
    public function token(){

        $signature      = $_GET['signature'];
        $timestamp      = $_GET['timestamp'];
        $nonce          = $_GET['nonce'];
        $token          = Config::get('wechat.token');
        $tmpArr = array($token , $timestamp , $nonce);
        sort($tmpArr);

        if(sha1(implode($tmpArr)) == $signature){
            echo $_GET['echostr'];exit;
        }else{
            return '失败';
        }
    }

    /**
     * 菜单
     */
     public function setMenu(){

        $wechatApp = new Application(Config::get('wechat'));

        $menu = $wechatApp->menu;

        $buttons = [
            [
                "type" => "view",
                "name" => "商城",
                "url"  => Config::get('app.url').'wechat/login'
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
      public function login(){
          $wechatApp      = new Application(Config::get('wechat'));
          $oauth    = $wechatApp->oauth;
          return $oauth->redirect();
      }

     /**
      * 微信登录成功后的回调
      */
      public function callbackLogin(){
          $wechatApp            = new Application(Config::get('wechat'));

          $oauth                = $wechatApp->oauth;
          $wechatUserInfo       = $oauth->user();

          $wechatUserInfo       = $wechatUserInfo->toArray();


           $userModel = new User;

           $userModel->true_name     = $wechatUserInfo['name'];
           $userModel->avatar        = $wechatUserInfo['avatar'];
           $userModel->wx_openid     = $wechatUserInfo['original']['openid'];
           $userModel->wx_unionid    = $wechatUserInfo['original']['unionid'];
           $userModel->login_type    = "微信公众号";

           if($wechatUserInfo['sex'] == 1){
               $userModel->sex       = '男';
           }else{
               $userModel->sex       = '女';
           }

          var_dump($userModel);die;

          return "登录成功";
      }

}
