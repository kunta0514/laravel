@extends('templates.default')
@section('content')
    <div class="">
        <div class="modal-body">
            <form method="post" role="form" id="form_task" class="">
                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="select_status">EKP合同客户</label>
                            <div>
                                <input type="text" id="package_name" class="form-control" value=""
                                       placeholder="EKP合同客户">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="select_task_type">代码地址</label>
                            <div>
                                <input type="text" id="package_name" class="form-control" value="" placeholder="代码地址">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label >是否标准版本</label>
                            <div class="check-demo-col">
                                <div class="check-line">
                                    <input type="radio" id="standard1" name="standard">
                                    <label class='inline' for="standard1">Default</label>
                                </div>
                                <div class="check-line">
                                    <input type="radio" id="standard2" name="standard" checked>
                                    <label class='inline' for="standard2">Checked</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label >是否升级</label>
                            <div class="check-demo-col">
                                <div class="check-line">
                                    <input type="radio" id="update1" name="update" >
                                    <label class='inline' for="update1">Default</label>
                                </div>
                                <div class="check-line">
                                    <input type="radio" id="update2" name="update" checked>
                                    <label class='inline' for="update2">Checked</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div>
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
        $(document).ready(function(){
            $('input').iCheck({
                checkboxClass: 'icheckbox_minimal-red',
                radioClass: 'iradio_minimal-red',
                increaseArea: '20%' // optional
            });
        });
        $('#btnSubmit').on('click', function () {
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
    </script>
@stop