@extends('templates.default')
@section('content')
    <style type="text/css">
        .list{
            margin-top: 6px;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="input-group pull-left">
                    <form onsubmit="return false;">
                        <input type="search" class="form-control search-form" placeholder="客户名称">
                    </form>
                    <span class="input-group-btn">
                        <button class="btn btn-default btn-search" type="button"><i class="glyphicon glyphicon-search"></i></button>
                    </span>
                </div>
            </div>
            <div class="col-md-8">
                <div class="pull-right" >
                    <a href="#" class="btn btn-default" name="add_customer" title="新增"><i class="glyphicon glyphicon-indent-right"></i>&nbsp;&nbsp;新增</a>
                </div>
            </div>
        </div>

        <div class="list">
            <table class="table table-bordered table-hover" id="example">
                <thead>
                <tr>
                    <th>#</th>
                    <th style="min-width: 90px;">TFS名称</th>
                    <th>别名</th>
                    <th>代码库</th>
                    <th>是否升级</th>
                    <th>移动审批版本</th>
                    <th>备注</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $k=>$item)
                    <tr rel="{{$item->id}}" >
                        <th>{{$k+1}}</th>
                        <td>{{$item->name}}</td>
                        <td>{{$item->ekp_latest_name}}</td>
                        <td>
                            @foreach($item->Details as $k=>$detail)
                                <li style="list-style: none;line-height: 21px">[{{$k+1}}]. 版本: {{$detail['workflow_version']}}  <font style="font-size: 12px;color: rgb(201, 201, 221)">[{{$detail['erp_version']}}]</font></li>
                            @endforeach
                        </td>
                        <td>2016年6月18日 <font color="red">升级</font></td>
                        <td>104</td>
                        <td>客户版本使用情况，移动审批服务版本</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script type="text/javascript">

        var tt = $('#example').DataTable({
            lengthMenu: [15,30,45, 60,75, 90,"ALL"],//这里也可以设置分页，但是不能设置具体内容，只能是一维或二维数组的方式，所以推荐下面language里面的写法。
            paging: true,//分页
            ordering: true,//是否启用排序
//        order: [ [ 0, 'asc' ]],
//                searching: true,//搜索
            dom: "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            language: {
                lengthMenu: '每页<select class="form-control input-xsmall">' + '<option value="30">30</option>' + '<option value="30">30</option>' + '<option value="50">50</option>' + '<option value="100">100</option>' + '</select>条记录',//左上角的分页大小显示。
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

        $(document).on("keypress", '.search-form[type="search"]', function (e) {
            if (e.keyCode == "13") {
                var keyword = $(this).val();
//                if(keyword === '') {
//                    $.toast("请输入查找内容","info");
//                    return false;
//                }
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

        $(document).on('click', '#example tbody tr', function () {
            var data = $(this);
            $.modal({
                keyboard: true,
                width:698,
                minHeight:318,
                remote: '/customer/detail/' + data.attr("rel"),
                okHide: function () {
                    location.reload();
                }
            })
        } );

    </script>
    @stop