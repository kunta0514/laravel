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
        .my_tr
        {
            margin-top: 5px;
        }
        .my_tr tr
        {
            cursor: pointer;
        }
    </style>
    <div class="container">
        <div class="row">
       <div class="query-form col-md-12">
           <form id="query_task" class="form-inline" method="get">
               <div class="form-group">
                   <select class="form-control" id="select_type" name="select_type">
                       <option value="task_no">任务编号</option>
                       <option value="task_title">任务标题</option>
                       <option value="customer_name">客户名称</option>
                      </select>
                   <input type="text" name="task_key" id="task_key" class="form-control" placeholder="任务编号" >
               </div>
               <div class="form-group">
                   <label for="begin-date">从</label>
                   <input type="text" name="begin_date" id="begin_date" class="form-control" placeholder="选择时间" data-toggle="datepicker" data-rule-required="true" data-rule-date="true">
               </div>
               <div class="form-group">
                   <label for="end-date">到</label>
                   <input type="text" name="end_date" id="end_date" class="form-control" placeholder="选择日期" data-toggle="datepicker" data-rule-required="true" data-rule-date="true">
               </div>
               <div class="form-group">
                   <label for="select-dev"> 开发</label>
                   <select class="form-control" id="select_dev" name="select_dev">
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
               <button type="button" class="btn btn-default" id="btn_query_task">查询任务</button>
           </form>
       </div>

        </div>
        <div name="check_process_bar" class="progress" style="margin: 5px 0;display: none">
            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                <span class="sr-only">100% Complete</span>
            </div>
        </div>
        <div class="row">
        <div class="list col-md-12">
            <table class="table table-condensed table-hover table-bordered my_tr" id="example">
                <thead>
                <tr>
                    {{--<th title="序号">#</th>--}}
                    <th>任务编号</th>
                    <th >任务标题</th>
                    <th>客户</th>
                    <th>开发</th>
                    <th>完成时间</th>
                    <th>备注</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            var data_tables = $('#example').DataTable({
                paging: false,//分页
                ordering: true,//是否启用排序
                searching: false,//搜索
                "ajax": "query_task",
                "columns": [
                    {"data": "task_no"},
                    {"data": "task_title"},
                    {"data": "customer_name"},
                    {"data": "dev"},
                    {"data": "actual_finish_date"},
                    {"data": "comment"}
                ],
                "initComplete": function( settings, json ) {
                    $("div[name='check_process_bar']").hide();
                }
            });
            //查询按钮事件绑定
            $("#btn_query_task").unbind('click').bind('click', function () {
                $("div[name='check_process_bar']").show();
                data_tables.ajax.url( 'query_task?'+$("#query_task").serialize() ).load(function(){
                    $("div[name='check_process_bar']").hide();
                });
            });

        });

        function getParam(url) {
            var data = decodeURI(url).split("?")[1];
            var param = {};
            var strs = data.split("&");

            for(var i = 0; i<strs.length; i++){
                param[strs[i].split("=")[0]] = strs[i].split("=")[1];
            }
            return param;
        }
    </script>
@stop