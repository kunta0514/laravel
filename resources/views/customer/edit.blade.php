<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">{{$customer->name}}</h4>
</div>
<div class="modal-body">
    <form method="post" role="form" id="form_task" class="">
        {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
        <input type="hidden" name="id" value={{$customer->id}}>
        <input type="hidden" name="uuid" value={{$customer->uuid}}>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="select_status">EKP合同客户名</label>
                    <div>
                        <input type="text" id="package_name" class="form-control" value="{{$customer->ekp_latest_name}}" placeholder="EKP合同客户名" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="select_task_type">代码地址</label>
                    <div >
                        <input type="text" id="package_name" class="form-control" value="{{$customer->path}}" placeholder="代码地址" >
                    </div>
                </div>

            </div>
            <div class="col-sm-12">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>工作流版本信息</label>
                        <div class="check-demo-col">
                            <div class="check-line">
                                <input type="checkbox" id="is_standard">
                                <label class='inline' for="is_standard">标准版本</label>
                            </div>
                            <div class="check-line">
                                <input type="checkbox" id="is_update" name="is_update">
                                <label class='inline' for="is_update">标准包升级</label>
                            </div>
                            <div class="check-line">
                                <input type="checkbox" id="is_update" name="is_update">
                                <label class='inline' for="is_update">老客户手工包</label>
                            </div>
                            <div class="check-line">
                                <input type="checkbox" id="is_update" name="is_update">
                                <label class='inline' for="is_update">ESB统一引擎</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="form-group">
                        <label for="update_reason">升级原因/背景</label>
                        <textarea class="form-control" rows="4" placeholder="请描述升级相关的背景、故事..." name="update_reason" id="update_reason"></textarea>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <h4 class="modal-title">个性化代码列表</h4>
            </div>
            <div class="col-sm-12">
                <table class="table table-bordered table-hover" id="detail_example">
                    <thead>
                    <tr>
                        <th style="width: 100px">ERP</th>
                        <th style="width: 60px">工作流</th>
                        <th >代码地址</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($customer_details as $customer_detail)
                        <tr>
                            <td>{{$customer_detail->erp_version}}</td>
                            <td>{{$customer_detail->workflow_version}}</td>
                            <td>{{$customer_detail->workflow_path}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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
//    $('input').iCheck();

    $('input').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red',
        increaseArea: '20%' // optional
    });

    $('input').on('ifChecked', function(event){
//        alert(event.type + ' callback');
        console.log(event.type + ' callback');
    });

    $('#btnSubmit').on('click',function(){
//        customer.comment = $('#comment').val();
//        customer.developer = $('#select_dev').val();
//        customer.developer_workload = $('#developer_workload').val();
//        customer.tester =  $('#select_test').val();
//        customer.tester_workload = $('#tester_workload').val();
//        customer.status = $('#select_status').val();
//        customer.actual_finish_date = $("#actual_finish_date").val();
//        customer.task_type = $("#select_task_type").val();
        console.log(customer);
        //TODO::收集页面元素校验
//        $.ajax({
//            type: 'POST',
//            data: task,
//            url: '/task/detail_edit',
//            success: function (data) {
////                console.log(data);
//            }
//        })
    });
    var customer = <?= $customer ?>;
</script>