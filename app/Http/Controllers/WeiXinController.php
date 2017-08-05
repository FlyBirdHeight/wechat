<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class WeiXinController extends Controller
{

//    public function api(){
//        $echoStr = Input::get('echostr');
//        if($this->checkSignature()){
//            echo $echoStr;
//            exit;
//        }
//    }

    public function api()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];//php:input
        //写入日志  在同级目录下建立php_log.txt
        //chmod 777php_log.txt(赋权) chown wwwphp_log.txt(修改主)
        error_log(var_export($postStr,1),3,'php_log.txt');
        //日志图片

        //extract post data
        if (!empty($postStr)){
            /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
               the best way is to check the validity of xml by yourself */
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $time = time();
            $textTpl = "<xml>
                           <ToUserName><![CDATA[%s]]></ToUserName>
                           <FromUserName><![CDATA[%s]]></FromUserName>
                           <CreateTime>%s</CreateTime>
                           <MsgType><![CDATA[%s]]></MsgType>
                           <Content><![CDATA[%s]]></Content>
                           <FuncFlag>0</FuncFlag>
                           </xml>";
            //订阅事件
            if($postObj->Event=="subscribe")
            {
                $msgType = "text";
                $contentStr = "欢迎关注";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }


            //语音识别
            if($postObj->MsgType=="voice"){
                $msgType = "text";
                $contentStr = trim($postObj->Recognition,"。");
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo  $resultStr;
            }

            //自动回复
            if(!empty( $keyword ))
            {
                $msgType = "text";
                $contentStr = "想调戏我，门都没有！";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }else{
                echo "Input something...";
            }

        }else {
            echo "";
            exit;
        }
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
