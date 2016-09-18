<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">{{$customer->name}}</h4>
</div>
<div class="modal-body">
    <form method="post" role="form" id="form_task" class="">
        {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
        <input type="hidden" id="id" name="id" value={{$customer->id}}>
        <input type="hidden" id="uuid" name="uuid" value={{$customer->uuid}}>
        <div class="row">
            <div class="col-sm-5">
                <div class="form-group">
                    <label for="ekp_latest_name">EKP合同客户名</label>
                    <div>
                        <input type="text" id="ekp_latest_name" class="form-control" value="{{$customer->ekp_latest_name}}" placeholder="EKP合同客户名" >
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="area">所属区域</label>
                    <div>
                        <input type="text" id="area" class="form-control" value="{{$customer->area}}" placeholder="所属区域" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="select_status">重要客户{{$customer->level}}</label>
                    <div>
                        <select class="form-control" id="select_customer_level" name="select_customer_level">
                            @foreach(Config('params.customer_level') as $k=>$value)
                                <option value="{{$k}}" @if ($k === $customer->level) selected @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="form-group">
                    <label for="ekp_code">EKP客户编码</label>
                    <div>
                        <input type="text" id="ekp_code" class="form-control" value="{{$customer->ekp_code}}" placeholder="EKP客户编码" >
                    </div>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="form-group">
                    <label for="select_task_type">代码地址</label>
                    <div >
                        <input type="text" id="path" class="form-control" value="{{$customer->path}}" placeholder="代码地址" readonly >
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5">
                <div class="form-group">
                    <label>工作流版本信息</label>
                    <div class="check-demo-col">
                        <div class="check-line">
                            <input type="checkbox" id="is_standard" @if($customer->is_standard == 1) checked @endif">
                            <label class='inline' for="is_standard" >是否标准版本</label>
                        </div>
                        <div class="check-line">
                            <input type="checkbox" id="is_update" name="is_update" @if($customer->is_update == 1) checked @endif>
                            <label class='inline' for="is_update" >是否升级</label>
                        </div>
                        <div class="check-line">
                            <input type="checkbox" id="is_aop" name="is_aop" @if($customer->is_aop == 1) checked @endif>
                            <label class='inline' for="is_aop">是否插件化</label>
                        </div>
                        <div class="check-line">
                            <input type="radio" id="update_type_standard" name="update_type" @if($customer->update_type == 1) checked @endif>
                            <label class='inline' for="update_type">标准更新包升级</label>
                        </div>
                        <div class="check-line">
                            <input type="radio" id="update_type" name="update_type" @if($customer->update_type == 2) checked @endif>
                            <label class='inline' for="update_type">手工包升级</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="form-group">
                    <label for="update_reason">升级原因/背景</label>
                    <textarea class="form-control" rows="5" placeholder="请描述升级相关的背景、故事..." name="update_reason" id="update_reason">{{$customer->update_reason}}</textarea>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                    <label for="update_log">升级日志</label>
                    <textarea class="form-control" rows="3" placeholder="请描述升级相关的记录..." name="update_reason" id="update_reason">{{$customer->update_log}}</textarea>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-12">
                <label for="detail_example">个性化代码列表</label>
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
    var customer = <?= $customer ?>;

    $('input[type=checkbox]').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red',
        increaseArea: '20%' // optional
    });
    $('input[type=radio]').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red',
        increaseArea: '20%' // optional
    });

//    $('#update_type').on('ifChecked', function(event){
////        alert(event.type + ' callback');
////        console.log(event.type + ' callback');
//    });

    $('#btnSubmit').on('click',function(){
        if($('#is_standard').is(':checked')){
            customer.is_standard = 1;
        }
        else{
            customer.is_standard = 0;
        }
        if($('#is_update').is(':checked')){
            customer.is_update = 1;
        }else{
            customer.is_update = 0;
        }
        if($('#is_aop').is(':checked')){
            customer.is_aop = 1;
        }else{
            customer.is_aop = 0;
        }
        if($('#update_type_standard').is(':checked')){
            customer.update_type = 1;
        }else{
            customer.update_type = 2;
        }

        customer.ekp_latest_name = $('#ekp_latest_name').val();
        customer.area = $('#area').val();
        customer.update_reason = $('#update_reason').val();
        customer.level = $('#select_customer_level').val();
        customer.ekp_code = $('#ekp_code').val();
        console.log(customer);
        //TODO::收集页面元素校验
        $.ajax({
            type: 'POST',
            data: customer,
            url: '/customer/update/'+ $('#id').val(),
            success: function (data) {
//                console.log(data);
            }
        })
    });
</script>