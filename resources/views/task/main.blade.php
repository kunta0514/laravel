@extends('templates.default')
@section('content')
    <style type="text/css">
        .tr_undo{

        }
        .tr_doing{
            background-color: rgb(166, 220, 163);
        }
        #example tr{
            cursor: pointer;
        }
        .or_doing{
            /*background-color:rgb(251, 243, 145);*/
            background-color: rgb(166, 220, 163);
        }
    </style>


<div class="container">
    <table class="table table-bordered table-hover" id="example">
        <thead>
            <tr>
                <th title="序号">#</th>
                <th>任务编号</th>
                <th >任务标题</th>
                <th>客户</th>
                <th>PM</th>
                <th>开发</th>
                <th>测试</th>
                <th>倒计时(h)</th>
                <th></th>
            </tr>
        </thead>
        <tbody>

        @foreach($tasks as $k=>$task)
            <tr rel="{{$task->id}}" >
                {{--class="@if($task->status <3 && $task->status >0) tr_doing @endif"--}}
                <th scope="row" >{{$k+1}}</th>
                <td><a href="#" name="view_on_erp" rel="{{$task->task_no}}">{{$task->task_no}}</a></td>
                <td class="details" rel={{$task->id}} data-toggle="tooltip" data-placement="top" title="{{$task->task_title}}">
                    <a href="{{URL('task/get_details')}}/{{$task->id}}"></a>@if(mb_strlen($task->task_title)>23) {{mb_substr($task->task_title,0,23)}}...@else {{$task->task_title}} @endif
                </td>
                <td>{{$task->customer_name}}</td>
                <td>{{$task->abu_pm}}</td>
                <td class="@if($task->status=='1')or_doing @endif">{{$task->dev}}</td>
                <td class="@if($task->status=='2')or_doing @endif">{{$task->test}}</td>
{{--                <td>@if($task->actual_finish_date) {{substr($task->actual_finish_date,0,10)}} @endif</td>deadline--}}
                <td>{{$task->deadline}}</td>
                <td>
                    <span name="chk_finish" data-toggle="tooltip" data-placement="top"
                          class="glyphicon chk_finish @if($task->status == 1) glyphicon-pushpin @elseif($task->status == 2) glyphicon-check @else glyphicon-flag @endif"
                          title="标记为{{config('params.task_status')[$task->status+1] }}..." rel="{{$task->id}}" status="{{$task->status}}">
                    </span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade fixed" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ URL('task/edit') }}" role="form" id="form_task">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="task_id" id="task_id" value="">
                        <div class="form-group">
                            <div class="btn-group">
                                <label for="select-dev">开发</label>
                                <select class="form-control" id="select-dev" name="dev">
                                    @foreach($developers as $dev)
                                        <option value="{{$dev->name}}">{{$dev->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="btn-group">
                                <label for="select-test">测试</label>
                                <select class="form-control" id="select-test" name="test">
                                    @foreach($testers as $test)
                                        <option value="{{$test->name}}">{{$test->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="btn-group">
                                <label for="select-status">状态</label>
                                <select class="form-control" id="select-status" name="status">
                                    @foreach(Config('params.task_status') as $key=>$value)
                                        @if($key<4)
                                        <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select-date">预计完成日期</label>
                            <input type="text" name="date" id="select-date" class="form-control" placeholder="选择日期" data-toggle="datepicker" data-rule-required="true" data-rule-date="true">
                        </div>
                        <div class="form-group">
                            <label for="package_name">更新包名称</label>
                            <input type="text" id="package_name" class="form-control" value="" placeholder="更新包名称">
                        </div>

                        <div class="form-group">
                            <label for="select-date">备注/总结</label>
                            <textarea id="comment" class="form-control" rows="3" placeholder="请输入.." name="comment"></textarea>
                        </div>
                    </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-primary" id="btnSubmit">
                        确定
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example').dataTable( {
            lengthMenu: [15,30, 50, 100],//这里也可以设置分页，但是不能设置具体内容，只能是一维或二维数组的方式，所以推荐下面language里面的写法。
            paging: true,//分页
            ordering: true,//是否启用排序
            searching: true,//搜索
            language: {
                lengthMenu: '每页<select class="form-control input-xsmall">' + '<option value="15">15</option>' +  '<option value="30">30</option>' + '<option value="50">50</option>' + '<option value="100">100</option>' + '</select>条记录',//左上角的分页大小显示。
                search: '搜索：',//右上角的搜索文本，可以写html标签

                paginate: {//分页的样式内容。
                    previous: "上一页",
                    next: "下一页",
                    first: "第一页",
                    last: "最后"
                },

                zeroRecords: "没有内容",//table tbody内容为空时，tbody的内容。
                //下面三者构成了总体的左下角的内容。
                info: "总共_PAGES_ 页，显示第_START_ 到第 _END_ ，筛选之后得到 _TOTAL_ 条，初始_MAX_ 条 ",//左下角的信息显示，大写的词为关键字。
                infoEmpty: "0条记录",//筛选为空时左下角的显示。
                infoFiltered: ""//筛选之后的左下角筛选提示，
            },
        } );

        $('#example tbody').on('click', 'tr', function () {
            var data = $('#example').DataTable().row( this ).data();;
            console.log($(this).attr('rel'));
            $.ajax({
                type:'GET',
                url:'/task/get_details/'+ $(this).attr('rel'),
                dataType:'json',
                success:function(data){
//                    console.info(data);
                    var my_model=$('#myModal');
                    my_model.find('.modal-title').text(data[0].task_title);
                    my_model.find('.modal-title').append($("<a></a>").attr("href","#").text("[" + data[0].task_no + "]"));
                    my_model.find('#select-date').val(data[0].actual_finish_date);
                    my_model.find('#task_id').val(data[0].id);
                    my_model.find('#comment').val(data[0].comment);
                    var thisTime=(new Date()).getFullYear() +""+ ((new Date()).getMonth()+1)+(new Date()).getDate();;
                    my_model.find('#package_name').val(data[0].customer_name+"工作流("+data[0].task_no+")_" + thisTime + "第一次");
                    $.each($("#select-dev option"),function(n,value){
                        if(value.text==data[0].dev){$(value).attr("selected","selected");}
                    });
                    $.each($("#select-test option"),function(n,value){
                        if(value.text==data[0].test){$(value).attr("selected","selected");}
                    });
                    $.each($("#select-status option"),function(n,value){
                        if(value.value==data[0].status){$(value).attr("selected","selected");}
                    });
                    my_model.find(".modal-title a").click(function(){oprViewOnEKP(data[0].task_no)});
                    my_model.modal('toggle');
                }
            });
        } );

        //模态窗口按钮提交事件
        $("#btnSubmit").unbind('click').bind('click',function(){
            var modal_form=$("#form_task");
            modal_form.submit();
        });

        //标记按钮事件绑定
        $("span[name='chk_finish']").parent().unbind('click').bind('click',function(){
//           alert( $(this).find("span:eq(0)").attr("rel"));
            var this_sapn=$(this).find("span:eq(0)");
            if(this_sapn.attr("status") == "2"){
                var value=confirm('确定要将**任务标记完成吗？');
                if(!value)return false;
            }
            $.ajax({
                type:'GET',
                url:'/task/fast_handle/'+this_sapn.attr("rel"),
                dataType:'json',
                success:function() {
                    location.reload();
                },
                error:function(){
                   location.reload();
                }
            });
            return false;
        });

        $("a[name='view_on_erp']").unbind('click').bind('click',function(){
//            console.info($(this).attr("rel"));
            oprViewOnEKP($(this).attr("rel"));
            return false;
        });

        //sync_task
        $("a[name='sync_task']").unbind('click').bind("click", function () {
            $.ajax({
                type:'GET',
                url:'/task/sync_task/',
                dataType:'json',
                success:function(data) {
                    alert("本次同步"+data+"条任务。")
                    location.reload();
                },
                error:function(){
                    location.reload();
                }
            });
        });

    } );
function oprViewOnEKP(obj)
{
    $.ajax({
        type:'GET',
        url:'/task/view_pd/'+obj,
        success:function(data) {
            console.info("http://pd.mysoft.net.cn"+data);
            window.open("http://pd.mysoft.net.cn"+data) ;
        },
        error:function(data){
            console.info(data);
        }
        });
}
</script>
@stop