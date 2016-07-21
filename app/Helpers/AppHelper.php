<?php
/**
 * Created by PhpStorm.
 * User: wank
 * Date: 2016/5/5
 * Time: 16:46
 */

namespace App\Helpers;

use Cache;
use DB;

class AppHelper
{
    public static function shout($string)
    {
        return strtoupper($string);
    }

    public static function user_name($user_code)
    {
        $users = Cache::get('user',function(){
            $users = DB::table('users')->select('code', 'name','role','admin')->get();
            Cache::forever('user', $users);
        });
        if(!empty($user_code)) {
            $arr_user_code = explode(',',$user_code);
            $user_name = [];
            if(count($arr_user_code) > 1){
                //循环数组，输出名字
                foreach($arr_user_code as $val) {
                    foreach($users as $user){
                        if($user->code == $val){
                            $user_name[$val] = $user->name;
                        }
                    }
                    if(empty($user_name[$val])){
                        $user_name[$val] = '未知';
                    }
                }
            }
            else{
                foreach($users as $user) {
                    if($user->code == $user_code) {
                        $user_name[$user_code] = $user->name;
                    }
                }
                if(empty($user_name[$user_code])){
                    $user_name[$user_code] = '未知';
                }
            }
            return join(',',$user_name);
        }
    }

    public static function developer()
    {
        $developer = Cache::get('developers',function(){
            $developer = User::where('role', 0)->get();
            Cache::forever('developers', $developer);
        });
        return $developer;
    }

    public static function tester()
    {
        $tester = Cache::get('testers',function(){
            $tester = User::where('role', 1)->get();
            Cache::forever('testers', $tester);
        });
        return $tester;
    }

    //直接使用{!! Config('params.customer_level')[$item->level] !!} 可以替代此功能
    public static function customer_level($key)
    {
        $customer_level = Config('params.customer_level');

        return $customer_level[$key];
    }
}