
@extends('layouts.default')
@section('title', '主页')

@section('content')
    <div class="jumbotron">
        <h1>Hello Laravel</h1>
        <p class="lead">你现在所看到的是 <a href="http://weibo.test">Laravel 入门教程</a>的示例主页</p>
        <p>一切，将从这里开始。</p>
        <p>
            @if(!Auth::check())
            <a class='btn btn-lg btn-success' href="{{ route('signup') }}" role='button'>现在注册</a>
            @endif
        </p>
    </div>
@stop