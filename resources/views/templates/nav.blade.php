
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
            <a class="navbar-brand" href="#">teambition
            </a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown"><a href="#">我的任务</a></li>
                <li><a href="dropdown">任务查询</a></li>
                <li><a href="dropdown">统计报表</a></li>
                <li><a href="dropdown">注销</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>