<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4>{{$demand->demand_name}}</h4>
</div>
<div class="modal-body">
    <form method="post" role="form" id="form_task" class="form-horizontal form-column form-bordered">
        {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
        <input type="hidden" name="id" value={{$demand->id}}>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="package_name" class="control-label col-sm-2">故事描述</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="5" placeholder="{{$demand->story}}" name="story" id="story">{{$demand->story}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="package_name" class="control-label col-sm-2">验收标准</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="5" placeholder="{{$demand->acceptance}}" name="acceptance" id="acceptance">{{$demand->acceptance}}</textarea>
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
                                <option value="{{$key}}" @if ($key === $demand->status) selected @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="select_task_type" class="control-label col-sm-2">任务来源</label>
                    <div class="col-sm-4">
                        <select class="form-control" id="select_task_type" name="task_type">
                            <option value="" >请选择</option>
                            @foreach(Config('params.task_type') as $value)
                                <option value="{{$value}}" @if ($value === $demand->task_type) selected @endif>{{$value}}</option>
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
                        <input type="text" id="actual_finish_date" value="@if (date("Y-m-d",strtotime("$demand->actual_finish_date")) == '-0001-11-30' || date("Y-m-d",strtotime("$demand->actual_finish_date")) == '1900-01-01' || date("Y-m-d",strtotime("$demand->actual_finish_date")) == '1970-01-01') @else <?= date("Y-m-d",strtotime("$demand->actual_finish_date")) ?> @endif"
                               class="form-control" placeholder="实际完成时间" data-toggle="datepicker" data-rule-required="true" data-rule-date="true">
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
                        <textarea class="form-control" rows="7" placeholder="{{$demand->comment}}" name="comment" id="comment">{{$demand->comment}}</textarea>
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

    //选到已完成，自动当前日期.
    $('#select_status').on('change',function(){
        if(this.value == '3' && $("#actual_finish_date").val() == ' '){
            $("#actual_finish_date").datepicker('setDate',new Date());
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
    var task = <?= $demand ?>;
    $('#package_name').val(task_detail.getPageNameString(task));
</script>