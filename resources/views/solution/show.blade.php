@extends('templates.default')
@section('content')

    <style type="text/css">
         .panel-heading {
            color: #333;
            background-color: #fcfcfc;
            border: 1px solid #ddd;
            border-bottom: none;
        }
        .panel-heading {
            padding: 10px 15px;
            border-bottom: 1px solid transparent;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
        }
        .pull-right {
            float: right!important;
        }
          .topic-title {
             font-size: 22px;
             color: #333;
             text-align: left;
             line-height: 135%;
             margin-bottom: 8px;
             font-weight: 700;
         }
         .meta, .operate {
             color: #d0d0d0;
             font-size: 12px;
         }
         .meta a, .operate a {
             padding: 1px 2px;
             color: #B9BDC0;
             text-decoration: none;
         }
         .panel-title {
             margin-top: 0;
             margin-bottom:10px;
             font-size: 16px;
             color: inherit;
         }
         h1 {
             display: block;
             font-size: 2em;
             -webkit-margin-before: 0.67em;
             -webkit-margin-after: 0.67em;
             -webkit-margin-start: 0px;
             -webkit-margin-end: 0px;
             font-weight: bold;
         }
        .content
        {
            border: 1px solid #ddd;
            border-top: none;
            padding: 0 5px;;
        }
        .content div, .content p{
            overflow: auto;
        }
        .bottom_bar{
            padding: 0 10px;
        }
    </style>

    <div class="infos panel-heading">

        <div class="pull-right avatar_large">
            <a href="https://phphub.org/users/633">
                <img src="https://dn-phphub.qbox.me/uploads/avatars/633_1439791013.jpeg?imageView2/1/w/80/h/80" style="width:65px; height:65px;" class="img-thumbnail avatar">
            </a>
        </div>

        <h1 class="panel-title topic-title">{{$solution->solution_title}}</h1>

        <div class="meta inline-block">

            <a href="https://phphub.org/nodes/8" class="remove-padding-left">
                Laravel
            </a>
            •
            <a href="https://phphub.org/users/633">
                lvht
            </a>

            •
            于 <abbr title="2016-03-03 10:07:40" class="timeago">4天前</abbr>
            •

            最后由
            <a href="https://phphub.org/users/569">
                nickfan
            </a>
            于 <abbr title="2016-03-06 11:47:03" class="timeago">1天前</abbr>
            •

            415 阅读
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="content">
        {{print $solution->solution_content}}
    </div>

    <div class="bottom_bar">
        <nav>
            <ul class="pager">
                <li class="previous"><a href="#"><span aria-hidden="true">&larr;</span>上一篇</a></li>
                <li class="next"><a href="#">下一篇 <span aria-hidden="true">&rarr;</span></a></li>
            </ul>
        </nav>
    </div>
@stop