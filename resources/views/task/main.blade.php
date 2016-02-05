@extends('templates.default')
@section('content')


<div class="container">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <td>序号</td>
                <td>类别</td>
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
                <td>{{$task->TaskType}}</td>
                <td class="details" rel={{$task->id}}>{{$task->TaskTitle}}</td>
                <td>{{$task->CustomerName}}</td>
                <td>{{$task->AbuPM}}</td>
                <td><span  data-toggle="modal" data-target="#myModal" >{{$task->TaskTitle}}</span></td>
                <td></td>
                <td></td>
                <td>{{$task->Status}}</td>
                <td>{{$task->Comment}}</td>
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
                        <div class="form-group">
                            <label for="task-no">需求编号:</label>
                            <input type="email" class="form-control" id="task-no" >
                        </div>
                        <div class="form-group">
                            <label for="task-title">需求标题:</label>
                            <input type="password" class="form-control" id="task-title" >
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


    <script>
        //TODO：页面对象与model对象合并
//        (function(){
//
//        })();
//
//        (function(){
//
//        })();
//
//        if(window.jQuery || window.Zepto){
//            $(function (){
//
//            });
//        }


        $('.details').on('click',function(){
            //1.根据ID获取详细（get）
            console.info($(this).attr('rel'));
            $.ajax({

            });
            //2.清理modal缓存，再赋值
//            $('#myModal').modal('show')
            //3.绑定保存事件
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


