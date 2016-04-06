<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/29
 * Time: 21:58
 */

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder {

    public function run()
    {
       $userList=[
           [
               'username'=>'庄少东',
               'code'=>'zhuangsd',
               'admin'=>0,
               'email'=>'zhuangsd@mysoft.com.cn',
               'password'=>'',
               'role'=>0
           ],
           [
               'username'=>'随波',
               'code'=>'suib',
               'admin'=>0,
               'email'=>'suib@mysoft.com.cn',
               'password'=>'',
               'role'=>1
           ],
           [
               'username'=>'季家龙',
               'code'=>'jijl',
               'admin'=>0,
               'email'=>'jijl@mysoft.com.cn',
               'password'=>'',
               'role'=>0
           ],
           [
               'username'=>'沈金龙',
               'code'=>'shenjl',
               'admin'=>0,
               'email'=>'shenjl@mysoft.com.cn',
               'password'=>'',
               'role'=>0
           ],
           [
               'username'=>'陈静',
               'code'=>'chenj02',
               'admin'=>0,
               'email'=>'chenj02@mysoft.com.cn',
               'password'=>'',
               'role'=>0
           ],
           [
               'username'=>'万堃',
               'code'=>'wank',
               'admin'=>0,
               'email'=>'wank@mysoft.com.cn',
               'password'=>'',
               'role'=>0
           ],
           [
               'username'=>'郭飞',
               'code'=>'guof02',
               'admin'=>0,
               'email'=>'guof02@mysoft.com.cn',
               'password'=>'',
               'role'=>0
           ],

       ];


        DB::table('users')->truncate();

        foreach($userList as $k=>$val)
        {
            \App\User::create([
                'name' => $val['username'],
                'code' => $val['code'],
                'admin' => $val['admin'],
                'email' => $val['email'],
                'password' => $val['password'],
                'role' => $val['role'],
            ]);
        }
    }

}
