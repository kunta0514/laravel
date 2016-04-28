@extends('templates.default')
@section('content')
    <style type="text/css">
        .query-form
        {
            width: 100%;
            height: 35px;
        }
        .query-form ul li
        {
            list-style: none;
            float: left;
            margin-right: 5px;
            line-height: inherit;
            vertical-align: middle;
        }
    </style>
    <div class="container">
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
                <div class="pull-right">
                    <a href="javascript:;" class="btn btn-default"><i class="glyphicon glyphicon-refresh"></i></a>
                </div>
            </div>
        </div>

        <div class="list">
            <table class="table table-bordered table-hover" id="example">
                <thead>
                <tr>
                    {{--<th title="ID" style="width: 15px">#</th>--}}
                    <th style="width: 100px">任务编号</th>
                    <th >任务标题</th>
                    <th style="width: 80px">客户</th>
                    <th style="width: 50px">PM</th>
                    <th style="width: 50px">开发</th>
                    <th style="width: 50px">测试</th>
                    {{--<th style="width: 100px">完成时间</th>--}}
                </tr>
                </thead>
                <tbody>

                {{--@foreach($tasks as $k=>$task)--}}
                    {{--<tr rel="{{$task->id}}" >--}}
                        {{--<th scope="row" >{{$k+1}}</th>--}}
                        {{--<td><a href="#" name="view_on_erp" rel="{{$task->task_no}}">{{$task->task_no}}</a></td>--}}
                        {{--<td class="details" rel={{$task->id}} data-toggle="tooltip" data-placement="top" title="{{$task->task_title}}">--}}
                            {{--<a href="{{URL('task/get_details')}}/{{$task->id}}"></a>@if(mb_strlen($task->task_title)>23) {{mb_substr($task->task_title,0,23)}}...@else {{$task->task_title}} @endif--}}
                        {{--</td>--}}
                        {{--<td>{{$task->customer_name}}</td>--}}
                        {{--<td>{{$task->abu_pm}}</td>--}}
                        {{--<td class="@if($task->status=='1')or_doing @endif">{{$task->dev}}</td>--}}
                        {{--<td class="@if($task->status=='2')or_doing @endif">{{$task->test}}</td>--}}
                        {{--                <td>@if($task->actual_finish_date) {{substr($task->actual_finish_date,0,10)}} @endif</td>deadline--}}
                        {{--<td>{{ $task->actual_finish_date}}</td>--}}
                    {{--</tr>--}}
                {{--@endforeach--}}
                </tbody>
            </table>
        </div>
    </div>


    <script type="text/javascript">
        var tt = $('#example').DataTable({
                lengthMenu: [15, 30, 50, 100],//这里也可以设置分页，但是不能设置具体内容，只能是一维或二维数组的方式，所以推荐下面language里面的写法。
                paging: false,//分页
                ordering: true,//是否启用排序
//                searching: true,//搜索
                dom: "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                language: {
                    lengthMenu: '每页<select class="form-control input-xsmall">' + '<option value="15">15</option>' + '<option value="30">30</option>' + '<option value="50">50</option>' + '<option value="100">100</option>' + '</select>条记录',//左上角的分页大小显示。
                    search: '搜索：',//右上角的搜索文本，可以写html标签
                    paginate: {//分页的样式内容。
                        previous: "上一页",
                        next: "下一页",
                        first: "第一页",
                        last: "最后"
                    },

                    zeroRecords: "没有找到相关内容",//table tbody内容为空时，tbody的内容。
                    //下面三者构成了总体的左下角的内容。
                    info: "总共_PAGES_ 页，显示第_START_ 到第 _END_ ，筛选之后得到 _TOTAL_ 条，初始_MAX_ 条 ",//左下角的信息显示，大写的词为关键字。
                    infoEmpty: "0条记录",//筛选为空时左下角的显示。
                    infoFiltered: ""//筛选之后的左下角筛选提示，
                },
                showRowNumber:true,
//                deferRender:true,
                processing:true,
                serverSide:true,
//                deferLoading:15,
                ajax:{
                    url:"/task/query_task",
                    data:function(d){
//                        console.log(d);
                        return d;
                    },
                    dataSrc:function(json){
//                        console.log(json);
                        //获取数据源后绑定行事件？
                        return json.data
                    }
                },
                columns: [
//                    { "data": "id" },
                    { "data": "task_no" },
                    { "data": "task_title" },
                    { "data": "customer_name" },
                    { "data": "abu_pm" },
                    { "data": "developer" },
                    { "data": "tester" },
//                    { "data": "actual_finish_date" }
                ]
            });



        $(document).on("keypress", '.search-form[type="search"]', function (e) {
            if (e.keyCode == "13") {
                keyword = $(this).val();
                tt.search(keyword).draw();
            }
        });

        $(document).on("click", ".btn-search", function (e) {
            keyword = $('.search-form[type="search"]').val();
            tt.search(keyword).draw();
        });

        $(document).on('click', '#example tr', function () {
            var data = tt.row(this).data();
//            if ($(this).hasClass('selected')) {
//                $(this).removeClass('selected');
//            }else{
//                $(this).addClass('selected');
//            }
//            console.log(data.id);
            $.modal({
                keyboard: false,
                width:598,
                minHeight:233,
                remote: '/task/detail/' + data.id,
                okHide: function () {
                    return true;
                }
            })

//            $.ajax({
//                type:'GET',
//                url:'/task/get_details/'+ $(this).attr('rel'),
//                dataType:'json',
//                success:function(data){
//                    var my_model=$('#myModal');
//                    my_model.find('.modal-title').text(data.task_title);
//                    my_model.find('.modal-title').append($("<a></a>").attr("href","#").text("[" + data.task_no + "]"));
//                    my_model.find('#select-date').val(data.ekp_expect);
//                    my_model.find('#task_id').val(data.id);
//                    my_model.find('#comment').val(data.comment);
//                    my_model.find('#package_name').val(getPageNameString(data));
//                    $.each($("#select-dev option"),function(n,value){
//                        if($(value).val()==data.dev){$(value).attr("selected","selected");}
//                    });
//                    $.each($("#select-test option"),function(n,value){
//                        if($(value).val()==data.test || (data.test=="" && $(value).val()=="请选择")){$(value).attr("selected","selected");}
//                    });
//                    $.each($("#select-status option"),function(n,value){
//                        if(value.value==data.status){$(value).attr("selected","selected");}
//                    });
//                    my_model.find(".modal-title a").click(function(){oprViewOnEKP(data.task_no)});
//                    my_model.modal('toggle');
//                }
//            });
        } );

//        $(document).on("click", ".btn-refresh", function () {
//            tt.search('').draw();
//        });


    </script>
    {{--<button id="btn">click</button>--}}
    {{--<script type="text/javascript">--}}
        {{--function $(str){--}}
            {{--return document.getElementById(str)--}}
        {{--}--}}
        {{--function CreateScript(src) {--}}
            {{--var Scrip=document.createElement('script');--}}
            {{--Scrip.src=src;--}}
            {{--document.body.appendChild(Scrip);--}}
        {{--}--}}
        {{--function jsonpcallback(json) {--}}
            {{--console.log(json);//Object { email="中国", email2="中国222"}--}}
        {{--}--}}
        {{--$('btn').onclick=function(){--}}
            {{--CreateScript("http://61.144.36.122:9000/TaxHttpService/tax_openCard?callback=jsonpcallback")--}}
        {{--}--}}
    {{--</script>--}}

@stop