@extends('templates.default')
@section('content')
    <script src="{{asset('vendor/js/angular.min.js')}}"></script>
    <script src="{{asset('vendor/js/Sortable.js')}}"></script>
    <script src="{{asset('vendor/js/ng-sortable.js')}}"></script>

    {{--样式--}}
    <style>

        /*重置CSS*/

        /*全局通用样式*/
        body {
            font-family: "Microsoft Yahei";
        }

        li {
            line-height: 20px;
            list-style: none;
            display: list-item;
            overflow: auto;
        }

        ul {
            padding-left: 0px;
        }

        /*任务模块*/
        .task-priority {
            position: absolute;
            width: 10px;
            min-height: 38px;
            height: 100%;
        }

        .task-priority-0 {
            background-color: #fff;
        }

        .task-priority-0:hover {
            background-color: grey;
        }

        .task-priority-1 {
            background-color: #ff9800;
        }

        .task-priority-2 {
            background-color: red;
        }

        .check-box {
            float: left;
            margin: 10px 10px 10px 20px;
            width: 20px;
            height: 20px;
            border: 2px solid #b3b3b3;
            cursor: pointer;
            border-radius: 3px;
        }

        .check-box-done {
            float: left;
            margin: 10px 10px 10px 20px;
            width: 20px;
            height: 20px;
            border: 2px solid #b3b3b3;
            cursor: pointer;
            border-radius: 3px;
        }

        .task-content-set {
            min-height: 40px;
            margin-right: 10px;
            padding: 10px 0px;
            cursor: pointer;
            float: left;
        }

        .task-content-pic {
            width: 24px;
            height: 24px;
            float: left;
            background-image: url({{asset('/vendor/imgs/shenjl-s.png')}});
            margin-top: -2px;
        }

        .task-content-wrapper {
            position: relative;
            right: -10px;
            float: left;
            cursor: pointer;
            width: 170px;
        }

        .task-content {
            margin: 0px;
            padding: 0px;
            width: 100%;
            border: 0 none;
            background: none;
            cursor: pointer;
        }

        .text-delete{
            text-decoration:line-through;
            color: grey;
        }
        .board-view {
            position: fixed;
            top: 50px;
            right: 0;
            bottom: 0;
            left: 0;
            padding: 0;
            overflow: hidden;
        }

        .board-scrum-view {
            position: relative;
            height: 100%;
            background-color: #FFF;
            border: 0 solid #d9d9d9;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .board-scrum-stages {
            position: relative;
            padding: 10px;
            white-space: nowrap;
            height: 100%;
        }

        .scrum-stage {
            position: relative;
            display: inline-block;
            margin-right: 10px;
            height: 100%;
            width: 280px;
            vertical-align: top;
            border: 1px solid rgba(0, 0, 0, .12);
            background-color: #eee;
            /*#F8F8F8*/
            border-radius: 3px;
        }

        .scrum-stage-header {
            position: absolute;
            top: 0;
            height: 40px;
            width: 100%;
            padding: 10px 30px 9px 15px;
            font-size: 15px;
            font-weight: 700;
            z-index: 1;
            cursor: move;
        }

        .stage-name {

        }

        .icon {
            display: inline-block;
            font-style: normal;
            font-weight: 400;
            font-variant: normal;
            text-transform: none;
            speak: none;
            -webkit-font-smoothing: antialiased
        }
        .icon-tick{
            visibility: hidden;
            color:#b3b3b3;
            font-size:13px;
            transform: translate(2px,-1px);
        }
        /*伪元素*/
        .icon-tick:before{
            content: url({{asset('/vendor/imgs/checkboxmark.png')}});
        }
        .done{
            visibility: visible;
        }
        .scrum-stage-wrap {
            position: relative;
            width: 100%;
            height: 100%;
            padding-top: 40px;
        }

        .scrum-stage-content {
            width: 100%;
            height: 100%;
            position: static;
            overflow-y: auto;
            overflow-x: visible;
        }

        .scrum-stage-tasks {
            margin-bottom: 5px;
            width: 100%;
            height: 100%;
        }

        .task {
            margin-bottom: 5px;
            background-color: #fff;
            border-style: solid;
            border-color: rgba(0, 0, 1, .12);
            border-width: 1px 0;
            min-height: 40px;
            width: 100%;
            position: relative;
            white-space: normal;
        }

        .task-creator-handler-wrap {
            display: block;
            width: 100%;
            position: absolute;
            bottom: 0px;
        }

        .link-add-handler {
            display: inline-block;
            width: 100%;
            padding: 10px 15px;
            font-size: 15px;
            text-decoration: none;
            cursor: pointer;
        }

        .link-add-handler:hover {
            text-decoration: none;
            color: #23527c;
        }
    </style>

    {{--提示信息--}}
    <div style="display:none;">
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert"
                    aria-hidden="true">
                &times;
            </button>
            成功！很好地完成了提交。
        </div>
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert"
                    aria-hidden="true">
                &times;
            </button>
            信息！请注意这个信息。
        </div>
        <div class="alert alert-warning alert-dismissable">
            <button type="button" class="close" data-dismiss="alert"
                    aria-hidden="true">
                &times;
            </button>
            警告！请不要提交。
        </div>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert"
                    aria-hidden="true">
                &times;
            </button>
            错误！请进行一些更改。
        </div>
    </div>

    {{--任务面板--}}
    <div class="board-view">
        <div class="board-scrum-view">
            <ul id="ul-task" class="board-scrum-stages">
                <li class="scrum-stage">
                    <header class="scrum-stage-header">
                        <div class="stage-name">
                            <span>待处理</span>
                            <span> ·</span>
                            <span id="span-todo-num">0</span>
                        </div>
                        <a class=""></a>
                    </header>
                    <div class="scrum-stage-wrap">
                        <section class="scrum-stage-content">
                            <ul id="todo-foo" class="scrum-stage-tasks">
                                @foreach($tasks["tasks_ing"] as $k=>$task)
                                    @if($task->status==0)
                                        <li class="task" rel="{{$task->id}}">
                                            <div class="task-priority task-priority-{{$task->priority}}" rel="{{$task->priority}}">
                                                <a class="task-priority-hint"></a>
                                            </div>
                                            <a class="check-box">
                                                <span class="icon icon-tick"></span>
                                            </a>

                                            <div class="task-content-set">
                                                <div class="task-content-pic">
                                                </div>
                                                <div class="task-content-wrapper">
                                                    <div class="task-content" rel="{{$task->id}}">
                                                        {{$task->task_title}}
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                            <div class="task-creator-wrap"></div>
                            <ul></ul>
                            <div class="task-creator-handler-wrap">
                                <a class="link-add-handler">
                                    <span>
                                        添加任务
                                    </span>
                                </a>
                            </div>
                        </section>
                    </div>
                </li>
                <li class="scrum-stage">
                    <header class="scrum-stage-header">
                        <div class="stage-name">
                            <span>处理中</span>
                            <span> ·</span>
                            <span id="span-doing-num">0</span>
                        </div>
                        <a class=""></a>
                    </header>
                    <div class="scrum-stage-wrap">
                        <section class="scrum-stage-content">
                            <ul id="doing-foo" class="scrum-stage-tasks">
                                @foreach($tasks["tasks_ing"] as $k=>$task)
                                    @if($task->status==1)
                                        <li class="task" rel="{{$task->id}}">
                                            <div class="task-priority task-priority-{{$task->priority}}" rel="{{$task->priority}}">
                                                {{--<a class="task-priority-hint"></a>--}}
                                            </div>
                                            <a class="check-box">
                                                <span class="icon icon-tick"></span>
                                            </a>

                                            <div class="task-content-set">
                                                <div class="task-content-pic">
                                                </div>
                                                <div class="task-content-wrapper">
                                                    <div class="task-content" rel="{{$task->id}}">
                                                        {{$task->task_title}}
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                            <div class="task-creator-wrap"></div>
                            <ul></ul>
                            <div class="task-creator-handler-wrap">
                                <a class="link-add-handler">
                                    <span>
                                        添加任务
                                    </span>
                                </a>
                            </div>
                        </section>
                    </div>
                </li>
                <li class="scrum-stage">
                    <header class="scrum-stage-header">
                        <div class="stage-name">
                            <span>验证中</span>
                            <span> ·</span>
                            <span id="span-verify-num">0</span>
                        </div>
                        <a class=""></a>
                    </header>
                    <div class="scrum-stage-wrap">
                        <section class="scrum-stage-content">
                            <ul id="verify-foo" class="scrum-stage-tasks">
                                @foreach($tasks["tasks_ing"] as $k=>$task)
                                    @if($task->status==2)
                                        <li class="task" rel="{{$task->id}}">
                                            <div class="task-priority task-priority-{{$task->priority}}" rel="{{$task->priority}}">
                                                {{--<a class="task-priority-hint"></a>--}}
                                            </div>
                                            <a class="check-box">
                                                <span class="icon icon-tick"></span>
                                            </a>

                                            <div class="task-content-set">
                                                <div class="task-content-pic">
                                                </div>
                                                <div class="task-content-wrapper">
                                                    <div class="task-content" rel="{{$task->id}}">
                                                        {{$task->task_title}}
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                            <div class="task-creator-wrap"></div>
                            <ul></ul>
                            <div class="task-creator-handler-wrap">
                                <a class="link-add-handler">
                                    <span>
                                        添加任务
                                    </span>
                                </a>
                            </div>
                        </section>
                    </div>
                </li>
                <li class="scrum-stage">
                    <header class="scrum-stage-header">
                        <div class="stage-name">
                            <span>已完成</span>
                            <span> ·</span>
                            <span id="span-done-num">0</span>
                        </div>
                        <a class=""></a>
                    </header>
                    <div class="scrum-stage-wrap">
                        <section class="scrum-stage-content">
                            <ul id="done-foo" class="scrum-stage-tasks">
                                {{--<li class="task" rel="0">--}}
                                    {{--<div class="task-priority-0">--}}
                                        {{--<a class="task-priority-hint"></a>--}}
                                    {{--</div>--}}
                                    {{--<a class="check-box-done">--}}
                                        {{--<span class="icon icon-tick done"></span>--}}
                                    {{--</a>--}}

                                    {{--<div class="task-content-set">--}}
                                        {{--<div class="task-content-pic">--}}
                                        {{--</div>--}}
                                        {{--<div class="task-content-wrapper">--}}
                                            {{--<div class="task-content text-delete">--}}
                                                {{--这是一条已完成的任务--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</li>--}}
                                @foreach($tasks["tasks_done"] as $k=>$task)
                                        <li class="task" rel="{{$task->id}}">
                                            <div class="task-priority-0">
                                                {{--<a class="task-priority-hint"></a>--}}
                                            </div>
                                            <a class="check-box-done">
                                                <span class="icon icon-tick done"></span>
                                            </a>

                                            <div class="task-content-set">
                                                <div class="task-content-pic">
                                                </div>
                                                <div class="task-content-wrapper">
                                                    <div class="task-content text-delete" rel="{{$task->id}}">
                                                        {{$task->task_title}}
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                @endforeach
                            </ul>
                            <div class="task-creator-wrap"></div>
                            <ul></ul>
                            <div class="task-creator-handler-wrap">
                                <a class="link-add-handler">
                                    <span>
                                        添加任务
                                    </span>
                                </a>
                            </div>
                        </section>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    {{--模态对话框--}}
    <div class="modal fade fixed" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                    {{--<a style="float: left" href="http://www.baidu.com" name="view_on_erp" rel="">[9527]</a>--}}
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ URL('task_panel/edit') }}" role="form" id="form_task">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="task_id" id="task_id" value="">

                        <div class="form-group">
                            <div class="btn-group">
                                <label for="select-dev">开发</label>
                                <select class="form-control" id="select-dev" name="dev">
                                    <option value="未指定">未指定</option>
                                    @foreach($users["developers"] as $dev)
                                        <option value="{{$dev->name}}">{{$dev->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="btn-group">
                                <label for="select-test">测试</label>
                                <select class="form-control" id="select-test" name="test">
                                    <option value="未指定">未指定</option>
                                    @foreach($users["testers"] as $test)
                                        <option value="{{$test->name}}">{{$test->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="btn-group">
                                <label for="select-test">优先级</label>
                                <select class="form-control" id="select-priority" name="priority">
                                    <option value="0">普通</option>
                                    <option value="1">紧急</option>
                                    <option value="2">非常紧急</option>
                                </select>
                            </div>

                            {{--<div class="dropdown">--}}
                            {{--<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">--}}
                            {{--选择你喜欢的水果--}}
                            {{--<span class="caret"></span>--}}
                            {{--</button>--}}
                            {{--<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">--}}
                            {{--<li role="presentation"><a role="menuitem" tabindex="-1" href="#">苹果</a></li>--}}
                            {{--<li role="presentation"><a role="menuitem" tabindex="-1" href="#">香蕉</a></li>--}}
                            {{--<li role="presentation"><a role="menuitem" tabindex="-1" href="#">梨</a></li>--}}
                            {{--<li role="presentation"><a role="menuitem" tabindex="-1" href="#">桃</a></li>--}}
                            {{--</ul>--}}
                            {{--</div>--}}

                        </div>
                        <div class="form-group">
                            <label for="select-date">完成日期</label>
                            <input type="text" name="date" id="select-date" class="form-control" placeholder="选择日期"
                                   data-toggle="datepicker" data-rule-required="true" data-rule-date="true">
                        </div>

                        <div class="form-group">
                            <label for="select-date">备注/总结</label>
                            <textarea id="comment" class="form-control" rows="3" placeholder="请输入.."
                                      name="comment"></textarea>
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
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>

    <script type="text/javascript">
        //初始化
        $(document).ready(function () {

            //初始化页面参数
            initPageArgs();

            //初始化Sortable
            initSortable();

            //绑定事件
            bindEvent();

            //为待处理模块赋值
            //initToDoModule();
        });

        //+----------------------------------------------------------------------  
        //| 功能：事件绑定初始化   
        //| 说明：
        //| 参数：
        //| 返回值：
        //| 创建人：沈金龙
        //| 创建时间：2016-3-21 17:14:24
        //+----------------------------------------------------------------------
        function bindEvent() {
            //点击任务，打开模态框
            $(".task-content").click(function () {
                $.ajax({
                    type: 'GET',
                    url: '/task_panel/get_detail/' + $(this).attr('rel'),
                    dataType: 'json',
                    success: function (data) {
//                          console.info(data);
                        if (data) {
                            var my_model = $('#myModal');
                            //模态框赋值
//                            my_model.find('.modal-title').text(data["task_title"]);
                            var erp_link="<a href=\"#\" onclick=\"openErpWin(this)\" name=\"view_on_erp\" rel=\""+data["task_no"]+"\">["+data["task_no"]+"]</a>";
                            my_model.find('.modal-title').html(data["task_title"]+"-"+erp_link);

                            my_model.find('#select-date').val(data["actual_finish_date"]);
                            my_model.find('#task_id').val(data["id"]);
                            my_model.find('#comment').val(data["comment"]);

                            //默认选中
                            $.each($("#select-dev option"), function (n, value) {
                                if (value.text == data["dev"]) {
                                    $(value).attr("selected", "selected");
                                }
                            });
                            $.each($("#select-test option"), function (n, value) {
                                if (value.text == data["test"]) {
                                    $(value).attr("selected", "selected");
                                }
                            });
                            $.each($("#select-priority option"), function (n, value) {
                                if (value.value == data["priority"]) {
                                    $(value).attr("selected", "selected");
                                }
                            });
                            my_model.modal('toggle');
                        }
                        else {
                            //TODO:提示：未找到对应的任务详情。
                        }
                    }
                });
            });

            //模态窗口按钮提交事件
            $("#btnSubmit").unbind('click').bind('click', function () {
                $("#form_task").submit();
            });

            //快速优先级
            $(".task-priority").click(function(){
                var index = $(this).attr("rel");
                if(index<2){
                    $(this).removeClass("task-priority-"+index).addClass("task-priority-"+(parseInt(index)+1));
                    $(this).attr("rel",parseInt(index)+1);
                    updateTaskStatus({"key": "priority", "value":parseInt(index)+1}, $(this).parent().find(".task-content").attr("rel"));
                }else{
                    $(this).removeClass("task-priority-2").addClass("task-priority-0");
                    $(this).attr("rel","0");
                    updateTaskStatus({"key": "priority", "value": 0}, $(this).parent().find(".task-content").attr("rel"));
                }
            });

            //点击完成任务
            $(".check-box").click(function(){
                doneTask($(this));
            });

            //点击恢复任务
            $(".check-box-done").click(function(){
                recoverTask($(this));
            });

            //添加任务
            $(".link-add-handler").click(function(){
                addTask($(this));
            });
        }

        //+----------------------------------------------------------------------  
        //| 功能：页面参数初始化   
        //| 说明：
        //| 参数：
        //| 返回值：
        //| 创建人：沈金龙
        //| 创建时间：2016-3-21 17:12:50
        //+----------------------------------------------------------------------
        function initPageArgs() {
            //任务数目初始化
            var length1 = $("#todo-foo").find('li').length;
            $("#span-todo-num").text(length1);

            var length2 = $("#doing-foo").find('li').length;
            $("#span-doing-num").text(length2);

            var length3 = $("#verify-foo").find('li').length;
            $("#span-verify-num").text(length3);

            var length4 = $("#done-foo").find('li').length;
            $("#span-done-num").text(length4);

            //其他初始化
        }

        //+----------------------------------------------------------------------  
        //| 功能：初始化待处理模板   
        //| 说明：
        //| 参数：
        //| 返回值：
        //| 创建人：沈金龙
        //| 创建时间：2016-3-17 15:27:31
        //+----------------------------------------------------------------------
        function initToDoModule() {
            $.ajax({
                type: "get",
                url: '/task_panel/get_all_info',
                dataType: 'json',
                async: false,
                success: function (data) {
                    $("#todo-foo").empty();
                    for (var d = 0; d < data.length; d++) {

                    }
                }
            });
        }

        //+----------------------------------------------------------------------  
        //| 功能：初始化Sortable   
        //| 说明：
        //| 参数：
        //| 返回值：
        //| 创建人：沈金龙
        //| 创建时间：2016-3-17 15:27:31
        //+----------------------------------------------------------------------
        function initSortable() {
            var todo = document.getElementById('todo-foo');
            var doing = document.getElementById('doing-foo');
            var done = document.getElementById('done-foo');
            var verify = document.getElementById('verify-foo');
            var task_panel = document.getElementById('ul-task');

            //面板拖动
            Sortable.create(task_panel);

            var sortable1 = Sortable.create(todo, {
                group: 'shared',
                onAdd: function (evt) {
                    $("#span-todo-num").text($("#todo-foo").find('li').length);
                    var task_id = $(evt.item.innerHTML).find(".task-content").attr("rel");
                    var _data = {"key": "status", "value": 0};
                    updateTaskStatus(_data, task_id);
                },
                onRemove: function (/**Event*/evt) {
                    $("#span-todo-num").text($("#todo-foo").find('li').length);
                }
            });
            var sortable2 = Sortable.create(doing, {
                group: 'shared',
                onAdd: function (evt) {
                    $("#span-doing-num").text($("#doing-foo").find('li').length);
                    var task_id = $(evt.item.innerHTML).find(".task-content").attr("rel");
                    var _data = {"key": "status", "value": 1};
                    updateTaskStatus(_data, task_id);
                },
                onRemove: function (/**Event*/evt) {
                    $("#span-doing-num").text($("#doing-foo").find('li').length);
                }
            });
            var sortable3 = Sortable.create(verify, {
                group: 'shared',
                onAdd: function (evt) {
                    $("#span-verify-num").text($("#verify-foo").find('li').length);
                    var task_id = $(evt.item.innerHTML).find(".task-content").attr("rel");
                    var _data = {"key": "status", "value": 2};
                    updateTaskStatus(_data, task_id);
                },
                onRemove: function (/**Event*/evt) {
                    $("#span-verify-num").text($("#verify-foo").find('li').length);
                }
            });
            var sortable4 = Sortable.create(done, {
                group: {
                    name: 'shared',
                    pull: false,
                    put: false
                }
            });
        }

        //+----------------------------------------------------------------------  
        //| 功能：task表快速操作   
        //| 说明：
        //| 参数：
        //| data：数据。格式：{"key":"val","value":"val"}
        //| 返回值：
        //| 创建人：沈金龙
        //| 创建时间：2016-3-22 16:20:39
        //+----------------------------------------------------------------------
        function updateTaskStatus(_data,task_id){
            $.ajax({
                type: 'GET',
                url: '/task_panel/fast_handle/' + task_id,
                data:_data,
                dataType: 'json',
                success: function (data) {
                    if (data) {
                        //TODO：成功提示
                        alert(data);
                    }
                    else {
                        //TODO:提示：未找到对应的任务。
                        alert(data);
                    }
                },
                error:function(XMLHttpRequest, textStatus, errorThrown){
                    console.info(XMLHttpRequest);
                    console.info(textStatus);
                    console.info(errorThrown);
                }
            });
        }

        //+----------------------------------------------------------------------  
        //| 功能：打开ERP任务系统页面   
        //| 说明：
        //| 参数：
        //| 返回值：
        //| 创建人：沈金龙
        //| 创建时间：2016-3-17 15:27:31
        //+----------------------------------------------------------------------
        function openErpWin(obj){
            //任务编号
            var task_id = $(obj).attr('rel');

            //异步取任务oid
            var erpOid = "";
            //打开窗口
            alert("开发中，请稍候~~");
        }

        //+----------------------------------------------------------------------  
        //| 功能：新增任务   
        //| 说明：
        //| 参数：
        //| 返回值：
        //| 创建人：沈金龙
        //| 创建时间：2016-3-23 12:07:51
        //+----------------------------------------------------------------------
        function addTask() {
            //TODO:添加任务
            alert("开发中，请稍后~~");
        }

        //+----------------------------------------------------------------------  
        //| 功能：完成选中任务   
        //| 说明：
        //| 参数：
        //| 返回值：
        //| 创建人：沈金龙
        //| 创建时间：2016-3-17 15:27:31
        //+----------------------------------------------------------------------
        function doneTask(obj) {
            var liObj=$(obj).parent();
            var task_id = liObj.attr("rel");

            //打钩
            liObj.find('span').addClass('done');

            //移除优先级
            liObj.find('div:first').removeClass().addClass('task-priority-0');

            //任务删除线
            liObj.find('.task-content').addClass('text-delete');

            //添加恢复任务事件
            $(obj).click(function(){
                recoverTask(obj);
            });

            //liObj.find('span').addClass('done'); //选中，延时移动

            //更改任务状态为完成，status：3
            updateTaskStatus({"key": "status", "value":3},task_id );

            $("#done-foo").prepend(liObj);
        }

        //+----------------------------------------------------------------------  
        //| 功能：恢复选中任务   
        //| 说明：
        //| 参数：
        //| 返回值：
        //| 创建人：沈金龙
        //| 创建时间：2016-3-17 15:27:31
        //+----------------------------------------------------------------------
        function recoverTask(obj){
            var liObj=$(obj).parent();
            var task_id = liObj.attr("rel");
//            alert(task_id);
            //去除打钩
            liObj.find('span').removeClass('done');

            //增加普通优先级
            liObj.find('div:first').addClass('task-priority,task-priority-0');
            updateTaskStatus({"key": "priority", "value":0},task_id );

            //去除删除线
            liObj.find('.task-content').removeClass('text-delete');

            //添加完成任务事件
            $(obj).click(function(){
                doneTask(obj);
            });

            //liObj.find('span').addClass('done'); //选中，延时移动

            //更改任务状态为待处理，status：0
            updateTaskStatus({"key": "status", "value":0},task_id );

            $("#todo-foo").append(liObj);
        }
    </script>
@stop