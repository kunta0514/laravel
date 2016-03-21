@extends('templates.default')
@section('content')
    <script type="text/javascript" src="vendor/js/angular.min.js"></script>
    <script type="text/javascript" src="vendor/js/Sortable.js"></script>
    <script type="text/javascript" src="vendor/js/ng-sortable.js"></script>

    <style>

        .main{
            background-color: #F4D7C9;
            height: 650px;
            width:1300px;
        }

        .container {
            width: 100%;
            margin: auto;
            min-width: 1100px;
            max-width: 1300px;
            position: relative;
            /*margin-top: 500px;*/
            /*bottom: -10px;*/
            /*top:600px;*/
        }

        .tile {
            width: 22%;
            min-width: 245px;
            color: #FF7270;
            padding: 10px 30px;
            text-align: center;
            margin-top: 15px;
            margin-left: 5px;
            margin-right: 30px;
            background-color: #fff;
            display: inline-block;
            vertical-align: top;
        }
        .tile__tx {
            cursor: move;
            padding-bottom: 10px;
            border-bottom: 1px solid #FF7373;
        }
        .tile__tx img{
            border-radius:50%;
        }
        .tile__list {
            margin-top: 10px;
        }

        .tile__list ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .tile__list ul li{
            width: 100%;
            /*border: 0.5px solid red;*/
            padding-top: 5px;
            cursor:move;
        }

        .tile__list:last-child {
            margin-right: 0;
            min-height: 80px;
        }

    </style>

    <div class="main">
        <div class="container">
            <div id="multi">
                <div class="layer tile">
                    <div class="tile__tx">
                        <img src="/vendor/imgs/face-03.jpg">
                    </div>
                    <div class="tile__list">
                        <ul>
                            <li>我爱你中国</li>
                            <li>我爱你中国</li>
                            <li>我爱你中国</li>
                            <li>我爱你中国</li>
                        </ul>
                    </div>
                </div>
                <div class="layer tile">
                    <div class="tile__tx">
                        <img src="/vendor/imgs/face-04.jpg">
                    </div>
                    <div class="tile__list">
                        <ul>
                            <li>job 1</li>
                            <li>job 2</li>
                            <li>job 3</li>
                            <li>job 4</li>
                        </ul>
                    </div>
                </div>
                <div class="layer tile">
                    <div class="tile__tx">
                        <img src="/vendor/imgs/face-05.jpg">
                    </div>
                    <div class="tile__list">
                        <ul>
                            <li>job 1</li>
                            <li>job 2</li>
                            <li>job 3</li>
                            <li>job 4</li>
                        </ul>
                    </div>
                </div>
                <div class="layer tile">
                    <div class="tile__tx">
                        <img src="/vendor/imgs/face-06.jpg">
                    </div>
                    <div class="tile__list">
                        <ul>
                            <li>job 1</li>
                            <li>job 2</li>
                            <li>job 3</li>
                            <li>job 4</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

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