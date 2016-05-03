
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">{{$task->task_title}}</h4>
</div>
<div class="modal-body">
    <form method="post" role="form" id="form_task">
        {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
        <input type="hidden" name="id" value={{$task->id}}>
        <div class="form-group">
            <div class="btn-group">
                <label for="select-dev">开发</label>
                <select class="form-control" id="select-dev" name="dev">
                    <option value="" code="" >请选择</option>
                    @foreach($developers as $dev)
                        <option value="{{$dev->name}}" code="{{$dev->code}}" @if ($dev->code === $task->developer) selected @endif>{{$dev->name}}</option>
                    @endforeach
                </select>
            </div>
            {{--{{$task->developer}}--}}
            <div class="btn-group">
                <label for="select-test">测试</label>
                <select class="form-control" id="select-test" name="test">
                    <option value="" code="" >请选择</option>
                    @foreach($testers as $test)
                        <option value="{{$test->name}}" code="{{$test->code}}" @if ($dev->code === $task->tester) selected @endif>{{$test->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="btn-group">
                <label for="select-status">状态</label>
                <select class="form-control" id="select-status" name="status">
                    @foreach(Config('params.task_status') as $key=>$value)
                        @if($key<4)
                            <option value="{{$key}}" @if ($key === $task->status) selected @endif>{{$value}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        {{--<div class="form-group">--}}
        {{--<label for="select-date">预计完成日期</label>--}}
        {{--<input type="text" name="ekp_expect" {{$task->ekp_expect}} class="form-control" placeholder="选择日期" data-toggle="datepicker" data-rule-required="true" data-rule-date="true">--}}
        {{--</div>--}}
        <div class="form-group">
            <label for="package_name">更新包名称</label>
            <input type="text" id="package_name" class="form-control" value="" placeholder="更新包名称" >
        </div>

        <div class="form-group">
            <label for="select-date">备注/总结</label>
            <textarea class="form-control" rows="7" placeholder="{{$task->comment}}" name="comment" id="comment">{{$task->comment}}</textarea>
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
        console.log(task);
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