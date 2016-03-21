@extends('templates.default')
@section('content')
    <style type="text/css">
        .panel-heading {
            color: #333;
            background-color: #fcfcfc;
            border: 1px solid #ddd;
            border-bottom: none;
        }
        .panel-default>.panel-heading {
            color: #333;
            background-color: #f5f5f5;
            border-color: #ddd;
        }
        .panel-heading {
            padding: 0 15px;
            padding-bottom: 5px;
            border-bottom: 1px solid transparent;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
        }
        .topics-index .topic-filter {
            color: #d0d0d0;
            font-size: 12px;
        }

        .remove-margin-bottom {
            margin-bottom: 0;
        }
        .pull-right {
            float: right!important;
        }
        .list-inline {
            padding-left: 0;
            margin-left: -5px;
            list-style: none;
        }
        .list-inline>li {
            display: inline-block;
            padding-right: 5px;
            padding-left: 5px;
        }
        *, :after, :before {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        #solution_list li {
            display: list-item;
            text-align: -webkit-match-parent;
            float: left;
        }
        .topic-filter {
            color: #d0d0d0;
            font-size: 12px;
        }
        .list-inline {
            padding-left: 0;
            margin-left: -5px;
            list-style: none;
        }
        .topic-filter li a {
            padding: 1px 2px;
            color: #778087;
            text-decoration: none;
        }
        .clearfix a {
            background: 0 0;
        }
        .clearfix a:-webkit-any-link {
            color: -webkit-link;
            text-decoration: underline;
            cursor: auto;
        }
        .panel-body {
            border: 1px solid #ddd;
        }
        .remove-padding-horizontal {
            padding-bottom: 0;
            padding-top: 0;
        }
        .list-group {
            margin-bottom: 0;
            padding-left: 0;
        }
        .row {
            margin-right: -15px;
            margin-left: -15px;
        }
        ol, ul {
            margin-top: 0;
            margin-bottom: 10px;
        }
        ul, menu, dir {
            display: block;
            list-style-type: disc;
            -webkit-margin-before: 1em;
            -webkit-margin-after: 1em;
            -webkit-margin-start: 0px;
            -webkit-margin-end: 0px;
            -webkit-padding-start: 40px;
        }
        .list-group .list-group-item:first-child {
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        .list-group li {
            margin-top: 0;
        }
        .topic-list a, .topic-list a:focus, .topic-list a:hover {
            color: #555;
        }
        .fa {
            display: inline-block;
            font-family: FontAwesome;
            font-style: normal;
            font-weight: 400;
            line-height: 1;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .meta a, .operate a {
            padding: 1px 2px;
            color: #B9BDC0;
            text-decoration: none;
        }
        .meta, .operate {
            color: #d0d0d0;
            font-size: 12px;
        }
        .badge-reply-count {
            margin: 15px 20px;
            background-color: #8BAFCE;
        }
        .badge {
            display: inline-block;
            min-width: 10px;
            padding: 3px 7px;
            font-size: 12px;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            background-color: #777;
            border-radius: 10px;
        }
        .panel {
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 4px;
            -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
            box-shadow: 0 1px 1px rgba(0,0,0,.05);
        }
        .panel .panel-body {
            border: 1px solid #ddd;
        }
        .panel-body {
            padding: 15px;
        }
    </style>
    {{--solutionlist-- start---}}
    <div id="solution_list" class="col-md-9">
        {{--header start--}}
        <div class="panel-heading">
            <ul class="pull-right list-inline remove-margin-bottom topic-filter">
                <li>
                    <a href="/solution?filter=recent">
                        <i class="glyphicon glyphicon-time"></i> 最近发表
                    </a>
                    <span class="divider"></span>
                </li>
                <li>
                    <a href="/solution?filter=excellent" class="selected">
                        <i class="glyphicon glyphicon-ok"> </i> 精华主题
                    </a>
                    <span class="divider"></span>
                </li>
                <li>
                    <a href="/solution?filter=vote">
                        <i class="glyphicon glyphicon-thumbs-up"> </i> 最多投票
                    </a>
                    <span class="divider"></span>
                </li>
                <li>
                    <a href="/solution?filter=noreply">
                        <i class="glyphicon glyphicon-eye-open"></i> 无人问津
                    </a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        {{--header end--}}

        {{--list content start--}}

        <div class="panel-body remove-padding-horizontal" style="padding-top: 0;padding-bottom: 0px;">
            <ul class="list-group row topic-list">
                @foreach($solutions as $k=>$value)
                <li class="list-group-item media 1" style="margin-top: 0px;">

                    <a class="pull-right" href="#">
                        <span class="badge badge-reply-count"> {{$value->hit_count}} </span>
                    </a>

                    <div class="avatar pull-left">
                        <a href="#">
                            <img class="media-object img-thumbnail avatar" alt="lvht" src="https://dn-phphub.qbox.me/uploads/avatars/633_1439791013.jpeg?imageView2/1/w/80/h/80" style="width:48px;height:48px;">
                        </a>
                    </div>

                    <div class="infos">
                        <div class="media-heading">
                            <a href="{{URL('solution/show').'/'.$value->id}}" title="{{$value->solution_title}}">
                                {{$value->solution_title}}
                            </a>
                        </div>
                        <div class="media-body meta">
                            <a href="https://phphub.org/topics/1825" class="remove-padding-left" id="pin-1825">
                                <span class="glyphicon glyphicon-thumbs-up"> 1 </span>
                            </a>
                            <span> •  </span>
                            <a href="#" title="Laravel" 1="">
                                {{$value->solution_type}}
                            </a>


                            <span> • </span>最后由
                            <a href="#">
                                {{$value->author_name}}
                            </a>
                            <span> • </span>
                            <span class="timeago">9小时前</span>
                        </div>

                    </div>

                </li>
                @endforeach
            </ul>
        </div>
        {{--list content end--}}

        {{--分页--}}
        <?php echo $solutions->render(); ?>
        {{--分页--}}

    </div>
    {{--solutionlist-- start---}}
    <div id="side_bar" class="col-md-3">
        <div class="panel panel-default corner-radius">
            <div class="panel-body text-center">
                <div class="btn-group">
                    <a href="{{URL('solution/create')}}" class="btn btn-success btn-lg" target="_blank">
                        <i class="glyphicon glyphicon-pencil"> </i> 发 布 新 帖
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function(){



        });
    </script>
@stop