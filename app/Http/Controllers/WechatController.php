<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use EasyWeChat\Support\Log;
use Illuminate\Http\Request;

class WechatController extends Controller
{
    public function returnToken(){
        $token = 'adsionlilovefxq';
        return $token;
    }

    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $wechat = app('wechat');
        $wechat->server->setMessageHandler(function($message){
            return "欢迎关注 adsionli的测试账号！";
        });

        Log::info('return response.');

        return $wechat->server->serve();
    }


    public function reply($options){
        $app = new Application($options);
        $reply = $app->reply;
        $reply->current();
    }
}
