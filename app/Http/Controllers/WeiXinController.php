<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class WeiXinController extends Controller
{
    public function api(){
        $echoStr = Input::get('echostr');
        if($this->checkSignature()){
            return $echoStr;
        }
        return null;
    }

    private function checkSignature(){
        $signature = Input::get('signature');
        $timestamp = Input::get('timestamp');
        $nonce     = Input::get('nonce');
        $token = "adsionlilovefxq";
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if($tmpStr == $signature){
            return true;
        }else{
            return false;
        }
    }
}
