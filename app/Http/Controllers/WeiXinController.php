<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WeiXinController extends Controller
{
    public function api(){
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            return $echoStr;
        }
        return $echoStr;
    }

    private function checkSignature(){
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
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
