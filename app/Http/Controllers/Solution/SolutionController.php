<?php

namespace App\Http\Controllers\Solution;

use Illuminate\Http\Request;
use App\WF_Solution;
use App\CheckPersonalize;
use App\Version;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use EndaEditor;
use Illuminate\Support\Facades\Input;
use Log;

include 'simple_html_dom.php';
class SolutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $solutions=WF_Solution::paginate(12);
        return view("solution.index",['theme' => 'default','solutions' => $solutions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("solution.create",['theme' => 'default']);
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
        $solution=WF_Solution::find($id);
        return view('solution.show',['theme' => 'default','solution'=>$solution]);
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


    /**
     * @param Request $request
     * @param string $func
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function mobile_tools(Request $request,$func='view')
    {
        switch($func)
        {
            case 'check':
                return self::is_customized($request->input('customer_name'));
                break;
            case 'search':
                return self::get_task_history($request->input('KeyValue'));
                break;
            default:
                $solution_list=WF_Solution::where('solution_classify','=','mobile')->paginate(12);
//                $solution_list=WF_Solution::paginate(12);
//                dd(json_encode($solution_list->toArray(),JSON_UNESCAPED_UNICODE));die;
                return view('solution.mobile',['theme' => 'default','solution_list'=>$solution_list]);
            break;
        }

    }

    /**
     * @param $customer_name
     * @return string
     */
    private function is_customized($customer_name)
    {
        $start_time=time();
        $result=Array(
            'id'=>'',
            'result'=>false,//false
            'customer_name'=>$customer_name,
            'alias'=>$customer_name,
            'version'=>'',
            'version_list'=>Array(),
            'task_list'=>Array(),
            'message'=>''
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
        if($result['task_list'] && count($result['task_list'])>0)
        {
            $result['result']=false;
            $result['message']='有历史个性化，需要重新制作更新包！';
        }else{
            $result['result'] = true;
            $result['message']='';
        }

        $result['version_list']= self::get_configEn($customer_name);

        $checkModel=new CheckPersonalize();
        //$result['alias']=$checkModel->id;
        $checkModel->customer_name=$result['customer_name'];
        $checkModel->alias=$result['alias'];
        $checkModel->version=serialize($result['version_list']);
        $checkModel->history_tasks=serialize($result['task_list']);
        $checkModel->save();

        $end_time=time();
        Log::info('个性化检测', ['CustomerName' => $customer_name,'Time'=>$end_time-$start_time,'Result'=>$result['result']]);
        return json_encode($result,JSON_UNESCAPED_UNICODE);
    }


    /**
     * @param $key
     * @return array
     */
    private function  get_task_history($key)
    {
        $user_cookie = '9da1e58d-cccb-4528-93d5-e93f40951b53={"MySettingID":"00000000-0000-0000-0000-000000000000","DefaultLoadPage":"MyPendingList","PendingShow":true,"PreSubmitShow":true,"MyAllShow":true,"AllShow":true,"DefaultPageSize":10,"DataMode":0,"UserGUID":null,"RealDataMode":0,"CreatedBy":null,"CreatedOn":null,"ModifiedBy":null,"ModifiedOn":null,"VersionNumber":0,"_DataState":0}; Login_User=UserCode=wank&SignTime=2016-01-21 15:59:27&UserSign=j6rLyJuRe2VCavJ0d2AgUsFwqRYmbmXuknAjL/cDzI2yDwFFAxKBOUzS+ht3lTKVC/1hJGbxB+R3AdeoW5y9S/T9GolzeEpIFszkxhBjcnhifUqqa0KT7gZuvrTbjnbH+TBg0h4E/3vJN0x4maACInOVXpHe58m+bsvyjCRW1Dc=';
        $url = 'http://pd.mysoft.net.cn/AjaxRequirement/GetAllRequirementList.cspx?KeyValue=&ManagerName=&PMName=&TeamMembers=&Status=&Source=&XqType=&CustomerType=&CustomerArea=&HandlerToRequirementType=&CreatedOnType=&RecordDateBegin=&RecordDateEnd=&DevelopEndTimeType=&FinishiDateBegin=&FinishiDateEnd=&TechReLmtType=&RechDateBegin=&RechDateEnd=&TaskDoneLmtType=&DcDateBegin=&DcDateEnd=&IsHaveTestDoc=&OrderSeq=&PageSize=100';
        $cur_page = 1;
        $params = "&Customerchn=$key&PageIndex=$cur_page";

        $content = json_decode( self::get_html_content($url,$params,$user_cookie));

        $html = str_get_html($content->html);

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
        $user_cookie = '9da1e58d-cccb-4528-93d5-e93f40951b53={"MySettingID":"00000000-0000-0000-0000-000000000000","DefaultLoadPage":"MyPendingList","PendingShow":true,"PreSubmitShow":true,"MyAllShow":true,"AllShow":true,"DefaultPageSize":10,"DataMode":0,"UserGUID":null,"RealDataMode":0,"CreatedBy":null,"CreatedOn":null,"ModifiedBy":null,"ModifiedOn":null,"VersionNumber":0,"_DataState":0}; Login_User=UserCode=wank&SignTime=2016-01-21 15:59:27&UserSign=j6rLyJuRe2VCavJ0d2AgUsFwqRYmbmXuknAjL/cDzI2yDwFFAxKBOUzS+ht3lTKVC/1hJGbxB+R3AdeoW5y9S/T9GolzeEpIFszkxhBjcnhifUqqa0KT7gZuvrTbjnbH+TBg0h4E/3vJN0x4maACInOVXpHe58m+bsvyjCRW1Dc=';
        $params='&KeyValue='.$key;

        $content =  self::get_html_content($url,$params,$user_cookie);

        $html = str_get_html($content);

        $version_array = array();

        if(count($html->find('div[class*=nodata]')) == 0) {
            foreach ($html->find('table[class*=tb] tr') as $key => $value) {
                if ($key == 0) continue;
                $version_array[] = '['.$value->children(1)->plaintext.']'.$value->children(2)->plaintext.'('.$value->children(3)->plaintext.')';
            }
        }

        return $version_array;
    }

    /**
     * @param $url
     * @param $params
     * @param $cookie
     * @return mixed
     */
    public function get_html_content($url,$params,$cookie)
    {
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


    public function  markdown($id='')
    {
        $solution=WF_Solution::find($id);
        return view('solution.markDown',['solution'=>$solution]);
    }

    public function upload()
    {
        $data = EndaEditor::uploadImgFile('uploads/images');
        return json_encode($data);
    }

    public function markdown_save(Request $request)
    {
        $solution=WF_Solution::find($request->input('id'));
        $solution=($solution==null)? new WF_Solution :$solution;
        $solution->solution_title=$request->input('title');
        $solution->solution_content=$request->input('content');
        $solution->solution_classify=$request->input('solution_classify');
        if($solution->save())
        {
            return redirect('solution/mobile')->with("保存成功");
        }else
        {
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }

    /**
     * @param $task_no
     * @return array
     */
    public function view_pd($task_no)
    {
        $url='http://pd.mysoft.net.cn/AjaxRequirement/GetAllRequirementList.cspx?Customerchn=&ManagerName=&PMName=&TeamMembers=&Status=&Source=&XqType=&CustomerType=&CustomerArea=&HandlerToRequirementType=&CreatedOnType=&RecordDateBegin=&RecordDateEnd=&DevelopEndTimeType=&FinishiDateBegin=&FinishiDateEnd=&TechReLmtType=&RechDateBegin=&RechDateEnd=&TaskDoneLmtType=&DcDateBegin=&DcDateEnd=&IsHaveTestDoc=&OrderSeq=&PageSize=100';
        $user_cookie = '9da1e58d-cccb-4528-93d5-e93f40951b53={"MySettingID":"00000000-0000-0000-0000-000000000000","DefaultLoadPage":"MyPendingList","PendingShow":true,"PreSubmitShow":true,"MyAllShow":true,"AllShow":true,"DefaultPageSize":10,"DataMode":0,"UserGUID":null,"RealDataMode":0,"CreatedBy":null,"CreatedOn":null,"ModifiedBy":null,"ModifiedOn":null,"VersionNumber":0,"_DataState":0}; Login_User=UserCode=wank&SignTime=2016-01-21 15:59:27&UserSign=j6rLyJuRe2VCavJ0d2AgUsFwqRYmbmXuknAjL/cDzI2yDwFFAxKBOUzS+ht3lTKVC/1hJGbxB+R3AdeoW5y9S/T9GolzeEpIFszkxhBjcnhifUqqa0KT7gZuvrTbjnbH+TBg0h4E/3vJN0x4maACInOVXpHe58m+bsvyjCRW1Dc=';
        $params='&KeyValue='.$task_no;

//        echo $url.$params;

        $content =  self::get_html_content($url,$params,$user_cookie);

        $html = str_get_html($content);

        $version_array = array();

        if(count($html->find('div[class*=nodata]')) == 0) {
            foreach ($html->find('div[class*=title]') as $key => $value) {
                $version_array[] = $value->children(1);
            }
        }

        return $version_array;
    }

    public function mobile_check_fd()
    {

    }

    public function workflow_faq()
    {
      $pageData= array('version_contrast' =>array());

      //dd(Version::where([])->orderBy('erp_version')->get());die;
      //TODO:只需要取workflow_version erp_version；缓存
      $pageData['version_contrast']=Version::where([])->orderBy('workflow_version')->get()->toArray();

      return view('solution.freqQuestion',['pageData'=>$pageData]);
    }


}
