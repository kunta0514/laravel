@extends('templates.default2')
@section('content')

    {{--说明：View视图-我的任务--}}
    {{--作者：沈金龙--}}
    {{--时间：2016-3-28 15:48:24--}}

    <script type="text/javascript" src="vendor/js/angular.min.js"></script>
    <script type="text/javascript" src="vendor/js/Sortable.js"></script>
    <script type="text/javascript" src="vendor/js/ng-sortable.js"></script>

    {{--taskdiv test--}}
    {{--<div style="width:270px;height:60px;background-color:gray;min-height: 60px">--}}
    {{--<div class="task-priority task-priority-0">--}}
    {{--<a class="task-priority-hint"></a>--}}
    {{--</div>--}}
    {{--<a class="check-box">--}}
    {{--<span class="icon icon-tick"></span>--}}
    {{--</a>--}}
    {{--<div class="task-content-set">--}}
    {{--<div class="task-content-pic">--}}
    {{--</div>--}}
    {{--<div class="task-content-wrapper">--}}
    {{--<div class="task-content">--}}
    {{--这是一个临时的任务呢mem--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--main test--}}
    {{--<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">--}}
    {{--Modal Test--}}
    {{--</button>--}}
    {{--<div id="main" class="main">--}}
    {{--<div id="todo" class="taskPanle">--}}
    {{--<div id="todo-title" class="title">--}}
    {{--<span class="stage-name-title">待处理</span>--}}
    {{--<span class="task-count">0</span>--}}
    {{--<span class=""></span>--}}
    {{--</div>--}}
    {{--<div id="todo-tasks" calss="tasks">--}}
    {{--<ul id="todo-foo">--}}
    {{--<li>--}}
    {{--<div>--}}
    {{--<div class="task-priority task-priority-0">--}}
    {{--<a class="task-priority-hint"></a>--}}
    {{--</div>--}}
    {{--<a class="check-box">--}}
    {{--<span class="icon icon-tick"></span>--}}
    {{--</a>--}}
    {{--<div class="task-content-set">--}}
    {{--<div class="task-content-pic">--}}
    {{--</div>--}}
    {{--<div class="task-content-wrapper">--}}
    {{--<div class="task-content">--}}
    {{--这是一个临时的任务呢--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</li>--}}
    {{--<li>--}}
    {{--<div>--}}
    {{--<div class="task-priority task-priority-0">--}}
    {{--<a class="task-priority-hint"></a>--}}
    {{--</div>--}}
    {{--<a class="check-box">--}}
    {{--<span class="icon icon-tick"></span>--}}
    {{--</a>--}}
    {{--<div class="task-content-set">--}}
    {{--<div class="task-content-pic">--}}
    {{--</div>--}}
    {{--<div class="task-content-wrapper">--}}
    {{--<div class="task-content">--}}
    {{--这是一个临时的任务呢--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</li>--}}
    {{--<li>--}}
    {{--<div>--}}
    {{--<div class="task-priority task-priority-0">--}}
    {{--<a class="task-priority-hint"></a>--}}
    {{--</div>--}}
    {{--<a class="check-box">--}}
    {{--<span class="icon icon-tick"></span>--}}
    {{--</a>--}}
    {{--<div class="task-content-set">--}}
    {{--<div class="task-content-pic">--}}
    {{--</div>--}}
    {{--<div class="task-content-wrapper">--}}
    {{--<div class="task-content">--}}
    {{--这是一个临时的任务呢--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</li>--}}
    {{--</ul>--}}
    {{--<form style="margin-top:5px" onsubmit="addNewTask();return false;">--}}
    {{--<input id="txtAddTask" type="text" placeholder="add new todo here" style="height:30px;width:295px;">--}}
    {{--</form>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div id="doing" class="taskPanle">--}}
    {{--<div id="doing-title" class="title">--}}
    {{--<span class="stage-name-title">处理中</span>--}}
    {{--<span class="task-count">0</span>--}}
    {{--<span class=""></span>--}}
    {{--</div>--}}
    {{--<div id="doing-tasks">--}}
    {{--<ul id="doing-foo">--}}
    {{--<li><input type="checkbox">doing 1</li>--}}
    {{--<li><input type="checkbox">doing 2</li>--}}
    {{--<li><input type="checkbox">doing 3</li>--}}
    {{--<li><input type="checkbox">doing 4</li>--}}
    {{--</ul>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div id="done" class="taskPanle">--}}
    {{--<div id="done-title" class="title">--}}
    {{--<span class="stage-name-title">已完成</span>--}}
    {{--<span class="task-count">0</span>--}}
    {{--<span class=""></span>--}}
    {{--</div>--}}
    {{--<div id="done-tasks">--}}
    {{--<ul id="done-foo">--}}
    {{--<li>done 1</li>--}}
    {{--<li>done 2</li>--}}
    {{--<li>done 3</li>--}}
    {{--<li>done 4</li>--}}
    {{--<li>done 5</li>--}}
    {{--<li>done 6</li>--}}
    {{--<li>done 7</li>--}}
    {{--<li>done 8</li>--}}
    {{--</ul>--}}
    {{--</div>--}}
    {{--<div id="done-addTask">--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--model test--}}
    {{--<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">--}}
    {{--Modal Test--}}
    {{--</button>--}}
    {{--<div id="main" class="main">--}}
    {{--<div id="todo" class="taskPanle">--}}
    {{--<div id="todo-title" class="title">--}}
    {{--<span class="stage-name-title">待处理</span>--}}
    {{--<span class="task-count">0</span>--}}
    {{--<span class=""></span>--}}
    {{--</div>--}}
    {{--<div id="todo-tasks" calss="tasks">--}}
    {{--<ul id="todo-foo">--}}
    {{--<li>--}}
    {{--<div>--}}
    {{--<div class="task-priority task-priority-0">--}}
    {{--<a class="task-priority-hint"></a>--}}
    {{--</div>--}}
    {{--<a class="check-box">--}}
    {{--<span class="icon icon-tick"></span>--}}
    {{--</a>--}}
    {{--<div class="task-content-set">--}}
    {{--<div class="task-content-pic">--}}
    {{--</div>--}}
    {{--<div class="task-content-wrapper">--}}
    {{--<div class="task-content">--}}
    {{--这是一个临时的任务呢--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</li>--}}
    {{--<li>--}}
    {{--<div>--}}
    {{--<div class="task-priority task-priority-0">--}}
    {{--<a class="task-priority-hint"></a>--}}
    {{--</div>--}}
    {{--<a class="check-box">--}}
    {{--<span class="icon icon-tick"></span>--}}
    {{--</a>--}}
    {{--<div class="task-content-set">--}}
    {{--<div class="task-content-pic">--}}
    {{--</div>--}}
    {{--<div class="task-content-wrapper">--}}
    {{--<div class="task-content">--}}
    {{--这是一个临时的任务呢--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</li>--}}
    {{--<li>--}}
    {{--<div>--}}
    {{--<div class="task-priority task-priority-0">--}}
    {{--<a class="task-priority-hint"></a>--}}
    {{--</div>--}}
    {{--<a class="check-box">--}}
    {{--<span class="icon icon-tick"></span>--}}
    {{--</a>--}}
    {{--<div class="task-content-set">--}}
    {{--<div class="task-content-pic">--}}
    {{--</div>--}}
    {{--<div class="task-content-wrapper">--}}
    {{--<div class="task-content">--}}
    {{--这是一个临时的任务呢--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</li>--}}
    {{--</ul>--}}
    {{--<form style="margin-top:5px" onsubmit="addNewTask();return false;">--}}
    {{--<input id="txtAddTask" type="text" placeholder="add new todo here" style="height:30px;width:295px;">--}}
    {{--</form>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div id="doing" class="taskPanle">--}}
    {{--<div id="doing-title" class="title">--}}
    {{--<span class="stage-name-title">处理中</span>--}}
    {{--<span class="task-count">0</span>--}}
    {{--<span class=""></span>--}}
    {{--</div>--}}
    {{--<div id="doing-tasks">--}}
    {{--<ul id="doing-foo">--}}
    {{--<li><input type="checkbox">doing 1</li>--}}
    {{--<li><input type="checkbox">doing 2</li>--}}
    {{--<li><input type="checkbox">doing 3</li>--}}
    {{--<li><input type="checkbox">doing 4</li>--}}
    {{--</ul>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div id="done" class="taskPanle">--}}
    {{--<div id="done-title" class="title">--}}
    {{--<span class="stage-name-title">已完成</span>--}}
    {{--<span class="task-count">0</span>--}}
    {{--<span class=""></span>--}}
    {{--</div>--}}
    {{--<div id="done-tasks">--}}
    {{--<ul id="done-foo">--}}
    {{--<li>done 1</li>--}}
    {{--<li>done 2</li>--}}
    {{--<li>done 3</li>--}}
    {{--<li>done 4</li>--}}
    {{--<li>done 5</li>--}}
    {{--<li>done 6</li>--}}
    {{--<li>done 7</li>--}}
    {{--<li>done 8</li>--}}
    {{--</ul>--}}
    {{--</div>--}}
    {{--<div id="done-addTask">--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

    <script type="text/javascript">

        //初始化
        $(document).ready(function(){

        });

        //+----------------------------------------------------------------------  
        //| 功能：测试咯  
        //| 说明：
        //| 参数：
        //| 返回值：
        //| 创建人：沈金龙
        //| 创建时间：2016-3-17 15:27:31
        //+----------------------------------------------------------------------
        function test(){

        }

    </script>
@stop