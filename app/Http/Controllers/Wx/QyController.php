<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class QyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($msg_signature,$timestamp,$nonce)
    {
        //
        $msg_signature = urldecode($msg_signature);
        $timestamp = urldecode($timestamp);
        $nonce = urldecode($nonce);

        $echostr = I('echostr');
        $echostr = urldecode($echostr);

        if($echostr) {
            //验证签名
            if(QyHelper::isSigValid($msg_signature, $this->token, $timestamp, $nonce, $echostr)) {
                $prpcrypt = new Prpcrypt($this->aeskey);
                //解密
                $content = $prpcrypt->decrypt($echostr, $this->corpid);
                if($prpcrypt->isSuccess()) {
                    Yii::$app->response->format = Response::FORMAT_RAW;
                    \Yii::$app->response->data = $content;
                    return \Yii::$app->response;
                }
                else $prpcrypt->printErr();
            }
            else {
                echo '应用签名校验失败，请检查网站、token、aeskey等配置';
            }
        }
        //读取微信服务器消息
        else {
            $msg_xml = I('xml');
            if(empty($msg_xml)) {
                $msg_xml = file_get_contents("php://input");
            }
            if(empty($msg_xml)) {
                $msg_xml = $GLOBALS["HTTP_RAW_POST_DATA"];
            }

            $msg = QyHelper::decryptMsg($msg_xml, $this->aeskey, $this->corpid);
            //TODO：后续需要完善，消息接收与推送这块的功能
            //这里需要能区分是哪个租户的哪个应用发来的消息
//            Yii::warning('记录交互信息:'.$msg,'wx'.__LINE__);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
