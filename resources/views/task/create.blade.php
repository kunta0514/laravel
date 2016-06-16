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
                                <option value="{{$dev->code}}" >{{$dev->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="select_dev" class="control-label col-sm-2">工作量</label>
                    <div class="col-sm-4">
                        <input type="text" id="developer_workload" class="form-control" placeholder="请输入" value="0">
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
                                <option value="{{$dev->code}}"></option>
                            @endforeach
                        </select>
                    </div>
                    <label for="tester_workload" class="control-label col-sm-2">工作量</label>
                    <div class="col-sm-4">
                        <input type="text" id="tester_workload" class="form-control" placeholder="请输入" value="0" >
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
                                <option value="{{$key}}" >{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="select_task_type" class="control-label col-sm-2">任务类型</label>
                    <div class="col-sm-4">
                        <select class="form-control" id="select_task_type" name="task_type">
                            <option value="" >请选择</option>
                            @foreach(Config('params.task_type') as $value)
                                <option value="{{$value}}" >{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">

                    <label for="select-date" class="control-label col-sm-2">完成时间</label>
                    <div class="col-sm-4">
                        <input type="text" id="actual_finish_date" value=""
                               class="form-control" placeholder="实际完成时间" data-toggle="datepicker" data-rule-required="true" data-rule-date="true">
                    </div>

                    <label for="PRI" class="control-label col-sm-2">优先级</label>
                    <div class="col-sm-4">
                        <input type="text" id="PRI" class="form-control" placeholder="请输入" value="0">
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

</script>