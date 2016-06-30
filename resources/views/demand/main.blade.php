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
        tr{
            cursor: pointer;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group pull-left">
                            <form onsubmit="return false;">
                                <input type="search" class="form-control search-form" name="demand" placeholder="输入需求相关信息">
                            </form>
                    <span class="input-group-btn">
                        <button class="btn btn-default btn-search" name="demand" type="button"><i class="glyphicon glyphicon-search"></i></button>
                    </span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="pull-right">
                            <a href="#" class="btn btn-default" id="demand-add"><i class="glyphicon glyphicon-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="list">
                    <table class="table table-bordered table-hover" id="tb_demand">
                        <thead>
                        <tr>
                            <th style="width: 100px">需求编号</th>
                            <th >PRI</th>
                            <th style="width: 60px">状态</th>
                            <th >需求</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group pull-left">
                            <form onsubmit="return false;">
                                <input type="search" class="form-control search-form" name="task" placeholder="输入任务相关信息">
                            </form>
                    <span class="input-group-btn">
                        <button class="btn btn-default btn-search" name="task" type="button"><i class="glyphicon glyphicon-search"></i></button>
                    </span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="pull-right">
                            <a href="#" class="btn btn-default" id="export"><i class="glyphicon glyphicon-export"></i></a>
                        </div>
                    </div>
                </div>
                <div class="list">
                    <table class="table table-bordered table-hover" id="tb_task">
                        <thead>
                        <tr>
                            <th style="width: 100px">任务编号</th>
                            <th >PRI</th>
                            <th style="width: 60px">状态</th>
                            <th >任务</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        var page_data=<?= $page_data ?>;
        var tb_demand = $('#tb_demand').DataTable({
            ajax:'/demand/get_todoList',
            columns:[
                {'data':"demand_no"},
                {'data':"PRI"},
                {'data':"status"},
                {'data':"demand_name"}
            ],
            "columnDefs": [
                {
                    "render": function(data, type, row, meta) {
                        return page_data.task_status[data];
                },
                    "targets": 2
                },
                    ],
            createdRow: function ( row, data, index ) {
                $(row).attr("rel",data.id).attr("data-toggle","tooltip").attr("data-placement","top").attr("title",data.demand_name);
            },

            lengthMenu: [50, 100, "ALL"],//这里也可以设置分页，但是不能设置具体内容，只能是一维或二维数组的方式，所以推荐下面language里面的写法。
            paging: false,//分页
            ordering: true,//是否启用排序
            order: [ [ 0, 'desc' ]],
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
            bAutoWidth:false,
        });

        $(document).on('click', '#tb_demand tbody tr', function () {
//            console.log($(this).attr('rel'));
            $.modal({
                keyboard: true,
                width:598,
                minHeight:400,
                remote: '/demand/edit/' + $(this).attr('rel'),
                okHide: function () {
                    tb_demand.ajax.reload();
                }
            })
        } );

        $(document).on('click','#demand-add',function(){
            $.modal({
                keyboard: true,
                width:598,
                minHeight:400,
                remote: '/demand/create',
                okHide: function () {
                    tb_demand.ajax.reload();
                }
            })
        });

        $(document).on("keypress", '.search-form[name="demand"]', function (e) {
            if (e.keyCode == "13") {
                var keyword = $(this).val();
//                if(keyword === '') {
//                    $.toast("请输入查找内容","info");
//                    return false;
//                }
                tb_demand.search(keyword).draw();
            }
        });

        $(document).on("click", '.btn-search[name="demand"]', function (e) {
            var keyword = $('.search-form[type="search"]').val();
            if(keyword === '') {
                $.toast("请输入查找内容","info");
                return false;
            }
            tb_demand.search(keyword).draw();
        });

        var tb_task = $('#tb_task').DataTable({
            ajax:'/task/get_todoList',
            columns:[
                {'data':"task_no"},
                {'data':"PRI"},
                {'data':"status"},
                {'data':"task_title"}
            ],
            "columnDefs": [
                {
//                "visible": false,
//                "targets": [10]
                },
                {
                    "render": function(data, type, row, meta) {
                        return '<a name="view_on_erp" rel="' + row.ekp_oid + '" target="_blank">' + data + '</a>';
                    },
                    "targets": 0
                },
                {
                    "render": function(data, type, row, meta) {
                        return page_data.task_status[data];
                    },
                    "targets": 2
                },
                {
                    "render": function(data, type, row, meta) {
                        switch (row.ekp_task_type){
                            case "需求":
                            case "升级-零星需求-一般":
                            case "开发类-零星需求-一般":
                                return '<span class="label label-success">需</span>' + data + '</a>';
                                break;
                            case "BUG":
                            case "产品BUG":
                            case "升级-BUG修改-一般":
                            case "升级-BUG修改-紧急":
                                return '<span class="label label-danger">B</span>' + data + '</a>';
                            case "升级-咨询评估":
                                return '<span class="label label-info">咨</span>' + data + '</a>';
                            default:
                                return '<span class="label label-primary">'+row.ekp_task_type.substring(0,1)+'</span>' + data + '</a>';
                        }
                    },
                    "targets": 3
                },
            ],
            "createdRow": function ( row, data, index ) {
                $(row).attr("rel",data.id);
            },
            lengthMenu: [15,30,45,60,75,90,"ALL"],//这里也可以设置分页，但是不能设置具体内容，只能是一维或二维数组的方式，所以推荐下面language里面的写法。
            paging: false,//分页
            ordering: true,//是否启用排序
//        order: [ [ 0, 'asc' ]],
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
            bAutoWidth:false,
        });

        $(document).on('click', '#tb_task tbody tr', function () {
            $.modal({
                keyboard: true,
                width:598,
                minHeight:518,
                remote: '/task/edit/' + $(this).attr('rel'),
                okHide: function () {
                    tb_task.ajax.reload();
                }
            })
        } );

        $('#tb_task tbody').on('click',"td a[name='view_on_erp']",function(e){
            e.stopPropagation();
            e.preventDefault();
            if ($(this).attr("rel") != "") {
                window.open("http://pd.mysoft.net.cn" + $(this).attr("rel"));
            }
        });

        $(document).on("keypress", '.search-form[name="task"]', function (e) {
            if (e.keyCode == "13") {
                var keyword = $(this).val();
//                if(keyword === '') {
//                    $.toast("请输入查找内容","info");
//                    return false;
//                }
                tb_task.search(keyword).draw();
            }
        });

        $(document).on("click", '.btn-search[name="task"]', function (e) {
            var keyword = $('.search-form[name="task"]').val();
            if(keyword === '') {
                $.toast("请输入查找内容","info");
                return false;
            }
            tb_task.search(keyword).draw();
        });
    </script>


@stop