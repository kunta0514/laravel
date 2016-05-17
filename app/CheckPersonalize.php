<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Utility\PickHtml;
use Illuminate\Support\Facades\Config;
use Log;
use App\Project2Workflow;

/**
 * 客户个性化检测
 * Class CheckPersonalize
 * @package App
 */
class CheckPersonalize extends Model
{
    //
    protected $table = 'check_personalize';


    public function check_customized($customer_name)
    {
        if ($customer_name == "") return null;
        $result=Array(
            'id'=>'',
            'result'=>0,//false
            'customer_name'=>$customer_name,
            'alias'=>$customer_name,
            'version'=>'',
            'version_list'=>Array(),
            'task_list'=>Array(),
            'message'=>'有历史个性化，需要重新制作更新包！',
            'code_lib'=>Array()
        );
        $task_list=self::get_task_history($customer_name);

        //TODO 智能判断
        $return_array=array();
        foreach(Config::get('params.customized_key') as $key=>$value)
        {
            foreach($task_list as $item=>$item_value)
            {
                if(strpos($item_value,$value) && !strpos($item_value,'升级微助手') && !strpos($item_value,'典型功能包') && !strpos($item_value,'移动审批'))
                {
                    $return_array[]=$item_value;
                }
            }
        }
        $result['task_list']=$return_array;

        $result['code_lib']=self::get_code_lib($customer_name);

        if(count($result['task_list'])== 0 && count($result['code_lib'])== 0)
        {
            $result['result'] = 1;
            $result['message']='';
        }
        if(count($result['task_list'])> 0 && count($result['code_lib'])== 0)
        {
            $result['result'] = 2;
            $result['message']='有相关任务，无代码库，需要工作流团队确认！';
        }


        $result['version_list']= self::get_configEn($customer_name);

        $checkModel=new CheckPersonalize();
        $checkModel->customer_name=$result['customer_name'];
        $checkModel->alias=$result['alias'];
        $checkModel->version=serialize($result['version_list']);
        $checkModel->history_tasks=serialize($result['task_list']);
        $checkModel->save();

        return json_encode($result,JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param $key
     * @return array
     */
    private function  get_task_history($key)
    {
        $url = 'http://pd.mysoft.net.cn/AjaxRequirement/GetAllRequirementList.cspx?KeyValue=&ManagerName=&PMName=&TeamMembers=&Status=&Source=&XqType=&CustomerType=&CustomerArea=&HandlerToRequirementType=&CreatedOnType=&RecordDateBegin=&RecordDateEnd=&DevelopEndTimeType=&FinishiDateBegin=&FinishiDateEnd=&TechReLmtType=&RechDateBegin=&RechDateEnd=&TaskDoneLmtType=&DcDateBegin=&DcDateEnd=&IsHaveTestDoc=&OrderSeq=&PageSize=100';
        $cur_page = 1;
        $params = "&Customerchn=$key&PageIndex=$cur_page";

        $content = json_decode( PickHtml::get_html_content($url,$params,''));

        $html = PickHtml::str_get_html($content->html);

        $task_array = array();
        if(count($html->find('div[class*=nodata]')) == 0) {
            foreach ($html->find('div[class*=singleRequirementCard]') as $task_node) {
                $task_title = $task_node->find('div[class*=title]', 0)->children(1)->plaintext;
                $task_array[] = $task_title;
            }
        }
        return $task_array;
    }


    /**
     * @param $key
     * @return array
     */
    private  function  get_configEn($key)
    {
        $url='http://pd.mysoft.net.cn/AjaxConfigLibList/GetConfigEnvironment.cspx?PageIndex=1&state=true';
        $params='&KeyValue='.$key;

        $content =  PickHtml::get_html_content($url,$params,'');

        $html =PickHtml:: str_get_html($content);

        $version_array = array();

        if(count($html->find('div[class*=nodata]')) == 0) {
            foreach ($html->find('table[class*=tb] tr') as $key => $value) {
                if ($key == 0) continue;
                $version_array[] = '['.$value->children(1)->plaintext.']'.$value->children(2)->plaintext.'('.$value->children(3)->plaintext.')';
            }
        }

        return $version_array;
    }

    public function get_code_lib($customer_name)
    {
        //TODO:加入别名查询
        return Project2Workflow::where('project_name','like','%'.$customer_name.'%')->get()->toArray();
    }


}
