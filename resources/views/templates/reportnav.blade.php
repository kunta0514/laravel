@extends('templates.default')
@section('content')
    <div class="container">
        <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="/task/history">本月</a></li>
            <li role="presentation"><a href="#">Profile</a></li>
            <li role="presentation"><a href="#">Messages</a></li>
        </ul>
    </div>
    @yield('content_test')
@stop