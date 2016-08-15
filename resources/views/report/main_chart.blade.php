@extends('templates.reportnav')
@section('content')
    <link href="{{asset('vendor/css/datatables.css')}}" rel="stylesheet">
    <script src="{{asset('vendor/js/datatables.js')}}"></script>
    <script src="{{asset('vendor/js/underscore.js')}}"></script>
    <link href="{{asset('vendor/css/modal.css')}}" rel="stylesheet">
    <script src="{{asset('vendor/js/modal.js')}}"></script>
    <style type="text/css">
        table tr {
            cursor: pointer;
        }
    </style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12" style="text-align: center;margin-bottom: 15px;">
            <div class="btn-group" name="btn_type" role="group" aria-label="Large button group">
                <button type="button" class="btn btn-default" rel="week">本周</button>
                <button type="button" class="btn btn-default" rel="month">本月</button>
                <button type="button" class="btn btn-default">本年度</button>
            </div>
        </div>
        <div class="col-md-5">
            <div id="pie_tasks_sum" style="width:90%;height:300px;"></div>
        </div>
        <div class="col-md-7" style="text-align: center">
            <label for="echarts_person_tasks"><h4 style="margin: 0;margin-top:5px;font-weight: bold;font-family:Microsoft YaHei" >个人任务完成情况</h4></label>
            <div id="echarts_person_tasks" style="width:90%;height:450px;"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <label for="tb_tasks_workload_sum">本周团队任务完成情况（单位:人/天）:</label>
            <table class="table table-bordered table-hover" id="tb_tasks_workload_sum">
                <thead>
                <tr>
                    <th>开发工作量</th>
                    <th>测试工作量</th>
                    <th>合计</th>
                </tr>
                </thead>
            </table>
        </div>
        <div class="col-md-7">
            <label for="tb_tasks_sum">个人任务情况（单位:人/天）:</label>
            <table class="table table-bordered table-hover" id="tb_tasks_sum">
                <thead>
                <tr>
                    <th>成员</th>
                    <th>待处理</th>
                    <th>开发中</th>
                    <th>测试中</th>
                    <th>已完成</th>
                    <th>合计</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <label for="tb_task_details">本周团队任务完成明细（点击明细连接）:</label>
            <table class="table table-bordered table-hover" id="tb_task_details">
                <thead>
                <tr style="cursor:hand">
                    <th>任务编号</th>
                    <th>状态</th>
                    <th>任务标题</th>
                    <th>客户</th>
                    <th>PM</th>
                    <th>开发</th>
                    <th>测试</th>
                    <th>完成时间</th>
                    {{--<th style="width: 300px">备注</th>--}}
                </tr>
                </thead>
                <tbody>
                @foreach($task_details as $k=>$task)
                    <tr rel="{{$task->id}}" rel="{{$task->ekp_oid}}">
                        <td><a href="javascript:;" name="view_on_erp"
                               rel="{{$task->ekp_oid}}">{{$task->task_no}}</a></td>
                        <td>
                            {{ Config('params.task_status')[$task->status] }}
                        </td>
                        <td data-toggle="tooltip" data-placement="top" title="{{$task->task_title}}">
                            @if(stristr($task->ekp_task_type, 'BUG'))
                                <span class="label label-danger">B</span>
                            @elseif(stristr($task->ekp_task_type, '咨询'))
                                <span class="label label-info">咨</span>
                            @elseif(stristr($task->ekp_task_type, '需求'))
                                <span class="label label-success">需</span>
                            @else
                                <span class="label label-primary">{{mb_substr($task->ekp_task_type,0,1)}}</span>
                            @endif
                            {{$task->task_title}}
                        </td>
                        <td><a name="view_on_cus" href="#"
                               rel="{{$task->customer_uuid}}">{{$task->customer_name}}</a></td>
                        <td>{{$task->abu_pm}}</td>
                        <td>{!! AppHelper::user_name($task->developer) !!}({{$task->developer_workload}})</td>
                        <td>{!! AppHelper::user_name($task->tester) !!}({{$task->tester_workload}})</td>
                        <td>
                            @if (date("Y-m-d",strtotime("$task->actual_finish_date")) == '-0001-11-30' || date("Y-m-d",strtotime("$task->actual_finish_date")) == '1900-01-01' || date("Y-m-d",strtotime("$task->actual_finish_date")) == '1970-01-01')
                                <span></span>
                            @else
                                <?= date("Y-m-d", strtotime("$task->actual_finish_date")) ?>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    //TODO:1、调整取数逻辑为异步；2、调整代码逻辑，现在写的太乱了。
    // 基于准备好的dom，初始化echarts实例
    var pie_tasks_sum = echarts.init(document.getElementById('pie_tasks_sum'));
    var tasks_sum_legend = Array('待处理','开发中','测试中','已完成');
    var page_data=<?= $page_data ?>;
    var mode=(page_data.mode =="week")?"本周":"本月";
    var tasks_sum_data=page_data.tasks_sum;
    var pie_tasks_sum_option = {
        title : {
            text: mode+'团队任务处理情况',
            subtext: '共处理：'+ (Number(tasks_sum_data.todo)+Number(tasks_sum_data.over)+Number(tasks_sum_data.deving)+Number(tasks_sum_data.testing)) +'（个）',
            x:'center'
        },
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} 个 ({d}%)"
        },
        legend: {
            orient: 'vertical',
            left: 'left',
            data:tasks_sum_legend
        },
        series : [
            {
                name: '任务数量',
                type: 'pie',
                radius : '55%',
                center: ['50%', '60%'],
                data:[
                    {value:tasks_sum_data.todo,name:tasks_sum_legend[0],rel:"todo"},
                    {value:tasks_sum_data.deving,name:tasks_sum_legend[1],rel:"deving"},
                    {value:tasks_sum_data.testing,name:tasks_sum_legend[2],rel:"testing"},
                    {value:tasks_sum_data.over,name:tasks_sum_legend[3],rel:"over"},
                ],
                itemStyle: {
                    emphasis: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };
    // 使用刚指定的配置项和数据显示图表。
    pie_tasks_sum.setOption(pie_tasks_sum_option);

    pie_tasks_sum.on("click",function(params){
        tb_task_details.search(params.name).draw();
    });

    //个人任务完成情况
    var person_tasks=echarts.init(document.getElementById('echarts_person_tasks'));
    var person_workflod_totle=page_data.person_workload_totle;
    var person_list= $.map(person_workflod_totle,function(item){
        return item.name;
    });
    var person_workfload_todo= $.map(person_workflod_totle,function(item){
        return item.todo;
    });
    var person_workfload_doing= $.map(person_workflod_totle,function(item){
        return item.doing;
    });
    var person_workfload_testing= $.map(person_workflod_totle,function(item){
        return item.testing;
    });
    var person_workfload_dong= $.map(person_workflod_totle,function(item){
        return item.dong;
    });
    person_tasks.title="个人任务情况(数量)";
    var person_tasks_option = {
        tooltip : {
            trigger: 'axis',
            axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
            }
        },
        legend: {
            data: tasks_sum_legend
        },
        grid: {
            left: '1%',
            right: '1%',
            bottom: '3%',
            containLabel: true
        },
        xAxis:  {
            type: 'value'
        },
        yAxis: {
            type: 'category',
            data: person_list
        },
        series: [
            {
                name: '待处理',
                type: 'bar',
                stack: '总量',
                label: {
                    normal: {
                        show: true,
                        position: 'insideRight'
                    }
                },
                data: person_workfload_todo
            },
            {
                name: '开发中',
                type: 'bar',
                stack: '总量',
                label: {
                    normal: {
                        show: true,
                        position: 'insideRight'
                    }
                },
                data: person_workfload_doing
            },
            {
                name: '测试中',
                type: 'bar',
                stack: '总量',
                label: {
                    normal: {
                        show: true,
                        position: 'insideRight'
                    }
                },
                data: person_workfload_testing
            },
            {
                name: '已完成',
                type: 'bar',
                stack: '总量',
                label: {
                    normal: {
                        show: true,
                        position: 'insideRight'
                    }
                },
                data: person_workfload_dong
            }
        ]
    };
    person_tasks.setOption(person_tasks_option);

    person_tasks.on("click",function(params){
        tb_task_details.search(params.name).draw();
    });
    //tb_tasks_sum
    var tb_tasks_sum=$("#tb_tasks_sum").DataTable({
        "data":page_data.person_workload_sum.data,
        "columns": [
            { "data": "NAME" },
            { "data": "todo_workload" },
            { "data": "deving_workload" },
            { "data": "testing_workload" },
            { "data": "dong_workload" },
            { "data": "sum_workload" }
        ],
        paging: false,//分页
        ordering: true,//是否启用排序
        dom: "<'row'<'col-sm-12'tr>>" + "<'row'>",
        order:[5,'desc']
    });
    var tb_task_details=$("#tb_task_details").DataTable({
        paging: false,//分页
        ordering: true,//是否启用排序
        dom: "<'row'<'col-sm-12'tr>>" + "<'row'>"
    });
    //tb_tasks_workload_sum
    var mydata=Array(Array(page_data.person_workload_sum.dev_workloads,page_data.person_workload_sum.test_workloads,page_data.person_workload_sum.total_workloads));
    var tb_tasks_workload_sum=$("#tb_tasks_workload_sum").DataTable({
        "data":mydata,
        paging: false,//分页
        ordering: false,//是否启用排序
        dom: "<'row'<'col-sm-12'tr>>" + "<'row'>"
    });

    //切换筛选条件
    $(document).on("click","div[name='btn_type']",function(e){
        e.cancelBubble=false;
        e.preventDefault();
        if(e.target.tagName!="BUTTON")return false;
        window.location.href="/report/task_report/"+$(e.target).attr("rel");
    });

    //任务列表事件绑定
    $(document).on('click', '#tb_task_details tbody tr', function () {
        var data = $(this);
        $.modal({
            keyboard: true,
            width:598,
            minHeight:518,
            transition:true,
            remote: '/task/edit/' + data.attr("rel"),
            okHide: function () {

            }
        })
    } );

    $('#tb_task_details tbody').on('click',"td a[name='view_on_erp']",function(e){
        e.stopPropagation();
        e.preventDefault();
        if ($(this).attr("rel") != "") {
            window.open("http://pd.mysoft.net.cn" + $(this).attr("rel"));
        }
    });
</script>
@stop

