<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title"><input type="text" id="name" class="form-control" value="" placeholder="请输入客户名..." ></h4>
</div>
<div class="modal-body">
    <form method="post" role="form" id="form_task" class="">
        {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="select_status">EKP合同客户名</label>
                    <div>
                        <input type="text" id="package_name" class="form-control" placeholder="EKP合同客户名" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="select_task_type">代码地址</label>
                    <div >
                        <input type="text" id="package_name" class="form-control" placeholder="代码地址" >
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="form-group">
                    <label>工作流版本信息</label>
                    <div class="check-demo-col">
                        <div class="check-line">
                            <input type="checkbox" id="is_standard">
                            <label class='inline' for="is_standard">是否标准版本</label>
                        </div>
                        <div class="check-line">
                            <input type="radio" id="is_update" name="is_update">
                            <label class='inline' for="is_update">是否升级</label>
                        </div>
                        <div class="check-line">
                            <input type="radio" id="is_aop" name="is_aop">
                            <label class='inline' for="is_aop">是否插件化</label>
                        </div>
                        <div class="check-line">
                            <input type="radio" id="update_type" name="update_type">
                            <label class='inline' for="update_type">标准更新包升级</label>
                        </div>
                        <div class="check-line">
                            <input type="radio" id="update_type" name="update_type">
                            <label class='inline' for="update_type">手工包升级</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="form-group">
                    <label for="update_reason">升级原因/背景</label>
                    <textarea class="form-control" rows="5" placeholder="请描述升级相关的背景、故事..." name="update_reason" id="update_reason"></textarea>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                    <label for="update_log">升级日志</label>
                    <textarea class="form-control" rows="5" placeholder="请描述升级相关的记录..." name="update_reason" id="update_reason"></textarea>
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
//        console.log(event.type + ' callback');
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