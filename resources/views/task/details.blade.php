<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">{{$task->task_title}}[<a href="#" rel="{{$task->task_no}}" onclick="oprViewOnEKP()">{{$task->task_no}}</a>]</h4>
</div>
<div class="modal-body">
    <form method="post" role="form" id="form_task" class="form-horizontal form-column form-bordered">
        {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
        <input type="hidden" name="id" value={{$task->id}}>
        <div class="row">
            {{--左侧--}}
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="select_dev" class="control-label col-sm-2 center">开发</label>
                    <div class="col-sm-4">
                        <select class="form-control" id="select_dev" name="dev">
                            <option value="" code="" >请选择</option>
                            @foreach($developers as $dev)
                                <option value="{{$dev->code}}"  @if ($dev->code === $task->developer) selected @endif>{{$dev->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="select_dev" class="control-label col-sm-2">工作量</label>
                    <div class="col-sm-4">
                        <input type="text" id="developer_workload" class="form-control" placeholder="请输入" value="{{$task->developer_workload}}">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="select_test" class="control-label col-sm-2">测试</label>
                    <div class="col-sm-4">
                        <select class="form-control" id="select_test" name="dev">
                            <option value="" code="" >请选择</option>
                            @foreach($testers as $dev)
                                <option value="{{$dev->code}}" @if ($dev->code === $task->developer) selected @endif>{{$dev->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="tester_workload" class="control-label col-sm-2">工作量</label>
                    <div class="col-sm-4">
                        <input type="text" id="tester_workload" class="form-control" placeholder="请输入" value="{{$task->tester_workload}}" >
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="select_status" class="control-label col-sm-2">状态</label>
                    <div class="col-sm-4">
                        <select class="form-control" id="select_status" name="status">
                            @foreach(Config('params.task_status') as $key=>$value)
                                <option value="{{$key}}" @if ($key === $task->status) selected @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="select-date" class="control-label col-sm-2">日期</label>
                    <div class="col-sm-4">
                        <input type="text" name="ekp_expect" {{$task->ekp_expect}} class="form-control" placeholder="完成日期" data-toggle="datepicker" data-rule-required="true" data-rule-date="true">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="package_name" class="control-label col-sm-2">更新包</label>
                    <div class="col-sm-10">
                        <input type="text" id="package_name" class="form-control" value="" placeholder="更新包名称" >
                    </div>

                </div>
                <div class="form-group">
                    <label for="select-date" class="control-label col-sm-2">备注/总结</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="7" placeholder="{{$task->comment}}" name="comment" id="comment">{{$task->comment}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div><!-- /.modal-content -->
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消
    </button>
    <button type="button" class="btn btn-primary" id="btnSubmit" data-ok="modal">
        确定
    </button>
</div>

<script type="text/javascript">
    var task_detail = {
        getPageNameString:function(data){
            var year = (new Date()).getFullYear();
            var month = ((new Date()).getMonth() + 1) < 10 ? "0" + ((new Date()).getMonth() + 1) : (new Date()).getMonth() + 1;
            var day = (new Date()).getDate() < 10 ? "0" + ((new Date()).getDate() + 1) : (new Date()).getDate();
            return "[" + data.task_no + "]-" + data.customer_name + "-工作流-" + year + "" + month + day + "-第1次";
        },
        verify:function(data){

        }
    };

    $('#btnSubmit').on('click',function(){
        task.comment = $('#comment').val();
        task.developer = $('#select_dev').val();
        task.developer_workload = $('#developer_workload').val();
        task.tester =  $('#select_test').val();
        task.tester_workload = $('#tester_workload').val();
        task.status = $('#select_status').val();
        console.log($('#select_dev'));
        console.log($('#developer_workload').val());
        //TODO::收集页面元素校验
        $.ajax({
            type: 'POST',
            data: task,
            url: '/task/detail_edit',
            success: function (data) {
//                console.log(data);
            }
        })
    });
    var task = <?= $task ?>;
    $('#package_name').val(task_detail.getPageNameString(task));
</script>