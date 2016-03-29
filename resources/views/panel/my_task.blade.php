@extends('templates.default2')
@section('content')

    {{--说明：View视图-我的任务--}}
    {{--作者：沈金龙--}}
    {{--时间：2016-3-28 15:48:24--}}

    <script src="{{asset('vendor/js/angular.min.js')}}"></script>
    <script src="{{asset('vendor/js/Sortable.js')}}"></script>
    <script src="{{asset('vendor/js/ng-sortable.js')}}"></script>

    <style>
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
        a{
            text-decoration: none;
            color: grey;
        }
        a:hover{
            color:#03a9f4;
            text-decoration: none;
        }
        h3{
            margin:0 20px;
            padding:15px 0;
            line-height:20px;
            font-size:18px;
            border-bottom:4px solid rgba(0,0,0,.07);
        }
        .my-view{
            transform: translate(0px,0px);
            position: fixed;
            z-index: 51;
            top:50px;
            left:0px;
            bottom: 0px;
            width: 100%;
            background-size: cover;
            background-position: 50%;
            background-color: hsla(0,0%,93%,.96);
        }
        .my-header{
            position: relative;
            height: 60px;
            overflow: hidden;
            border-bottom:1px solid rgba(0,0,0,.07);
            display:flex;
        }
        .my-content-wrap{
            position: absolute;
            top: 60px;
            bottom: 30px;
            width: 100%;
            padding-top: 20px;
            overflow-y: auto;
            overflow-x:hidden;
        }
        .my-content-card{
            position: relative;
            margin: 0 auto;
            width: 960px;
            min-height: 100%;
            border: 0 none;
            background-color: #FFF;
            border-radius:2px;
        }
        .my-recent-view{
            opacity: 1;
        }
        .task-list{
            margin-bottom: 40px;
        }
        .my-list{
            padding-bottom: 10px;
            margin: 5px 0 0;
        }
        /*任务模块*/
        .task-priority {
            position: absolute;
            width: 10px;
            min-height: 38px;
            /*height: 100%;*/
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
        .check-box-fast-done{
            float: left;
            margin-top:3px;
            margin-right: 5px;
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
            margin-left: 50px;
        }
        .task-content-pic {
            width: 24px;
            height: 24px;
            float: left;
            margin-top: -2px;
        }
        .task-content-wrapper {
            position: relative;
            padding-right: 140px;
            cursor: pointer;
        }
        .task-content {
            margin: 0;
            padding: 0;
            width: 100%;
            border: 0 none;
            background: none;
            cursor: pointer;
        }
        .task-tag{
            margin-left: 5px;
        }
        .task-duedate{
            position: absolute;
            top:50%;
            right:15px;
            margin-top:-10px ;
            font-size: 12px;
        }
        /*任务模块*/
        .label{
            font-weight:400;
            border-radius: 2px;
        }
        .label-important{
            color: #FF3C00;
        }
        .task:hover{
            background-color:#EEEEEE;
        }
    </style>

    <div class="my-view">
        <div class="my-header"></div>
        <div class="my-content-wrap">
            <div class="my-content-card">
                <section class="my-recent-view">
                    <div class="today-tasks">
                        <h3> 今天的事 ·
                            <span class="count">1</span>
                        </h3>
                        <ul class="task-list my-list">
                            {{--@foreach($tasks["tasks_ing"] as $k=>$task)--}}
                                {{--@if($task->status==0)--}}
                                    <li class="task" rel="" data-id="">
                                        <div class="task-priority task-priority-2" rel="">
                                            <a class="task-priority-hint"></a>
                                        </div>
                                        <a class="check-box">
                                            <span class="icon icon-tick"></span>
                                        </a>
                                        <div class="task-content-set">
                                            <div class="task-content-wrapper">
                                                <div class="task-content" rel="">
                                                    任务系统：截止日期及完成日期的标示
                                                    <a class="task-tag">#Selonsy</a>
                                                </div>
                                                <time class="task-duedate label label-important">
                                                    <span class=""></span>
                                                    <span>上周五</span>
                                                </time>
                                            </div>
                                        </div>
                                    </li>
                                {{--@endif--}}
                            {{--@endforeach--}}
                        </ul>
                    </div>
                    <div class="tomorrow-tasks"></div>
                    <div class="week-tasks"></div>
                    <div class="task-placeholder"></div>
                </section>
            </div>
        </div>
        <footer class="my-footer"></footer>
    </div>

    <script type="text/javascript">

        //初始化
        $(document).ready(function(){

        });

        //+----------------------------------------------------------------------  
        //| 功能： 
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