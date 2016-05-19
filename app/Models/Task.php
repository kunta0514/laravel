<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Task extends Model
{
    protected $table = 'tasks';

    /**
     * 追加到模型数组表单的访问属性
     *
     * @var array
     */
    protected $appends = ['dev_name','tester_name'];

    /**
     * 功能：生成更新包名称
     * Date:2016年5月9日14:58:33
     * @return string
     */
    public function build_package_name()
     {
         return '['.trim($this->task_no).']-'.trim($this->customer_name).'-'.date('Ymd',time()).'-第1次';
     }


    public function getDevNameAttribute()
    {
//        return $this->attributes['dev_name'] =self::get_userName('dev',$this->developer);
        return $this->attributes['dev_name'] = self::get_userName($this->developer);
    }

    public function getTesterNameAttribute()
    {
//        return $this->attributes['tester_name'] =self::get_userName('test',$this->tester);
        return $this->attributes['tester_name'] = self::get_userName($this->tester);
    }

    /**
     * 功能：转换code到name
     * Date:2016年5月9日15:00:13
     * @param $type 用户类型
     * @param $user_code 用户编码
     * @return string
     */
    private function get_userName($user_code)
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
                        $user_name[$val] = '未知(多人)';
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
                    $user_name[$user_code] = '未知(单人)';
                }
            }
            return join(',',$user_name);
        }
    }
}
