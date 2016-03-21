<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">{{$details[0]->task_title}}</h4>
</div>
<div class="modal-body">
    <form method="post" action="{{ URL('task/edit') }}" role="form" id="form_task">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="task_id" id="task_id" value="{{$details[0]->id}}">
        <div class="form-group">
            <div class="btn-group">
                <label for="select-dev">开发</label>
                <select class="form-control" id="select-dev" defalut="{{$details[0]->dev}}">
                    @foreach($developers as $dev)
                        <option value="{{$dev->code}}">{{$dev->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="btn-group">
                <label for="select-test">测试</label>
                <select class="form-control" id="select-test" defalut="{{$details[0]->test}}">
                    @foreach($testers as $test)
                        <option value="{{$test->code}}">{{$test->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="select-date">截止日期</label>
            <input type="text" name="date" id="select-date" class="form-control" placeholder="选择日期" data-toggle="datepicker" data-rule-required="true" data-rule-date="true" defalut="{{$details[0]->actual_finish_date}}">        </div>

        <div class="form-group">
            <label for="select-date">备注/总结</label>
            <textarea id="comment" class="form-control" rows="3" placeholder="请输入..">{{$details[0]->comment}}</textarea>
        </div>
    </form>
    <div class="modal-footer">
        <button type="button" class="btn btn-default"
                data-dismiss="modal">取消
        </button>
        <button type="button" class="btn btn-primary" >
            确定
        </button>
    </div>
</div>