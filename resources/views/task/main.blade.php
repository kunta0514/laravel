@extends('templates.default')
@section('content')

<style type="text/css">
        .detail-white-card {
            overflow: hidden;
            background-color: #fff;
            border: 1px solid rgba(0,0,0,.1);
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
        }
        .task-detail-handler-set {
            display: -moz-box;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flexbox;
            display: -ms-flex;
            display: flex;
        }
        .task-detail-handler-set .task-detail-handler.on-flex {
            min-width: 25%;
            max-width: 36%;
            width: inherit;
            -webkit-box-flex: 0;
            -moz-box-flex: 0;
            -webkit-flex: 0 0 auto;
            -moz-flex: 0 0 auto;
            -ms-flex: 0 0 auto;
            flex: 0 0 auto;
        }

        .task-detail-handler-set .task-detail-handler {
            position: relative;
            width: 25%;
            border-right: 1px solid rgba(0,0,0,.05);
            white-space: nowrap;
            overflow: hidden;
        }

         .task-detail-handler-set .task-detail-handler:last-child {
            border-right: 0 none;
        }
        .task-detail-handler-set .task-detail-handler {
            position: relative;
            width: 25%;
            border-right: 1px solid rgba(0,0,0,.05);
            white-space: nowrap;
            overflow: hidden;
        }
        .task-info-title {
            margin: 16px 16px 0;
            line-height: 12px;
            color: grey;
            font-family: inherit;
            font-weight: 500;
        }
        .task-detail-executor {
            margin: 10px 16px 14px;
            line-height: 24px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .task-detail-handler-body{
            position: relative;
            display: block;
            margin: 12px 16px 16px;
            color: #383838;
            vertical-align: middle;
        }
        .task-detail-priority {
            margin-left: 15px!important;
        }

        .task-detail-handler-set .task-detail-handler .task-detail-handler-body, .task-detail .task-detail-handler-set .task-detail-handler>a, .task-detail .task-detail-handler-set .task-detail-handler>span {
            position: relative;
            display: block;
            margin: 12px 16px 16px;
            color: #383838;
            vertical-align: middle;
        }

        .task-detail-handler-set .task-detail-handler .task-detail-executor {
            margin: 10px 16px 14px;
            line-height: 24px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .task-detail-handler-set .task-detail-handler>a.dirty:hover, .task-detail .task-detail-handler-set .task-detail-handler>a.open, .task-detail .task-detail-handler-set .task-detail-handler>a:hover, .task-detail .task-detail-handler-set .task-detail-handler>a:hover .icon {
            color: #03a9f4;
        }
        .task-detail-handler-set a:hover,a:focus{
            text-decoration: none;
            color: #03a9f4;
            cursor:pointer;
        }
        .task-detail-handler h6{
            margin-bottom: 10px;
        }
        #task_expect{
            width: 85px;
            border: none;
            cursor: pointer;
        }
        #is_sla,.is_sla{
            cursor: pointer;
        }
        #is_sla{
            width: 15px;
            height: 15px;
            vertical-align: top;
        }
        .infolist{
            margin-top: 10px;
            border: 1px solid rgba(0,0,0,.1);
        }
        .infolist textarea{
            border: none;
            width: 95%;
            margin: 0px 0px 0px 14px;
            resize: none;
            min-height: 90px;
            margin-top: 5px;
        }
        .activities-timeline>div:first-child, .activities-timeline>ul:first-child {
            border-top: 1px solid rgba(0,0,0,.1);
            -webkit-border-radius: 3px 3px 0 0;
            -moz-border-radius: 3px 3px 0 0;
            border-radius: 3px 3px 0 0;
        }
        .activities-timeline .activities-timeline-involve-set {
            border-bottom: 1px solid rgba(0,0,0,.05);
        }
        .activities-timeline>div, .activities-timeline>ul {
            margin-right: -1px;
            margin-left: -1px;
            overflow: hidden;
        }
        .activities-timeline, .activities-timeline>div, .activities-timeline>ul {
            background-color: #fff;
            border-right: 1px solid rgba(0,0,0,.1);
            border-left: 1px solid rgba(0,0,0,.1);
        }
        .involve-view {
            position: relative;
        }
        .activities-timeline .activities-timeline-involve-set .involve-view .involve-header {
            margin: 15px 15px 10px;
            font-size: 12px;
            line-height: 12px;
            color: grey;
        }
        .activities-timeline .activities-timeline-involve-set .involve-view .involve-members {
            padding: 0;
            margin: 10px 15px 5px 5px;
        }
        .activities-timeline .activities-timeline-involve-set .involve-view .involve-members>li {
            margin: 0 0 10px 10px;
        }
        .involve-view .involve-members>li {
            position: relative;
            float: left;
            margin: 0 0 10px 10px;
        }
        li {
            list-style: none;
        }
        /*body, h4, h5, li {*/
        /*line-height: 20px;*/
        /*}*/
        .involve-view .involve-members>li>.avatar {
            /* display: block; */
            width: 24px;
            height: 24px;
            -webkit-transition: -webkit-transform 2.11s ease-in-out;
            -o-transition: -webkit-transform 2.11s ease-in-out;
            transition: -webkit-transform 2.11s ease-in-out;
        }
        .avatar {
            background-size: cover!important;
            background-repeat: no-repeat!important;
            background-position: center!important;
        }
        .img-circle {
            border-radius: 50%;
        }
        .details,.details:hover,select,.chk_finlish{
            cursor: pointer;
        }
        .details:hover{
            color: #31708f;
            background-color: #d9edf7;
            border-color: #bce8f1;
        }
    .chk_finlish{
        width: 18px;
        height: 18px;
    }

    </style>
{{--{{ HTML::script('/script/task_index.js')}}--}}
<div class="container">
    <div class="divtab">
        <ul class="nav nav-tabs" id="myTab">
            @foreach(config('params.task_status') as $k=>$val)
                <li><a href="#" status={{$k}} data-toggle="tab">{{$val}}</a></li>
            @endforeach
        </ul>
    </div>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th title="序号">序号</th>
                {{--<th></th>--}}
                <th style="min-width: 120px">任务编号</th>
                <th>任务标题</th>
                <th>客户</th>
                <th style="min-width: 60px">PM</th>
                <th style="min-width: 60px">开发</th>
                <th style="min-width: 60px">测试</th>
                <th>交付时间</th>
                <th>备注</th>
                <th><span class="glyphicon glyphicon-pencil" title="标记"></span></th>
            </tr>
        </thead>
        <tbody>

        @foreach($tasks as $k=>$task)
            <tr>
                <th scope="row">{{$k+1}}</th>
                {{--<td style="padding: 5px 10px;"><input class="chk_finlish" type="checkbox" rel="{{$tasks[$i]->task_id}}" title="标记完成"/></td>--}}
                <td><a href="#" onclick="oprViewOnEKP('{{$task->task_id}}')">{{$task->task_no}}</a></td>
                <td class="details" rel={{$task->id}}>{{$task->task_title}}</td>
                <td>{{$task->customer_name}}</td>
                <td>{{$task->abu_pm}}</td>
                <td></td>
                <td></td>
                <td>@if($task->ekp_expect) {{substr($task->ekp_expect,0,10)}} @endif</td>
                <td data-toggle="tooltip" data-placement="top" title="{{$task->comment}}" class="details">
                    @if(mb_strlen($task->comment)>10) {{mb_substr($task->comment,0,10)}}...@else {{$task->comment}} @endif
                </td>
                <td><span name="chk_finlish" data-toggle="tooltip" data-placement="top" class="glyphicon glyphicon-ok-circle chk_finlish" title="标记" onclick="onMarks('{{$task->id}}')"></span></td>
            </tr>
        @endforeach
        <tr>
            <td colspan="10">
                <?php echo '共有: '.$tasks->total().' 条记录,当前页显示: '.$tasks->count().' 条';?>
            </td>
        </tr>
        </tbody>
    </table>
    {{--分页--}}
    <?php echo $tasks->render(); ?>
    {{--分页--}}
    <!-- Modal -->
    <input type="hidden" id="task_status" value="{{$task_status}}">
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">×
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                    </h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ URL('task/edit') }}" role="form" id="form_task">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="task_id" id="task_id" value="">
                        <div class="row">
                            <div class="col-xs-1">
                            </div>
                            <div class="col-xs-2">
                            </div>
                        </div>
                        <div class="detail-white-card task-detail-handler-wrap">
                            <div class="task-detail-handler-set">
                                <div class="task-detail-handler on-flex">
                                    <h6 class="task-info-title">开发</h6>
                                    <a class="task-detail-executor" >
                                        <input type="hidden" id="sel_dev_name" name="sel_dev_name">
                                        <select name="sel_dev_id" id="sel_dev">
                                            {{--<option value="">请选择</option>--}}
                                            {{--<option value="jijl">季家龙</option>--}}
                                            {{--<option value="shenjl">沈金龙</option>--}}
                                            {{--<option value="zhuangsd">庄少东</option>--}}
                                        </select>
                                     </a>
                                </div>
                                <div class="task-detail-handler on-flex">
                                    <h6 class="task-info-title">测试</h6>
                                    <a class="task-detail-executor" >
                                        <input type="hidden" id="sel_test_name" name="sel_test_name">
                                        <select name="sel_test_id" id="sel_test">
                                            {{--<option value="">请选择</option>--}}
                                            {{--<option value="suib">随波</option>--}}
                                        </select>
                                    </a>
                                </div>
                                <div class="task-detail-handler on-flex">
                                    <h6 class="task-info-title">交付时间点</h6>
                                    <div class="task-detail-handler-body task-detail-due-date dirty">
                                        <a class="task-datepicker">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                            <input type="text" name="task_deadline" id="task_expect" value="" placeholder="选择截止时间"> </a>
                                    </div>
                                </div>
                                {{--<div class="task-detail-handler">--}}
                                    {{--<h6 class="task-info-title">优先级</h6>--}}
                                    {{--<a class="task-detail-priority dirty" >--}}
                                        {{--<span class="glyphicon glyphicon-signal"></span>--}}
                                        {{--<label class="is_sla">--}}
                                            {{--<input type="checkbox" id="is_sla">是否紧急--}}
                                        {{--</label>--}}
                                        {{--<span class="priority-title">是否紧急</span>--}}
                                    {{--</a>--}}
                                {{--</div>--}}
                                <div class="task-detail-handler repeat-menu-wrap">
                                    <h6 class="task-info-title">标记</h6>
                                    <a class="task-detail-repeat dirty task-detail-priority" href="#">
                                        {{--<span class="glyphicon glyphicon-flag"></span>--}}
                                        <select name="sel_task_status" id="sel_task_status">
                                            <option value="-1">请选择</option>
                                            <option value="1">待处理</option>
                                            <option value="2">进行中</option>
                                            <option value="3">已完成</option>
                                        </select>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="infolist">
                            <div class="remark">
                                {{--<span class="glyphicon glyphicon-comment">添加备忘</span>--}}
                                <h6 class="task-info-title">添加备忘</h6>
                                <textarea name="remark" id="remark" class="note-input" data-gta="{action: edit note}" placeholder="添加备忘"></textarea>
                            </div>
                        </div>
                        {{--123--}}
                        {{--<div class="activities-timeline-involve-set ui-droppable">--}}
                            {{--<div class="involve-view">--}}
                                {{--<div class="involve-header">--}}
                                    {{--<span>参与者</span>--}}
                                {{--</div>--}}
                                {{--<ul class="involve-members clearfix">--}}
                                    {{--<li class="involve-member hinted" data-id="56c708339c9c86af7e8e68d8" data-title="Zhuang少东，创建者">--}}
                                        {{--<div class="avatar img-circle" style="background-image:url(https://striker.teambition.net/thumbnail/110dce9e37470df71fa33f1fe0f01c5dd938/w/100/h/100);"></div>--}}
                                    {{--</li>--}}
                                    {{--<li class="involve-member hinted" data-id="56c6e9ee9c9c86af7e8e68a2" data-title="selonsy">--}}
                                        {{--<div class="avatar img-circle" style="background-image:url(https://striker.teambition.net/thumbnail/110dd3489dfbe2c362c8f13e8e503ff7e09a/w/200/h/200);"></div>--}}
                                        {{--<a class="remove-member-handler">×</a>--}}
                                    {{--</li>--}}
                                    {{--<li class="involve-member-add">--}}
                                        {{--<a class="add-involvement-handler clearfix" data-gta="{action: 'set followers'}" data-original-title="" title="">--}}
                                            {{--<span class="icon icon-circle-cross hinted" data-title="添加参与者"></span>--}}
                                        {{--</a>--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--132--}}
                    </form>


                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-primary" onclick="oprEditTask()">
                        确定
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    </div>
</div>


<script type="text/javascript">
    $(function() {
        $.datepicker.regional["zh-CN"] = { closeText: "关闭", prevText: "&#x3c;上月", nextText: "下月&#x3e;", currentText: "今天", monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"], monthNamesShort: ["一", "二", "三", "四", "五", "六", "七", "八", "九", "十", "十一", "十二"], dayNames: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"], dayNamesShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六"], dayNamesMin: ["日", "一", "二", "三", "四", "五", "六"], weekHeader: "周", dateFormat: "yy-mm-dd", firstDay: 1, isRTL: !1, showMonthAfterYear: !0, yearSuffix: "年" }
        $.datepicker.setDefaults($.datepicker.regional["zh-CN"]);

        var datePicker = $("#ctl00_BodyMain_txtDate").datepicker({
            showOtherMonths: true,
            selectOtherMonths: true
        });
        $( "#task_expect" ).datepicker();

        //tabs //这里实现点击tab切换逻辑
        $('#myTab a').click(function (e) {
            e.preventDefault();
            if ($(this).parent().hasClass('active')) return;
            $('#myTab li').removeClass('active');
            $(this).parent().addClass('active');
            $(this).tab('show');

            window.location.href='/task/' + $(this).attr("status");
        });
        init();
    });

    $('.details').on('click',function(){
        //1.根据ID获取详细（get）
//            console.info($(this).attr('rel'));
        $.ajax({
            type:'GET',
            url:'/task/get_details/'+ $(this).attr('rel'),
            dataType:'json',
            success:function(data){
                console.info(data);

                $('#task-no').val(data.task_no);
                $('#task-title').val(data.task_title);
                $('#myModalLabel').html(data.task_title+"<small> [<a href='#' onclick=oprViewOnEKP("+"'"+data.task_id+"')>"+data.task_no+"</a>]</small>");
                $("#task_id").val(data.id);
                $("#remark").val(data.comment);
                var ekp_expect;
                if(data.ekp_expect)
                {
                    ekp_expect=data.ekp_expect.substr(0,10);
                }
                $("#task_expect").val(ekp_expect);//截至日期
//
//                //绑定数据到select
//                var devors= $.grep(data.userlist,function(value,n){
//                    return value.user_type=="开发";
//                });
//                var testors= $.grep(data.userlist,function(value,n){
//                    return value.user_type=="测试";
//                });
//
//                var curdevor= $.grep(data.workload,function(value,n){
//                    return value.work_type=="开发";
//                });
//                var curtestors= $.grep(data.workload,function(value,n){
//                    return value.work_type=="测试";
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


                $('#myModal').modal('toggle');
                //http://v3.bootcss.com/javascript/#modals
            }
        });
        //2.清理modal缓存，再赋值
//            $('#myModal').modal('show')
        //3.绑定保存事件


        //绑定下拉框事件
        $("#sel_dev").change(function(){
            var name=($(this).children('option:selected').text()!="请选择")?$(this).children('option:selected').text():"";
            $("#sel_dev_name").val(name);
        });
        $("#sel_test").change(function(){
            var name=($(this).children('option:selected').text()!="请选择")?$(this).children('option:selected').text():"";
            $("#sel_test_name").val(name);
        });
    });

    function init()
    {
        var tab_taskstatus=$('#task_status').val();
        $('#myTab a[status='+tab_taskstatus+']').tab('show');
        switch(tab_taskstatus)
        {
            case '1':
                $('table tr td span[name="chk_finlish"]').attr('title','标记为进行中...');
                break;
            case '2':
                $('table tr td span[name="chk_finlish"]').attr('title','标记为已完成...');
                break;
            default:
                $('table tr td span[name="chk_finlish"]').attr('title','快速标记不能使用...');
                $('table tr td span[name="chk_finlish"]').attr('onclick','');
                break;
        }
    }

    //        标记任务
    function onMarks(id)
    {
        $.get(
                '/task/fast_handle/'+id,
                function(data){
                    if (data!='ok')
                    {
                        alert('处理失败了,你可以找管理员麻烦喽!');
                    }else {
                        window.location.href=window.location.href;
                    }
                }
        );
    }
    //        标记任务

    //打开EKP的任务详情
    function oprViewOnEKP(taskid)
    {
        var url="http://pd.mysoft.net.cn/Requirement/Detail.aspx?oid="+taskid;
        window.open(url);
    }
    //        打开EKP的任务详情

    //        提交任务
    function oprEditTask()
    {
        $("#form_task").submit();
    }
    //        提交任务

    //        绑定数据到select
    function binddata2select(selectid,data,defaultkey)
    {
        if(selectid==undefined || selectid=="" || data==undefined || data==null || data=="")return;
        if ($("#" + selectid))
        {
            var curselect=$("#"+ selectid);
            var isselected="";
            curselect.empty();
            curselect.append("<option value='' selected>请选择</option>");
            $.each(data,function(n,value)
            {
                if(value.key==defaultkey)
                    isselected="selected";
                curselect.append("<option value='"+ value.key +"'" + isselected + ">" + value.text + "</option>");
                isselected="";
            });
        }
    }
    //        绑定数据到select
</script>
@stop