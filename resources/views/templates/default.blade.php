<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>TeamBition</title>

    <!-- Bootstrap core CSS -->
    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="//apps.bdimg.com/libs/jqueryui/1.10.4/css/jquery-ui.min.css" rel="stylesheet">
    <link href="{{asset('vendor/css/datatables.css')}}" rel="stylesheet">

    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <script src="//apps.bdimg.com/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
    <script src="{{asset('vendor/js/datatables.js')}}"></script>
    <![endif]-->
    <style type="text/css">
        @media screen and (min-width: 1200px){.mycontainer {width: 95%;}}
        @media screen and (min-width: 992px){.mycontainer {width: 970px;}}
        @media screen and (min-width: 768px){} .mycontainer { width: 750px;}
    </style>
</head>
<body>
    @include('templates.nav')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @yield('content')
            </div>
        </div>


    </div>
{{--    @include('templates.footer')--}}
</body>