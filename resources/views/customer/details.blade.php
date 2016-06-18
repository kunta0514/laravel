<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">{{$customer->name}}</h4>
</div>
<div class="modal-body">
    <form method="post" role="form" id="form_task" class="form-horizontal form-column form-bordered">
        {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
        <input type="hidden" name="id" value={{$customer->id}}>
        <input type="hidden" name="uuid" value={{$customer->uuid}}>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="select_status" class="control-label col-sm-2" style="text-align: left">EKP名称</label>
                    <div class="col-sm-4">
                        <input type="text" id="package_name" class="form-control" value="{{$customer->ekp_latest_name}}" placeholder="EKP名称" >
                    </div>
                    <label for="select_task_type" class="control-label col-sm-2">代码地址</label>
                    <div class="col-sm-4">
                        <input type="text" id="package_name" class="form-control" value="{{$customer->path}}" placeholder="EKP名称" >
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <h5>个性化代码列表</h5>
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

<script type="text/javascript">
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