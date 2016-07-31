@extends('templates.default')
@section('content')
<div class="container-fluid">
    <div class="row">

        <div class="col-md-6">
            <label for="tb_tasks_sum">本周团队任务情况（换饼图或者柱状图横向）:</label>
            <table class="table table-bordered table-hover" id="tb_tasks_sum">
                <thead>
                <tr>
                    <th>待处理</th>
                    <th>开发中</th>
                    <th>测试中</th>
                    <th>已完成</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{$tasks_sum->todo}}</td>
                    <td>{{$tasks_sum->deving}}</td>
                    <td>{{$tasks_sum->testing}}</td>
                    <td>{{$tasks_sum->over}}</td>
                </tr>
                </tbody>
            </table>
        </div>
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
                <tr>
                    <td>万堃</td>
                    <td>{{$tasks_sum->todo}}</td>
                    <td>{{$tasks_sum->deving}}</td>
                    <td>{{$tasks_sum->testing}}</td>
                    <td>{{$tasks_sum->over}}</td>
                </tr>
                <tr>
                    <td>万堃</td>
                    <td>{{$tasks_sum->todo}}</td>
                    <td>{{$tasks_sum->deving}}</td>
                    <td>{{$tasks_sum->testing}}</td>
                    <td>{{$tasks_sum->over}}</td>
                </tr>
                <tr>
                    <td>万堃</td>
                    <td>{{$tasks_sum->todo}}</td>
                    <td>{{$tasks_sum->deving}}</td>
                    <td>{{$tasks_sum->testing}}</td>
                    <td>{{$tasks_sum->over}}</td>
                </tr>
                <tr>
                    <td>万堃</td>
                    <td>{{$tasks_sum->todo}}</td>
                    <td>{{$tasks_sum->deving}}</td>
                    <td>{{$tasks_sum->testing}}</td>
                    <td>{{$tasks_sum->over}}</td>
                </tr>
                <tr>
                    <td>万堃</td>
                    <td>{{$tasks_sum->todo}}</td>
                    <td>{{$tasks_sum->deving}}</td>
                    <td>{{$tasks_sum->testing}}</td>
                    <td>{{$tasks_sum->over}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <label for="tb_tasks_sum">个人任务完成情况（换饼图或者柱状图横向）:</label>
            <table class="table table-bordered table-hover" id="tb_tasks_workload_sum">
                <thead>
                <tr>
                    <th>成员</th>
                    <th>开发工作量</th>
                    <th>测试工作量</th>
                    <th>合计</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>万堃</td>
                    <td>{{$tasks_workload_sum->developer_workload_all}}</td>
                    <td>{{$tasks_workload_sum->tester_workload_all}}</td>
                    <td>{{$tasks_workload_sum->developer_workload_all + $tasks_workload_sum->tester_workload_all}}</td>
                </tr>
                <tr>
                    <td>万堃</td>
                    <td>{{$tasks_workload_sum->developer_workload_all}}</td>
                    <td>{{$tasks_workload_sum->tester_workload_all}}</td>
                    <td>{{$tasks_workload_sum->developer_workload_all + $tasks_workload_sum->tester_workload_all}}</td>
                </tr>
                <tr>
                    <td>万堃</td>
                    <td>{{$tasks_workload_sum->developer_workload_all}}</td>
                    <td>{{$tasks_workload_sum->tester_workload_all}}</td>
                    <td>{{$tasks_workload_sum->developer_workload_all + $tasks_workload_sum->tester_workload_all}}</td>
                </tr>
                <tr>
                    <td>万堃</td>
                    <td>{{$tasks_workload_sum->developer_workload_all}}</td>
                    <td>{{$tasks_workload_sum->tester_workload_all}}</td>
                    <td>{{$tasks_workload_sum->developer_workload_all + $tasks_workload_sum->tester_workload_all}}</td>
                </tr>
                <tr>
                    <td>万堃</td>
                    <td>{{$tasks_workload_sum->developer_workload_all}}</td>
                    <td>{{$tasks_workload_sum->tester_workload_all}}</td>
                    <td>{{$tasks_workload_sum->developer_workload_all + $tasks_workload_sum->tester_workload_all}}</td>
                </tr>

                </tbody>
            </table>

        </div>
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
@stop

