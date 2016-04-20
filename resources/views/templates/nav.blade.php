
@if ($theme === 'black')
    <nav class="navbar navbar-inverse navbar-static-top">
@else
    <nav class="navbar navbar-default navbar-static-top">
@endif

    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/task"><span class="glyphicon glyphicon-queen"></span> TaskManager
            </a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                    <li><a href="/auth/login">登陆</a></li>
                    {{--<li><a href="/auth/register">Register</a></li>--}}
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">个人中心</a></li>
                            <li><a href="/auth/logout">注销</a></li>
                        </ul>
                    </li>
                @endif
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown"><a href="/panel">面板模式</a></li>
                <li class="dropdown"><a href="#" name="sync_task">同步任务</a></li>
                <li class="dropdown hidden"><a href="">我的任务</a></li>
                <li class="dropdown">
                    <!-- Small button group -->
                    <div class="btn-group" style="margin-top: 10px;">
                        <button type="button" class="btn btn-default">常用URL</button>
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            @foreach(config('params.common_urls') as $key=>$value)
                                <li ><a href="{{$value}}" target="_blank">{{$key}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                <li><a href="{{ URL('task/query') }}">任务查询</a></li>
		<li><a href="#">统计报表</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>