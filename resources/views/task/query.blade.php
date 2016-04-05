@extends('templates.default')
@section('content')
    <style type="text/css">
        .query-form
        {
            width: 100%;
            height: 35px;
        }
        .query-form ul li
        {
            list-style: none;
            float: left;
            margin-right: 5px;
            line-height: inherit;
            vertical-align: middle;
        }
    </style>
    <div class="container">
       <div class="query-form">
           <form class="form-inline" method="get">
               <div class="form-group">
                   <label for="begin-date">任务完成时间：从</label>
                   <input type="text" name="begin-date" id="begin-date" class="form-control" placeholder="选择时间" data-toggle="datepicker" data-rule-required="true" data-rule-date="true">
               </div>
               <div class="form-group">
                   <label for="end-date">到</label>
                   <input type="text" name="end-date" id="end-date" class="form-control" placeholder="选择日期" data-toggle="datepicker" data-rule-required="true" data-rule-date="true">
               </div>
               <div class="form-group">
                   <label for="select-dev"> 开发</label>
                   <select class="form-control" id="select-dev" name="select-dev">
                       <option value=""></option>
                       @foreach($developers as $dev)
                           <option value="{{$dev->code}}">{{$dev->name}}</option>
                       @endforeach
                   </select>
               </div>
               {{--<div class="form-group">--}}
                   {{--<label for="exampleInputEmail2">状态</label>--}}
                   {{--<input type="email" class="form-control" id="exampleInputEmail2" placeholder="状态">--}}
               {{--</div>--}}
               <button type="submit" class="btn btn-default">查询任务</button>
           </form>
       </div>
        <div class="list">
            <table class="table table-bordered table-hover" id="example">
                <thead>
                <tr>
                    <th title="序号">#</th>
                    <th>任务编号</th>
                    <th >任务标题</th>
                    <th>客户</th>
                    <th>PM</th>
                    <th>开发</th>
                    <th>测试</th>
                    <th>计划完成</th>
                </tr>
                </thead>
                <tbody>

                @foreach($tasks as $k=>$task)
                    <tr rel="{{$task->id}}" >
                        <th scope="row" >{{$k+1}}</th>
                        <td><a href="#" name="view_on_erp" rel="{{$task->task_no}}">{{$task->task_no}}</a></td>
                        <td class="details" rel={{$task->id}} data-toggle="tooltip" data-placement="top" title="{{$task->task_title}}">
                            <a href="{{URL('task/get_details')}}/{{$task->id}}"></a>@if(mb_strlen($task->task_title)>23) {{mb_substr($task->task_title,0,23)}}...@else {{$task->task_title}} @endif
                        </td>
                        <td>{{$task->customer_name}}</td>
                        <td>{{$task->abu_pm}}</td>
                        <td class="@if($task->status=='1')or_doing @endif">{{$task->dev}}</td>
                        <td class="@if($task->status=='2')or_doing @endif">{{$task->test}}</td>
                        {{--                <td>@if($task->actual_finish_date) {{substr($task->actual_finish_date,0,10)}} @endif</td>deadline--}}
                        <td>{{ $task->actual_finish_date}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $('#example').dataTable({
                lengthMenu: [15, 30, 50, 100],//这里也可以设置分页，但是不能设置具体内容，只能是一维或二维数组的方式，所以推荐下面language里面的写法。
                paging: false,//分页
                ordering: true,//是否启用排序
                searching: false,//搜索
                language: {
                    lengthMenu: '每页<select class="form-control input-xsmall">' + '<option value="15">15</option>' + '<option value="30">30</option>' + '<option value="50">50</option>' + '<option value="100">100</option>' + '</select>条记录',//左上角的分页大小显示。
                    search: '搜索：',//右上角的搜索文本，可以写html标签

                    paginate: {//分页的样式内容。
                        previous: "上一页",
                        next: "下一页",
                        first: "第一页",
                        last: "最后"
                    },

                    zeroRecords: "没有内容",//table tbody内容为空时，tbody的内容。
                    //下面三者构成了总体的左下角的内容。
                    info: "总共_PAGES_ 页，显示第_START_ 到第 _END_ ，筛选之后得到 _TOTAL_ 条，初始_MAX_ 条 ",//左下角的信息显示，大写的词为关键字。
                    infoEmpty: "0条记录",//筛选为空时左下角的显示。
                    infoFiltered: ""//筛选之后的左下角筛选提示，
                },
            });
        });
    </script>
@stop