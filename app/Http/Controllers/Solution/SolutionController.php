<?php

namespace App\Http\Controllers\Solution;

use App\Utility\PickHtml;
use Illuminate\Http\Request;
use App\WF_Solution;
use App\CheckPersonalize;
use App\Models\Version;
use Cache;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use EndaEditor;
use Illuminate\Support\Facades\Input;
use Log;


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
       return (new CheckPersonalize)->check_customized($customer_name);
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

        $content = PickHtml::get_html_content($url,$params,$user_cookie);

        $html = PickHtml::str_get_html($content);

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
      //TODO:只需要取workflow_version erp_version；缓存
        if (!Cache::has('workflow_version')) {
            Cache::forever('workflow_version',Version::where([])->orderBy('workflow_version')->get()->lists('workflow_version','erp_version')->toArray());
        }
      $pageData['version_contrast']=Cache::get('workflow_version');
      return view('solution.freqQuestion',['pageData'=>$pageData]);
    }


}
