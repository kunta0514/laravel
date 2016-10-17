@extends('templates.default')
@section('content')
    <style type="text/css">
        .tr_undo{

        }
        .tr_doing{
            background-color: rgb(166, 220, 163);
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
                    <th style="width: 85px">任务编号</th>
                    <th style="width: 20px">PRI</th>
                    <th style="width: 45px">状态</th>
                    <th >任务标题</th>
                    <th style="width: 60px">客户</th>
                    <th style="width: 40px">PM</th>
                    <th style="width: 60px">开发</th>
                    <th style="width: 60px">测试</th>
                    <th style="width: 60px">完成时间</th>
                    <th style="width: 300px">备注</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script type="text/javascript">
    var data = <?= $page_data ?>;
    var task_status = data.task_status;

    var tt = $('#example').DataTable({
        ajax:'/task/get_todoList',
        columns:[
            {'data':"task_no"},
            {'data':"PRI"},
            {'data':"status"},
            {'data':"task_title"},
            {'data':"customer_name"},
            {'data':"abu_pm"},
            {'data':"dev_name"},
            {'data':"tester_name"},
            {'data':"ekp_expect"},
            {'data':"comment"},
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
                    return task_status[data];
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
            {
                "render": function(data, type, row, meta) {
                    return '<a href="#" name="view_on_ekp" rel="' + row.ekp_code + '" target="_blank">' + data + '</a>';
                },
                "targets": 4
            },
            {
                "render": function(data, type, row, meta) {
                    return  (data)? data+'('+row.developer_workload+")":"";
                },
                "targets":6
            },
            {
                "render": function(data, type, row, meta) {
                    return  (data)? data+'('+row.tester_workload+")":"";
                },
                "targets":7
            },
            {
                "render": function(data, type, row, meta) {
                    return  data.substring(0,10);
                },
                "targets":8
            },
        ],
        "createdRow": function ( row, data, index ) {
            $(row).attr("rel",data.id);
            switch (data.status)
            {
                case 1:
                    $(row).find("td:eq(6)").addClass("or_doing");
                        break;
                    case 2:
                        $(row).find("td:eq(7)").addClass("or_doing");
                    break;

            }
        },
        paging: false,//分页
        ordering: true,//是否启用排序
//        order: [ [ 0, 'asc' ]],
//                searching: true,//搜索
        dom: "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        language: {
            lengthMenu: '每页<select class="form-control input-xsmall">' +  '<option value="50">50</option>' + '<option value="100">100</option>' + '</select>条记录',//左上角的分页大小显示。
            search: '搜索：',//右上角的搜索文本，可以写html标签
            paginate: {//分页的样式内容。
                previous: "上一页",
                next: "下一页",
                first: "第一页",
                last: "最后"
            },
            zeroRecords: "没有找到相关内容",//table tbody内容为空时，tbody的内容。
            //下面三者构成了总体的左下角的内容。
            info: "显示第_START_ 到第 _END_ ，筛选之后得到 _TOTAL_ 条，初始 _MAX_ 条 ",//左下角的信息显示，大写的词为关键字。
            infoEmpty: "0条记录",//筛选为空时左下角的显示。
            infoFiltered: ""//筛选之后的左下角筛选提示，
        },
        bAutoWidth:false,
    });


    $(document).on('click', '#example tbody tr', function () {
            var data = $(this);
            $.modal({
                keyboard: true,
                width:598,
                minHeight:518,
                transition:true,
                remote: '/task/edit/' + data.attr("rel"),
                okHide: function () {

                }
            })
        } );

        $('#example tbody').on('click',"td a[name='view_on_erp']",function(e){
            e.stopPropagation();
            e.preventDefault();
            if ($(this).attr("rel") != "") {
                window.open("http://pd.mysoft.net.cn" + $(this).attr("rel"));
            }
        });

        $('#example tbody').on('click',"td a[name='view_on_ekp']",function(e){
            e.stopPropagation();
            e.preventDefault();
            if ($(this).attr("rel") != "") {
                window.open("http://cm.mysoft.net.cn/Dashboard/" + $(this).attr("rel"));
            }
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
                        tt.ajax.reload(null,false);
                    }
                },
                error:function(){
                    $.toast("同步失败，请检查日志","error");
                }
            });
        });

        $(document).on("keypress", '.search-form[type="search"]', function (e) {
            if (e.keyCode == "13") {
                var keyword = $(this).val();
                tt.search(keyword).draw();
            }
        });

        $(document).on("click", ".btn-search", function (e) {
            var keyword = $('.search-form[type="search"]').val();
            if(keyword === '') {
                $.toast("请输入查找内容","info");
                return false;
            }
            tt.search(keyword).draw();
        });

        var data = <?= $page_data ?>;
        var task_status = data.task_status;
</script>
@stop
