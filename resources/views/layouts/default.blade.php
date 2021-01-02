<!DOCTYPE html>
<html lang="zh-CH">
  <head>
    <title>@yield("title", "Weibo App") - Laravel 新手入门教程</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  </head>
  <body>
    @include("layouts._header")

    <div class="container">
      @include('shared._message')

      @yield('content')

      @include("layouts._footer")
    </div>
  </body>

  <script src="{{ mix('js/app.js') }}"></script>
</html>
