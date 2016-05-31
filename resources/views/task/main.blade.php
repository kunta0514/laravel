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


<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="input-group pull-left">
                <form onsubmit="return false;">
                    <input type="search" class="form-control search-form" placeholder="输入需求编号、客户名称、需求标题">
                </form>
                    <span class="input-group-btn">
                        <button class="btn btn-default btn-search" type="button"><i class="glyphicon glyphicon-search"></i></button>
                    </span>
            </div>
        </div>
        <div class="col-md-8">
            <div class="pull-right" >
                <a href="#" class="btn btn-default" name="sync_task" title="同步任务系统"><i class="glyphicon glyphicon-indent-right"></i>&nbsp;&nbsp;同步</a>
            </div>
        </div>
    </div>

    <div class="list">
        <table class="table table-bordered table-hover" id="example">
            <thead>
                <tr>
                    <th title="序号">#</th>
                    <th style="min-width: 80px;">任务编号</th>
                    <th style="width: 60px">状态</th>
                    <th >任务标题</th>
                    <th style="width: 80px">客户</th>
                    <th style="width: 60px">PM</th>
                    <th style="width: 80px">开发</th>
                    <th style="width: 80px">测试</th>
                    <th style="width: 80px">期望完成</th>
                    <th style="width: 300px">备注</th>
                    {{--<th></th>--}}
                </tr>
            </thead>
            <tbody>
              @foreach($tasks as $k=>$task)
                  <tr rel="{{$task->id}}" >
                      <th scope="row" >{{$k+1}}</th>
                      <td><a href="#" name="view_on_erp" rel="{{$task->ekp_oid}}">{{$task->task_no}}</a></td>
                      <td>
                          {{ Config('params.task_status')[$task->status] }}
                      </td>
                      <td data-toggle="tooltip" data-placement="top" title="{{$task->task_title}}">
                          @if(stristr($task->ekp_task_type, 'BUG'))
                              <span class="label label-danger">B</span>
                          @elseif(stristr($task->ekp_task_type, '咨询'))
                              <span class="label label-info">咨</span>
                          @elseif(stristr($task->ekp_task_type, '需求'))
                              <span class="label label-success">需</span>
                          @else
                              <span class="label label-primary">{{mb_substr($task->ekp_task_type,0,1)}}</span>
                          @endif
                          {{$task->task_title}}
                      </td>
                      <td>{{$task->customer_name}}</td>
                      <td>{{$task->abu_pm}}</td>
                      <td class="@if($task->status=='1')or_doing @endif">{!! UserHelper::user_name($task->developer) !!}({{$task->developer_workload}})</td>
                      <td class="@if($task->status=='2')or_doing @endif">{!! UserHelper::user_name($task->tester) !!}({{$task->tester_workload}})</td>
                      <td>@if($task->ekp_expect) {{substr($task->ekp_expect,0,10)}} @endif</td>
                      <td>{{$task->comment}}</td>
                      {{--<td>--}}
                          {{--<span name="chk_finish" data-toggle="tooltip" data-placement="top"--}}
                                {{--class="glyphicon chk_finish @if($task->status == 1) glyphicon-pushpin @elseif($task->status == 2) glyphicon-check @else glyphicon-flag @endif"--}}
                                {{--title="标记为{{config('params.task_status')[$task->status+1] }}..." rel="{{$task->id}}" status="{{$task->status}}">--}}
                          {{--</span>--}}
                      {{--</td>--}}
                  </tr>
              @endforeach
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        var tt = $('#example').dataTable( {
            lengthMenu: [50, 100, "ALL"],//这里也可以设置分页，但是不能设置具体内容，只能是一维或二维数组的方式，所以推荐下面language里面的写法。
            paging: false,//分页
            ordering: true,//是否启用排序
            order: [ [ 0, 'desc' ]],
//                searching: true,//搜索
            dom: "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
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
            }
        });

        $(document).on('click', '#example tbody tr', function () {
            var data = $(this);
            $.modal({
                keyboard: false,
                width:598,
                minHeight:233,
                remote: '/task/detail/' + data.attr("rel"),
                okHide: function () {
                    location.reload();
                }
            })
        } );


        //标记按钮事件绑定
//        $("span[name='chk_finish']").parent().unbind('click').bind('click',function(){
//            var this_sapn=$(this).find("span:eq(0)");
//            if(this_sapn.attr("status") == "2"){
//                var value=confirm('确定要将**任务标记完成吗？');
//                if(!value)return false;
//            }
//            $.ajax({
//                type:'GET',
//                url:'/task/fast_handle/'+this_sapn.attr("rel"),
//                dataType:'json',
//                success:function() {
//                    location.reload();
//                },
//                error:function(){
//                   location.reload();
//                }
//            });
//            return false;
//        });

        $('#example tbody').on('click',"td a[name='view_on_erp']",function(e){
            e.stopPropagation();
            e.preventDefault();
            oprViewOnEKP(this);
        });

        //sync_task
        $("a[name='sync_task']").unbind('click').bind("click", function () {
            $.ajax({
                type:'GET',
                url:'/task/sync_task/',
                dataType:'json',
                success:function(data) {
                    $.toast("同步成功,本次同步"+data+"个任务","success");
                    if(data == 0){

                    }else {
                        location.reload();
                    }
                },
                error:function(){
                    $.toast("同步失败，请检查日志","error");
                }
            });
        });

    //自动同步
     setInterval(function(){
       $.ajax({
           type:'GET',
           url:'/task/sync_task/'
         });
     },1000*60*5);
        } );

    function oprViewOnEKP(obj) {
        if ($(obj).attr("rel") != "") {
            window.open("http://pd.mysoft.net.cn" + $(obj).attr("rel"));
        }
//        else {
//            $.ajax({
//                type: 'GET',
//                url: '/task/view_pd/' + $(obj).attr("rel"),
//                success: function (data) {
//                    window.open("http://pd.mysoft.net.cn" + data);
//                },
//                error: function (data) {
//                    console.info(data);
//                }
//            });
//        }
    }
</script>
@stop
