<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>TaskManager</title>
    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- 可选的Bootstrap主题文件（一般不用引入） -->
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="col-xs-12" style="margin-top: 20px;">
        <ul class="list-group">
            @foreach($tasks as $k=>$task)
            <li class="list-group-item" style="min-height: 50px;">
                <div style="display: table;width: 100%">
                <div class="div_left" style="width: 85%;float: left;">
                    <strong>{{$k+1}}</strong>.
                    @if(stristr($task->ekp_task_type, 'BUG'))
                        <span class="label label-danger" style="padding: .1em .6em 0em;">B</span>
                    @elseif(stristr($task->ekp_task_type, '咨询'))
                        <span class="label label-info" style="padding: .1em .6em 0em;">咨</span>
                    @elseif(stristr($task->ekp_task_type, '需求'))
                        <span class="label label-success" style="padding: .1em .6em 0em;">需</span>
                    @else
                        <span class="label label-primary" style="padding: .1em .6em 0em;">{{mb_substr($task->ekp_task_type,0,1)}}</span>
                    @endif
                    {{$task->task_title}}
                    <div class="red" style="font-weight:bolder;background-color: #ff3c00;color: #fff;font-size: 12px;margin-top: 5px;width:92px;padding: 1px;border-radius: 4px;text-align: center;">
                        {{$task->task_no}}
                    </div>
                </div>
                <div class="div_right" style="vertical-align:top;line-height: 25px;width:25px;float: right;text-align: center;border-radius: 100px;-moz-transition-duration: 0.8s;background-color: orange;color: white;font-weight: bold;">
                    @if($task->developer) {!!substr(AppHelper::user_name($task->developer),0,3)!!}@endif
                </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
</body>
</html>
