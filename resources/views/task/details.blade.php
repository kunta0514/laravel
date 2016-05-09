<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">{{$task->task_title}}[<a href="#" rel="{{$task->task_no}}" onclick="oprViewOnEKP()">{{$task->task_no}}</a>]</h4>
</div>
<div class="modal-body">
    <form method="post" role="form" id="form_task">
        <input type="hidden" name="id" value={{$task->id}}>
        <div class="form-group">
            <div class="btn-group">
                <label for="select-dev">开发</label>
                <select class="form-control" id="select-dev" name="dev">
                    <option value="" code="" >请选择</option>
                    @foreach($developers as $dev=>$value)
                        <option value="{{$dev}}" code="{{$dev}}" @if ($dev === $task->developer) selected @endif>{{$value}}</option>
                    @endforeach
                </select>
            </div>
            {{--{{$task->developer}}--}}
            <div class="btn-group">
                <label for="select-test">测试</label>
                <select class="form-control" id="select-test" name="test">
                    <option value="" code="" >请选择</option>
                    @foreach($testers as $test=>$value)
                        <option value="{{$test}}" code="{{$test}}" @if ($test === $task->tester) selected @endif>{{$value}}</option>
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
        <div class="form-group">
            <label for="package_name">更新包名称</label>
            <input type="text" id="package_name" class="form-control" value="{{$task->package_name}}" placeholder="更新包名称" >
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
    <button type="button" class="btn btn-primary @if($task->status =="3") hidden @endif" id="btnSubmit" data-ok="modal">
        确定
    </button>
</div>

<script type="text/javascript">
    var task_detail = {
        verify:function(data){

        }
    };

    $('#btnSubmit').on('click',function(){
        task.comment = $('#comment').val();
        task.developer=$("#select-dev").val();
        task.tester=$("#select-test").val();
        task.status=$("#select-status").val();

        //TODO::收集页面元素校验
        $.ajax({
            type: 'POST',
            data: task,
            url: '/task/detail_edit',
            success: function (data) {
//               console.log(data);
            }
        })
    });
    var task =<?= $task ?>;
</script>
