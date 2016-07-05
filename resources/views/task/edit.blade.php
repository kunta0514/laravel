<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">{{$task->task_title}}[<a href="#" rel="{{$task->ekp_oid}}" onclick="oprViewOnEKP(this)">{{$task->task_no}}</a>]</h4>
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

            <div class="col-sm-12">
                <div class="form-group">
                    <label for="select_test" class="control-label col-sm-2">测试</label>
                    <div class="col-sm-4">
                        <select class="form-control" id="select_test" name="dev">
                            <option value="" code="" >请选择</option>
                            @foreach($testers as $dev)
                                <option value="{{$dev->code}}" @if ($dev->code === $task->tester) selected @endif>{{$dev->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="tester_workload" class="control-label col-sm-2">工作量</label>
                    <div class="col-sm-4">
                        <input type="text" id="tester_workload" class="form-control" placeholder="请输入" value="{{$task->tester_workload}}" >
                    </div>
                </div>
            </div>

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

                    <label for="select-date" class="control-label col-sm-2">完成时间</label>
                    <div class="col-sm-4">
                        <input type="text" id="actual_finish_date" value="@if (date("Y-m-d",strtotime("$task->actual_finish_date")) == '-0001-11-30' || date("Y-m-d",strtotime("$task->actual_finish_date")) == '1900-01-01' || date("Y-m-d",strtotime("$task->actual_finish_date")) == '1970-01-01') @else <?= date("Y-m-d",strtotime("$task->actual_finish_date")) ?> @endif"
                               class="form-control" placeholder="实际完成时间" data-toggle="datepicker" data-rule-required="true" data-rule-date="true">
                    </div>

                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                    <label for="select_task_type" class="control-label col-sm-2">任务类型</label>
                    <div class="col-sm-4">
                        <select class="form-control" id="select_task_type" name="task_type">
                            <option value="" >请选择</option>
                            @foreach(Config('params.task_type') as $value)
                                <option value="{{$value}}" @if ($value === $task->task_type) selected @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="PRI" class="control-label col-sm-2">优先级</label>
                    <div class="col-sm-4">
                        <input type="number" id="PRI" class="form-control" placeholder="请输入" value="{{$task->PRI}}">
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="package_name" class="control-label col-sm-2">任务分类</label>
                    <div class="col-sm-10">
                        <div class="check-line" style="padding-top: 7px">
                            <input type="radio" id="no_update" name="update_type" @if($task->update_type == 0) checked @endif>
                            <label class='inline' for="no_update" >一般任务</label>
                            <input type="radio" id="update_type_standard" name="update_type" @if($task->update_type == 1) checked @endif>
                            <label class='inline' for="update_type_standard" >标准升级处理</label>
                            <input type="radio" id="update_type" name="update_type" @if($task->update_type == 2) checked @endif>
                            <label class='inline' for="update_type" >手工升级处理</label>
                        </div>
                    </div>
                </div>
            </div>
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
<link href="{{asset('vendor/css/icheck/all.css')}}" rel="stylesheet">
<script src="{{asset('vendor/js/icheck/jquery.icheck.min.js')}}"></script>
<script type="text/javascript">
    $('input[type=radio]').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red',
        increaseArea: '20%' // optional
    });
    //TODO::调整成不刷新页面，只刷新表格的模式（监控两者之间的性能差距）
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

    //选到已完成，自动当前日期.
    $('#select_status').on('change',function(){
        if((this.value == '3' || this.value == '4')&& $("#actual_finish_date").val() == ' '){
            $("#actual_finish_date").datepicker('setDate',new Date());
            $("#PRI").val(0);
        }
//        console.log(this.value);
//        console.log($("#actual_finish_date").val());
    })

    $('#btnSubmit').on('click',function(){
        task.comment = $('#comment').val();
        task.developer = $('#select_dev').val();
        task.developer_workload = $('#developer_workload').val();
        task.tester =  $('#select_test').val();
        task.tester_workload = $('#tester_workload').val();
        task.status = $('#select_status').val();
        task.actual_finish_date = $("#actual_finish_date").val();
        task.task_type = $("#select_task_type").val();

        if($('#no_update').is(':checked')) task.update_type = 0;
        if($('#update_type_standard').is(':checked')) task.update_type = 1;
        if($('#update_type').is(':checked')) task.update_type = 2;

        task.PRI = $("#PRI").val();
        console.log(task.task_type);
        //TODO::收集页面元素校验
        $.ajax({
            type: 'POST',
            data: task,
            url: '/task/update/'+ $('input[name=id]').val(),
            success: function (data) {

            }
        })
    });
    var task = <?= $task ?>;
    $('#package_name').val(task_detail.getPageNameString(task));
</script>