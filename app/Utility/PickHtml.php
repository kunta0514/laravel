<?php
/**
 * Created by PhpStorm.
 * User: zhuangsd
 * Date: 2016/4/22
 * Time: 11:27
 */

namespace app\Utility;

include 'simple_html_dom.php';
class PickHtml
{
    private static $cookie='9da1e58d-cccb-4528-93d5-e93f40951b53={"MySettingID":"00000000-0000-0000-0000-000000000000","DefaultLoadPage":"MyPendingList","PendingShow":true,"PreSubmitShow":true,"MyAllShow":true,"AllShow":true,"DefaultPageSize":10,"DataMode":0,"UserGUID":null,"RealDataMode":0,"CreatedBy":null,"CreatedOn":null,"ModifiedBy":null,"ModifiedOn":null,"VersionNumber":0,"_DataState":0}; Login_User=UserCode=wank&SignTime=2016-01-21 15:59:27&UserSign=j6rLyJuRe2VCavJ0d2AgUsFwqRYmbmXuknAjL/cDzI2yDwFFAxKBOUzS+ht3lTKVC/1hJGbxB+R3AdeoW5y9S/T9GolzeEpIFszkxhBjcnhifUqqa0KT7gZuvrTbjnbH+TBg0h4E/3vJN0x4maACInOVXpHe58m+bsvyjCRW1Dc=';
    /**
     * @param $url
     * @param $params
     * @param $cookie
     * @return mixed
     */
    public static function get_html_content($url,$params,$cookie='')
    {
        if($cookie=='')$cookie=self::$cookie;
        $url = $url . $params;

        $method = 'GET';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //模拟登录
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        //模拟打开浏览器
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
        }
        $result = curl_exec($ch);
        return $result;
    }

    public  static  function  str_get_html($content)
    {
       return str_get_html($content);
    }

}