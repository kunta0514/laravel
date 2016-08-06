@extends('templates.reportnav')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div id="pie_tasks_sum" style="width:90%;height:300px;"></div>
        </div>
        <div class="col-md-6">
            <label for="echarts_person_tasks">个人任务完成情况</label>
            <div id="echarts_person_tasks" style="width:90%;height:450px;"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="tb_tasks_workload_sum">本周团队任务完成情况（换饼图或者柱状图横向）:</label>
            <table class="table table-bordered table-hover" id="tb_tasks_workload_sum">
                <thead>
                <tr>
                    <th>开发工作量</th>
                    <th>测试工作量</th>
                    <th>合计</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{$tasks_workload_sum->developer_workload_all}}</td>
                    <td>{{$tasks_workload_sum->tester_workload_all}}</td>
                    <td>{{$tasks_workload_sum->developer_workload_all + $tasks_workload_sum->tester_workload_all}}</td>
                </tr>

                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <label for="tb_tasks_sum">个人任务情况（换饼图或者柱状图横向）:</label>
            <table class="table table-bordered table-hover" id="tb_tasks_sum">
                <thead>
                <tr>
                    <th>成员</th>
                    <th>待处理</th>
                    <th>开发中</th>
                    <th>测试中</th>
                    <th>已完成</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <label for="tb_task_details">本周团队任务完成明细（点击明细连接）:</label>
            <table class="table table-bordered table-hover" id="tb_task_details">
                <thead>
                <tr>
                    <th>任务编号</th>
                    <th>状态</th>
                    <th>任务标题</th>
                    <th>客户</th>
                    <th>PM</th>
                    <th>开发</th>
                    <th>测试</th>
                    <th>完成时间</th>
                    <th style="width: 300px">备注</th>
                </tr>
                </thead>
                <tbody>
                @foreach($task_details as $k=>$task)
                    <tr rel="{{$task->id}}">
                        <td><a href="{{$task->ekp_oid}}" name="view_on_erp"
                               rel="{{$task->task_no}}">{{$task->task_no}}</a></td>
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
                        <td style="width: 500px">{{$task->comment}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
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
                    {value:tasks_sum_data.todo,name:tasks_sum_legend[0]},
                    {value:tasks_sum_data.deving,name:tasks_sum_legend[1]},
                    {value:tasks_sum_data.testing,name:tasks_sum_legend[2]},
                    {value:tasks_sum_data.over,name:tasks_sum_legend[3]},
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
            left: '3%',
            right: '4%',
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
</script>
@stop

