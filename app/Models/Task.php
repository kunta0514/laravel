<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        return $this->attributes['dev_name'] =self::get_userName('dev',$this->developer);
    }

    public function getTesterNameAttribute()
    {
        return $this->attributes['tester_name'] =self::get_userName('test',$this->tester);
    }

    /**
     * 功能：转换code到name
     * Date:2016年5月9日15:00:13
     * @param $type 用户类型
     * @param $user_code 用户编码
     * @return string
     */
    private function get_userName($type,$user_code)
    {
        $user_names='';
        if ($user_code=='') {
            return  $user_names;
        }
        foreach (explode(',',$user_code) as $value) {
            if ($type=='dev') {
                $user_names.=((array_key_exists($value,Cache::get('developers')))?Cache::get('developers')[$value]:$value).',';
            }else {
                $user_names.=((array_key_exists($value,Cache::get('testers')))?Cache::get('testers')[$value]:$value).',';
            }
        }
        return rtrim($user_names, ",");
    }
}
