<?php

namespace App\Http\Controllers\Mywork;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Project;
use App\Workflow;
use DB;
use Monolog\Handler\Curl;

class ProjectController extends Controller
{

    private static $user_cookie = '9da1e58d-cccb-4528-93d5-e93f40951b53={"MySettingID":"00000000-0000-0000-0000-000000000000","DefaultLoadPage":"MyPendingList","PendingShow":true,"PreSubmitShow":true,"MyAllShow":true,"AllShow":true,"DefaultPageSize":10,"DataMode":0,"UserGUID":null,"RealDataMode":0,"CreatedBy":null,"CreatedOn":null,"ModifiedBy":null,"ModifiedOn":null,"VersionNumber":0,"_DataState":0}; Login_User=UserCode=wank&SignTime=2016-01-21 15:59:27&UserSign=j6rLyJuRe2VCavJ0d2AgUsFwqRYmbmXuknAjL/cDzI2yDwFFAxKBOUzS+ht3lTKVC/1hJGbxB+R3AdeoW5y9S/T9GolzeEpIFszkxhBjcnhifUqqa0KT7gZuvrTbjnbH+TBg0h4E/3vJN0x4maACInOVXpHe58m+bsvyjCRW1Dc=';


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //校验用户是否在域中
//        $username = 'wank';
//        $password = 'kunta0514';
//        $client = new \SoapClient('http://ekp.mysoft.net.cn/EKPWebService/AdUserService.asmx?wsdl', ["trace" => 1, "exception" => 0]);
//        $ret = $client->__soapCall('UserLoginForALLDomain', ['UserLoginForALLDomain'=>['sUserName'=>$username,'sPassWord'=>$password]]);
//        print_r($ret);
////        return $ret->UserLoginForALLDomainResult;
        $url = 'http://pd.mysoft.net.cn/AjaxRequirement/GetAllRequirementList.cspx';
        $method = 'GET';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //模拟登录
        curl_setopt($ch, CURLOPT_COOKIE, self::$user_cookie);
        //模拟打开浏览器
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        if ($method === 'POST')
        {
            curl_setopt($ch, CURLOPT_POST, true );
//            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        }
        $result = curl_exec($ch);
        preg_match('#<div class="singleRequirementCard">(.*?)</div>#', $result, $u_out);

//        echo $result;
        $j = json_decode($result);
        $j->html;
//        $j = json_encode($result,JSON_UNESCAPED_UNICODE);



//        $a = json_decode($j);
//
//        $b = ['a'=>1,'b'=>2];
//        $bb = json_encode($b);
//
//        $bbb = json_decode($bb);
//
//        var_dump($a->html);
//        var_dump($result);

//        preg_match('#<a class="name" href="/people/(.*?)">(.*?)</a>#', $result, $u_out);
//        print_r($u_out);
//        echo $result;
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
