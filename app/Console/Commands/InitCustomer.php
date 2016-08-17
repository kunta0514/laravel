<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Customer_ekp;

class InitCustomer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:init_customer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->init_ekp_customer();
    }

    protected function init_ekp_customer()
    {
        $cookie="Login_User=UserCode=zhuangsd&SignTime=2016-06-21 9:32:36&UserSign=cOK2H25Xz17dWIRVSyxGfcJ4gXYe3izNSFwJ8PqysdsE0DTD6afXeh4ro/A3ShiHzotcZeBdMloOqo23gjAyRJdBdMO+pmqlTYRy/bdD11nUQohD3wNgrG6rcKiJOjGXno2BcJzMaHxhuX9Le7W+uN2ogg8QjQKjos1qoyaWXBU=; ASP.NET_SessionId=qqapqxihnulrvxjiu23twvzv";
        $url = 'http://cm.mysoft.net.cn/Customer/Switch';

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
        $content = curl_exec($ch);

        $html=str_get_html($content);

        $array_arae=Array();
        foreach($html->find('div[class*=panel panel-default]') as $k=>$value)
        {
            if($k==0)continue;
            $area_name=trim($value->children(0)->find('a[role*=button]')[0]->plaintext);
            $arae_code=$value->children(1)->attr['area-code'];
            $area_id=$value->children(1)->attr['area-id'];
            $array_arae[]=array(
                'area_name'=>$area_name,
                'arae_code'=> $arae_code,
                'area_id'=>$area_id
            );


            $customer=$value->children(1)->find('div[class*=customer-item] a');
            foreach($customer as $k=>$value)
            {
                $customer=new Customer_ekp();
                $customer->name=$value->attr['title'];
                $customer->code=$value->attr['code'];
                $customer->area_id=$area_id;
                $customer->save();
                $this->print_log("同步客户： $customer->name ，code：$customer->code 区域：$customer->area_id ");
            }
//            dd($customer[0]->attr);die;
//            $customer_area=new CustomerArea();
//            $customer_area->area_name=$area_name;
//            $customer_area->area_code=$arae_code;
//            $customer_area->area_id=$area_id;

            //$customer_area->save();
        }
        return 'ok';
    }

    protected function print_log($context)
    {
        echo iconv('utf-8','gbk',$context).chr(10);
    }
}
