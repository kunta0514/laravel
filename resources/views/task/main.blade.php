@extends('templates.default')
@section('content')



<div class="container">
    {{--<div class="divtab">--}}
        {{--<ul class="nav nav-tabs" id="myTab">--}}
            {{--@foreach(config('params.task_tabs') as $k=>$val)--}}
                {{--<li><a href="#" status={{$k}} data-toggle="tab">{{$val}}</a></li>--}}
            {{--@endforeach--}}
        {{--</ul>--}}
    {{--</div>--}}
    <table class="table table-bordered table-hover" id="example">
        <thead>
            <tr>
                <th title="序号">#</th>
                <th>任务编号</th>
                <th >任务标题</th>
                <th style="width: 60px">客户</th>
                <th style="min-width: 60px">PM</th>
                <th style="min-width: 60px">开发</th>
                <th style="min-width: 60px">测试</th>
                {{--<th>交付时间</th>--}}
                {{--<th>备注</th>--}}
                <th><span class="glyphicon glyphicon-pencil" title="标记"></span></th>
            </tr>
        </thead>
        <tbody>

        @foreach($tasks as $k=>$task)
            <tr rel="{{$task->id}}">
                <th scope="row">{{$k+1}}</th>
                <td><a href="#" name="view_on_erp" rel="{{$task->ekp_oid}}">{{$task->task_no}}</a></td>
                <td class="details" rel={{$task->id}} data-toggle="tooltip" data-placement="top" title="{{$task->task_title}}">
                    @if(mb_strlen($task->task_title)>23) {{mb_substr($task->task_title,0,23)}}...@else {{$task->task_title}} @endif
                </td>
                <td>{{$task->customer_name}}</td>
                <td>{{$task->abu_pm}}</td>
                <td class="@if($task->status=='1')dev_doing @endif">{{$task->test}}</td>
                <td class="@if($task->status=='2')test_doing @endif">{{$task->dev}}</td>
                {{--<td>@if($task->ekp_expect) {{substr($task->ekp_expect,0,10)}} @endif</td>--}}
                {{--<td data-toggle="tooltip" data-placement="top" title="{{$task->comment}}" class="details">--}}
                    {{--@if(mb_strlen($task->comment)>10) {{mb_substr($task->comment,0,10)}}...@else {{$task->comment}} @endif--}}
                {{--</td>--}}
                <td>
                    <span name="chk_finish" data-toggle="tooltip" data-placement="top" class="glyphicon glyphicon-ok-circle chk_finish"
                          title="标记为{{config('params.task_status')[$task->status+1] }}..." onclick="onMarks('{{$task->id}}')">

                    </span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    <input type="hidden" id="task_status" value="{{$task_status}}">
    <div class="modal fade fixed" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">【深业置地】工作流管理审批是多次转发时对应的审批记录未回填至表单</h4>
                </div>

                <div class="modal-body">
                    <form method="post" action="{{ URL('task/edit') }}" role="form" id="form_task">
                        {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                        {{--<input type="hidden" name="task_id" id="task_id" value="">--}}
                        <div class="form-group">
                            <div class="btn-group">
                                <label for="select-dev">开发</label>
                                <select class="form-control" id="select-dev">
                                    @foreach($developers as $dev)
                                        <option value="{{$dev->code}}">{{$dev->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="btn-group">
                                <label for="select-test">测试</label>
                                <select class="form-control" id="select-test" >
                                    @foreach($testers as $test)
                                        <option value="{{$test->code}}">{{$test->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select-date">截止日期</label>
                            <input type="text" name="date" id="select-date" class="form-control" placeholder="选择日期" data-toggle="datepicker" data-rule-required="true" data-rule-date="true">
                        </div>

                        <div class="form-group">
                            <label for="select-date">备注/总结</label>
                            <textarea id="comment" class="form-control" rows="3" placeholder="请输入.."></textarea>
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
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example').dataTable( {
            lengthMenu: [30, 50, 100],//这里也可以设置分页，但是不能设置具体内容，只能是一维或二维数组的方式，所以推荐下面language里面的写法。
            paging: true,//分页
            ordering: true,//是否启用排序
            searching: true,//搜索
            language: {
                lengthMenu: '每页<select class="form-control input-xsmall">' + '<option value="30">30</option>' + '<option value="50">50</option>' + '<option value="100">100</option>' + '</select>条记录',//左上角的分页大小显示。
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
                    console.info(data);
                    $('#myModal').modal('toggle');
                }
            });
        } );

    } );

//
//    $(function() {
//        $.datepicker.regional["zh-CN"] = { closeText: "关闭", prevText: "&#x3c;上月", nextText: "下月&#x3e;", currentText: "今天", monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"], monthNamesShort: ["一", "二", "三", "四", "五", "六", "七", "八", "九", "十", "十一", "十二"], dayNames: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"], dayNamesShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六"], dayNamesMin: ["日", "一", "二", "三", "四", "五", "六"], weekHeader: "周", dateFormat: "yy-mm-dd", firstDay: 1, isRTL: !1, showMonthAfterYear: !0, yearSuffix: "年" }
//        $.datepicker.setDefaults($.datepicker.regional["zh-CN"]);
//        var datePicker = $("#ctl00_BodyMain_txtDate").datepicker({
//            showOtherMonths: true,
//            selectOtherMonths: true
//        });
//        $( "#task_expect" ).datepicker();
//        //tabs //这里实现点击tab切换逻辑
//        $('#myTab a').click(function (e) {
//            e.preventDefault();
//            if ($(this).parent().hasClass('active')) return;
//            $('#myTab li').removeClass('active');
//            $(this).parent().addClass('active');
//            $(this).tab('show');
//            window.location.href='/task/' + $(this).attr("status");
//        });
//
//        //绑定点击任务编号事件
//        $("td a[name='view_on_erp']").click(function(){
//            var url="http://pd.mysoft.net.cn/Requirement/Detail.aspx?oid="+$(this).attr('rel');
//            window.open(url);
//        });
//
//        //tabs 初始化
//        $('#myTab a[status='+$('#task_status').val()+']').tab('show');
//    });
//
//    $('.details').on('click',function(){
//        //1.根据ID获取详细（get）
//        $.ajax({
//            type:'GET',
//            url:'/task/get_details/'+ $(this).attr('rel'),
//            dataType:'json',
//            success:function(data){
//                console.info(data);
//
//                $('#task-no').val(data.task.task_no);
//                $('#task-title').val(data.task.task_title);
//                $('#myModalLabel').html(data.task.task_title+"<small> [<a href='#' onclick=oprViewOnEKP("+"'"+data.task.ekp_oid+"')>"+data.task.task_no+"</a>]</small>");
//                $("#task_id").val(data.task.id);
//                $("#remark").val(data.task.comment);
//                var ekp_expect;
//                if(data.task.ekp_expect)
//                {
//                    ekp_expect=data.task.ekp_expect.substr(0,10);
//                }
//                $("#task_expect").val(ekp_expect);//截至日期
////
//                //绑定数据到select
//                var devors= $.grep(data.user_list,function(value,n){
//                    return value.user_role=="0";
//                });
//                var testors= $.grep(data.user_list,function(value,n){
//                    return value.user_role=="1";
//                });
//
//                var curdevor= $.grep(data.workload,function(value,n){
//                    return value.work_type=="1";
//                });
//                var curtestors= $.grep(data.workload,function(value,n){
//                    return value.work_type=="0";
//                });
//
//                var curdevor_id,curtestor_id;
//                if(curdevor.length>0)
//                {
//                    curdevor_id=curdevor[0].user_id;
//                }
//                if(curtestors.length>0)
//                {
//                    curtestor_id=curtestors[0].user_id;
//                }
//
//                binddata2select('sel_dev',devors,curdevor_id);
//                binddata2select('sel_test',testors,curtestor_id);
//                //绑定数据到select
//
//                if (curdevor_id)
//                {
//                    $("#sel_dev_name").val(curdevor[0].user_name);
//                }
//                if (curtestor_id)
//                {
//                    $("#sel_test_name").val(curtestors[0].user_name);
//                }
//
//                //任务状态
//                $("#sel_task_status option[value='" + data.task.status + "']:eq(0)").attr('selected','selected');
//
//
//                $('#myModal').modal('toggle');
//                //http://v3.bootcss.com/javascript/#modals
//            }
//        });
//        //2.清理modal缓存，再赋值
////            $('#myModal').modal('show')
//        //3.绑定保存事件
//
//
//        //绑定下拉框事件
//        $("#sel_dev").change(function(){
//            var name=($(this).children('option:selected').text()!="请选择")?$(this).children('option:selected').text():"";
//            $("#sel_dev_name").val(name);
//        });
//        $("#sel_test").change(function(){
//            var name=($(this).children('option:selected').text()!="请选择")?$(this).children('option:selected').text():"";
//            $("#sel_test_name").val(name);
//        });
//    });
//
//
//    //        标记任务
//    function onMarks(id)
//    {
//        $.get(
//                '/task/fast_handle/'+id,
//                function(data){
//                    if (data!='ok')
//                    {
//                        alert('处理失败了,你可以找管理员麻烦喽!');
//                    }else {
//                        window.location.href=window.location.href;
//                    }
//                }
//        );
//    }
//    //        标记任务
//
//    //打开EKP的任务详情
//    function oprViewOnEKP(taskid)
//    {
//        var url="http://pd.mysoft.net.cn/Requirement/Detail.aspx?oid="+taskid;
//        window.open(url);
//    }
//    //        打开EKP的任务详情
//
//    //        提交任务
//    function oprEditTask()
//    {
//        $("#form_task").submit();
//    }
//    //        提交任务
//
//    //        绑定数据到select
//    function binddata2select(selectid,data,defaultkey)
//    {
//        if(selectid==undefined || selectid=="" || data==undefined || data==null || data=="")return;
//        if ($("#" + selectid))
//        {
//            var curselect=$("#"+ selectid);
//            var isselected="";
//            curselect.empty();
//            curselect.append("<option value='' selected>请选择</option>");
//            $.each(data,function(n,value)
//            {
//                if(value.key==defaultkey)
//                    isselected="selected";
//                curselect.append("<option value='"+ value.key +"'" + isselected + ">" + value.text + "</option>");
//                isselected="";
//            });
//        }
//    }
    //        绑定数据到select
</script>
@stop