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
            <li class="list-group-item">
                <strong>{{$k+1}}</strong>.
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
            </li>
            @endforeach
        </ul>
    </div>
</div>
</body>
</html>
