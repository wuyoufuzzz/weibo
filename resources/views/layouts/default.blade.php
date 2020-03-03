<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Weibo App') - Laravel新手入门教程</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
    
    <div class='container'>
        @include('layouts._header') 
        @include('shared._messages')
        @yield('content')
        @include('layouts._footer')
    </div>
</body>
</html>