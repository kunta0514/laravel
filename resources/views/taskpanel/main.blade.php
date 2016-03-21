@extends('templates.default')
@section('content')
    <script src="{{asset('vendor/js/angular.min.js')}}"></script>
    <script src="{{asset('vendor/js/Sortable.js')}}"></script>
    <script src="{{asset('vendor/js/ng-sortable.js')}}"></script>
    <style>

        /*重置CSS*/


        /*全局通用样式*/
        body{
            font-family: "Microsoft Yahei";
        }
        li{
            line-height: 20px;
            list-style:none;
            display: list-item;
        }
        ul{
            padding-left: 0px;
        }

        /*任务模块*/
        .task-priority{
            position: absolute;
            /*top: 0px;*/
            /*bottom: 0px;*/
            width:10px;
            min-height: 38px;
        }
        .task-priority-0{
            background-color:#fff;
        }
        .task-priority-0:hover{
            background-color:#ff9800;
        }
        .check-box{
            float:left;
            margin:10px 10px 10px 20px;
            width:20px;
            height:20px;
            border:2px solid #b3b3b3;
            cursor:pointer;
            border-radius: 3px;
        }
        .task-content-set{
            min-height: 40px;
            margin-right:10px;
            padding:10px 0px;
            cursor:pointer;
            float: left;
        }
        .task-content-pic{
            width:24px;
            height:24px;
            float:left;
            background-image:url({{asset('/vendor/imgs/shenjl-s.png')}});
        }
        .task-content-wrapper{
            position: relative;
            right:-10px;
            float: left;
            cursor:pointer;
        }
        .task-content{
            margin: 0px;
            padding: 0px;
            width:100%;
            border:0 none;
            background: none;
            cursor: pointer;
        }
        .board-view{
            position:fixed;
            top:50px;
            right:0;
            bottom:0;
            left:0;
            padding:0;
            overflow: hidden;
        }
        .board-scrum-view{
            position:relative;
            height: 100%;
            background-color: #FFF;
            border: 0 solid #d9d9d9;
            overflow-y:auto;
            overflow-x: hidden;
        }
        .board-scrum-stages{
            position:relative;
            padding: 10px;
            white-space: nowrap;
            height: 100%;
        }
        .scrum-stage{
            position: relative;
            display:inline-block;
            margin-right: 10px;
            height: 100%;
            width: 280px;
            vertical-align: top;
            border: 1px solid rgba(0,0,0,.12);
            background-color: #eee;
            /*#F8F8F8*/
            border-radius: 3px;
        }
        .scrum-stage-header{
            position: absolute;
            top:0;
            height: 40px;
            width:100%;
            padding: 10px 30px 9px 15px;
            font-size: 15px;
            font-weight: 700;
            z-index:1;
            cursor: move;
        }
        .stage-name{

        }
        .icon{
            display:inline-block;
            font-style:normal;
            font-weight:400;
            font-variant:normal;
            text-transform:none;
            speak:none;
            -webkit-font-smoothing:antialiased
        }
        .icon-chevron-right:before{
            content: "\B002";
        }
        .icon-clock2:before{
            content:"\B204";
        }
        .scrum-stage-wrap{
            position: relative;
            width:100%;
            height:100%;
            padding-top: 40px;
        }
        .scrum-stage-content{
            width:100%;
            height:100%;
            position:static;
            overflow-y: auto;
            overflow-x: visible;
        }
        .scrum-stage-tasks{
            margin-bottom: 5px;
            width:100%;
            height:100%;
        }
        .task{
            margin-bottom: 5px;
            background-color: #fff;
            border-style: solid;
            border-color: rgba(0,0,1,.12);
            border-width: 1px 0;
            min-height: 40px;
            width:100%;
            position: relative;
            white-space: normal;
        }

        .task-creator-handler-wrap {
            display: block;
            width: 100%;
            position: absolute;
            bottom:0px;
        }
        .link-add-handler{
            display:inline-block;
            width:100%;
            padding: 10px 15px;
            font-size:15px;
            text-decoration: none;
            cursor: pointer;
        }
        .link-add-handler:hover{
            text-decoration: none;
            color:#23527c;
        }
    </style>

    <div class="board-view">
        <div class="board-scrum-view">
            <ul id="ul-task" class="board-scrum-stages">
                <li class="scrum-stage">
                    <header class="scrum-stage-header">
                        <div class="stage-name">
                            <span>待处理</span>
                            <span> · 11</span>
                        </div>
                        <a class=""></a>
                    </header>
                    <div class="scrum-stage-wrap" >
                        <section class="scrum-stage-content">
                            <ul id="todo-foo" class="scrum-stage-tasks">
                                <li class="task">
                                    <div class="task-priority task-priority-0">
                                        {{--<a class="task-priority-hint"></a>--}}
                                    </div>
                                    <a class="check-box">
                                        <span class="icon icon-tick"></span>
                                    </a>
                                    <div class="task-content-set">
                                        <div class="task-content-pic">
                                        </div>
                                        <div class="task-content-wrapper">
                                            <div class="task-content">
                                                临时的任务
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="task">
                                    <div class="task-priority task-priority-0">
                                        {{--<a class="task-priority-hint"></a>--}}
                                    </div>
                                    <a class="check-box">
                                        <span class="icon icon-tick"></span>
                                    </a>
                                    <div class="task-content-set">
                                        <div class="task-content-pic">
                                        </div>
                                        <div class="task-content-wrapper">
                                            <div class="task-content">
                                                临时的任务
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="task">
                                    <div class="task-priority task-priority-0">
                                        {{--<a class="task-priority-hint"></a>--}}
                                    </div>
                                    <a class="check-box">
                                        <span class="icon icon-tick"></span>
                                    </a>
                                    <div class="task-content-set">
                                        <div class="task-content-pic">
                                        </div>
                                        <div class="task-content-wrapper">
                                            <div class="task-content">
                                                临时的任务
                                            </div>
                                        </div>
                                    </div>
                                </li>
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
                            <span> · 11</span>
                        </div>
                        <a class=""></a>
                    </header>
                    <div class="scrum-stage-wrap" >
                        <section class="scrum-stage-content">
                            <ul id="doing-foo" class="scrum-stage-tasks">
                                <li class="task">
                                    <div class="task-priority task-priority-0">
                                        {{--<a class="task-priority-hint"></a>--}}
                                    </div>
                                    <a class="check-box">
                                        <span class="icon icon-tick"></span>
                                    </a>
                                    <div class="task-content-set">
                                        <div class="task-content-pic">
                                        </div>
                                        <div class="task-content-wrapper">
                                            <div class="task-content">
                                                临时的任务
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="task">
                                    <div class="task-priority task-priority-0">
                                        {{--<a class="task-priority-hint"></a>--}}
                                    </div>
                                    <a class="check-box">
                                        <span class="icon icon-tick"></span>
                                    </a>
                                    <div class="task-content-set">
                                        <div class="task-content-pic">
                                        </div>
                                        <div class="task-content-wrapper">
                                            <div class="task-content">
                                                临时的任务
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="task">
                                    <div class="task-priority task-priority-0">
                                        {{--<a class="task-priority-hint"></a>--}}
                                    </div>
                                    <a class="check-box">
                                        <span class="icon icon-tick"></span>
                                    </a>
                                    <div class="task-content-set">
                                        <div class="task-content-pic">
                                        </div>
                                        <div class="task-content-wrapper">
                                            <div class="task-content">
                                                临时的任务
                                            </div>
                                        </div>
                                    </div>
                                </li>
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
                            <span> · 11</span>
                        </div>
                        <a class=""></a>
                    </header>
                    <div class="scrum-stage-wrap" >
                        <section class="scrum-stage-content">
                            <ul id="verify-foo" class="scrum-stage-tasks">
                                <li class="task">
                                    <div class="task-priority task-priority-0">
                                        {{--<a class="task-priority-hint"></a>--}}
                                    </div>
                                    <a class="check-box">
                                        <span class="icon icon-tick"></span>
                                    </a>
                                    <div class="task-content-set">
                                        <div class="task-content-pic">
                                        </div>
                                        <div class="task-content-wrapper">
                                            <div class="task-content">
                                                临时的任务
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="task">
                                    <div class="task-priority task-priority-0">
                                        {{--<a class="task-priority-hint"></a>--}}
                                    </div>
                                    <a class="check-box">
                                        <span class="icon icon-tick"></span>
                                    </a>
                                    <div class="task-content-set">
                                        <div class="task-content-pic">
                                        </div>
                                        <div class="task-content-wrapper">
                                            <div class="task-content">
                                                临时的任务
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="task">
                                    <div class="task-priority task-priority-0">
                                        {{--<a class="task-priority-hint"></a>--}}
                                    </div>
                                    <a class="check-box">
                                        <span class="icon icon-tick"></span>
                                    </a>
                                    <div class="task-content-set">
                                        <div class="task-content-pic">
                                        </div>
                                        <div class="task-content-wrapper">
                                            <div class="task-content">
                                                临时的任务
                                            </div>
                                        </div>
                                    </div>
                                </li>
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
                            <span> · 11</span>
                        </div>
                        <a class=""></a>
                    </header>
                    <div class="scrum-stage-wrap" >
                        <section class="scrum-stage-content">
                            <ul id="done-foo" class="scrum-stage-tasks">
                                <li class="task">
                                    <div class="task-priority task-priority-0">
                                        {{--<a class="task-priority-hint"></a>--}}
                                    </div>
                                    <a class="check-box">
                                        <span class="icon icon-tick"></span>
                                    </a>
                                    <div class="task-content-set">
                                        <div class="task-content-pic">
                                        </div>
                                        <div class="task-content-wrapper">
                                            <div class="task-content">
                                                临时的任务
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="task">
                                    <div class="task-priority task-priority-0">
                                        {{--<a class="task-priority-hint"></a>--}}
                                    </div>
                                    <a class="check-box">
                                        <span class="icon icon-tick"></span>
                                    </a>
                                    <div class="task-content-set">
                                        <div class="task-content-pic">
                                        </div>
                                        <div class="task-content-wrapper">
                                            <div class="task-content">
                                                临时的任务
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="task">
                                    <div class="task-priority task-priority-0">
                                        {{--<a class="task-priority-hint"></a>--}}
                                    </div>
                                    <a class="check-box">
                                        <span class="icon icon-tick"></span>
                                    </a>
                                    <div class="task-content-set">
                                        <div class="task-content-pic">
                                        </div>
                                        <div class="task-content-wrapper">
                                            <div class="task-content">
                                                临时的任务
                                            </div>
                                        </div>
                                    </div>
                                </li>
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

    <script type="text/javascript">
        //初始化
        $(document).ready(function(){

            //初始化Sortable
            initSortable();
            $("input[type='checkbox']").click(function(){
                var li=$(this).parent().detach();
                $("#done-foo").append("<li>"+$(li).text()+"</li>");
            });

            //为待处理模块赋值
            initToDoModule();
        });

        //+----------------------------------------------------------------------  
        //| 功能：初始化待处理模板   
        //| 说明：
        //| 参数：
        //| 返回值：
        //| 创建人：沈金龙
        //| 创建时间：2016-3-17 15:27:31
        //+----------------------------------------------------------------------
        function initToDoModule(){
            $.ajax({
                type:"get",
                url:'/task_panel/get_all_info',
                dataType:'json',
                async:false,
                success: function (data) {
                    $("#todo-foo").empty();
                    for(var d=0;d<data.length;d++){
//                        //console.info(d);
//                        var li="<li><input type=\"checkbox\" onclick=\"doneChoosenTask(this)\">"+ data[d].task_title+"</li>";
//                        $("#todo-foo").append(li);
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
        function initSortable(){
            var todo = document.getElementById('todo-foo');
            var doing= document.getElementById('doing-foo');
            var done = document.getElementById('done-foo');
            var verify = document.getElementById('verify-foo');

            var task_panel=document.getElementById('ul-task');
            Sortable.create(task_panel);
            var sortable1 = Sortable.create(todo, {
                group: 'shared' });
            var sortable2 = Sortable.create(doing, {
                group: 'shared' });
            var sortable3 = Sortable.create(verify, {
                group: 'shared' });
            var sortable4 = Sortable.create(done, {
                group: {
                    name:'shared',
                    pull:false,
                    put:false
                } });
        }

        //+----------------------------------------------------------------------  
        //| 功能：新建任务   
        //| 说明：
        //| 参数：
        //| 返回值：
        //| 创建人：沈金龙
        //| 创建时间：2016-3-17 15:27:31
        //+----------------------------------------------------------------------
        function addNewTask(){
            var txtNewTask=$("#txtAddTask").val();
            var li="<li><input type=\"checkbox\" onclick=\"doneChoosenTask(this)\">"+txtNewTask+"</li>";
            $("#todo-foo").append(li);
            $("#txtAddTask").val('');
        }

        //+----------------------------------------------------------------------  
        //| 功能：完成任务   
        //| 说明：
        //| 参数：
        //| 返回值：
        //| 创建人：沈金龙
        //| 创建时间：2016-3-17 15:27:31
        //+----------------------------------------------------------------------
        function doneChoosenTask(obj){
            var li=$(obj).parent().detach();
            $("#done-foo").append("<li>"+$(li).text()+"</li>");
        }
    </script>

@stop