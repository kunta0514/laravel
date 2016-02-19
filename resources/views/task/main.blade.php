@extends('templates.default')
@section('content')


<div class="container">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <td>序号</td>
                <td>任务编号</td>
                <td>任务标题</td>
                <td>客户</td>
                <td>PM</td>
                <td>开发</td>
                <td>测试</td>
                <td>工作量</td>
                <td>状态</td>
                <td>备注</td>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                <td></td>
                <td>{{$task->task_no}}</td>
                <td class="details" rel={{$task->id}}>{{$task->task_title}}</td>
                <td>{{$task->customer_name}}</td>
                <td>{{$task->abu_pm}}</td>
                <td><span  data-toggle="modal" data-target="#myModal" >{{$task->task_title}}</span></td>
                <td></td>
                <td></td>
                <td>{{$task->status}}</td>
                <td>{{$task->comment}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">×
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        模态框（Modal）标题
                    </h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ URL('task.store') }}" role="form" >

                        <div class="row">
                            <div class="col-xs-1">

                            </div>
                            <div class="col-xs-2">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="task-no">需求编号:</label>
                            <input type="text" class="form-control" id="task-no" >
                        </div>
                        <div class="form-group">
                            <label for="task-title">需求标题:</label>
                            <input type="text" class="form-control" id="task-title" >
                        </div>

                        按下 ESC 按钮退出。

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">关闭
                    </button>
                    <button type="button" class="btn btn-primary">
                        提交更改
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



    <div class="form-group">
        <label for="dtp_input1" class="col-md-2 control-label">DateTime Picking</label>
        <div class="input-group date form_datetime col-md-5" data-date="1979-09-16T05:25:07Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
            <input class="form-control" size="16" type="text" value="" readonly>
            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
        </div>
        <input type="hidden" id="dtp_input1" value="" /><br/>
    </div>
    <div class="form-group">
        <label for="dtp_input2" class="col-md-2 control-label">Date Picking</label>
        <div class="input-group date form_date col-md-5" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
            <input class="form-control" size="16" type="text" value="" readonly>
            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
        <input type="hidden" id="dtp_input2" value="" /><br/>
    </div>
    <div class="form-group">
        <label for="dtp_input3" class="col-md-2 control-label">Time Picking</label>
        <div class="input-group date form_time col-md-5" data-date="" data-date-format="hh:ii" data-link-field="dtp_input3" data-link-format="hh:ii">
            <input class="form-control" size="16" type="text" value="" readonly>
            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
        </div>
        <input type="hidden" id="dtp_input3" value="" /><br/>
    </div>

    <link href="//cdn.bootcss.com/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker-standalone.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <script src="//cdn.bootcss.com/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

    <div class="container">
        <div class="row">
            <div class='col-sm-6'>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker2'>
                        <input type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                $(function () {
                    $('#datetimepicker2').datetimepicker({
                        locale: 'ru'
                    });
                });
            </script>
        </div>
    </div>
    <script>
        //TODO：页面对象与model对象合并
        (function() {

            window.task = {};
        })();

        $('.details').on('click',function(){
            //1.根据ID获取详细（get）
            console.info($(this).attr('rel'));

            $.ajax({
                type:'GET',
                url:'/task/get_details/'+ $(this).attr('rel'),
                dataType:'json',
                success:function(data){
                    console.info(data);
                    $('#task-no').val(data.task_no);
                    $('#task-title').val(data.task_title);
                    $('#myModal').modal('toggle');
                    //http://v3.bootcss.com/javascript/#modals
                }
            });
            //2.清理modal缓存，再赋值
//            $('#myModal').modal('show')
            //3.绑定保存事件
        });

        $('.form_datetime').datetimepicker({
            //language:  'fr',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0,
            showMeridian: 1
        });
        $('.form_date').datetimepicker({
            language:  'fr',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0
        });
        $('.form_time').datetimepicker({
            language:  'fr',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 1,
            minView: 0,
            maxView: 1,
            forceParse: 0
        });

//        $(function () {
//            $('#myModal').modal('hide')
//        });
    </script>
    <script>
//        $(function () { $('#myModal').on('hide.bs.modal', function () {
//            alert('嘿，我听说您喜欢模态框...');})
//        });
    </script>

@stop


