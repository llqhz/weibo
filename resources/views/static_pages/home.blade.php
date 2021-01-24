@extends("/layouts/default")

@section('content')
   @if (Auth::check())
     <div class="row">
       <div class="col-md-8">
         <section class="status_form">
           @include('statuses._status_form')
         </section>
       </div>
       <aside class="col-md-4">
         <!-- 个人头像 -->
         <section class="user_info">
           @include('shared._user_info', ['user' => Auth::user()])
         </section>
         <!-- 个人头像 -->

         <!-- 关系统计 -->
         <section class="stats mt-2">
           @include('shared._stats', ['user' => Auth::user()])
         </section>
         <!-- 关系统计 -->
       </aside>
     </div>

     <div class="row">
       <div class="col-md-8">
         <!-- 用户动态 -->
         <section class="status">
           @include('shared._feed', ['feed_items' => $feed_items])
         </section>
         <!-- 用户动态 -->
       </div>
     </div>
   @else
     <div class="jumbotron">
       <h1>Hello Laravel</h1>
       <p class="lead">
         你现在所看到的是 <a href="https://learnku.com/courses/laravel-essential-training">Laravel 入门教程</a> 的示例项目主页。
       </p>
       <p>
         一切，将从这里开始。
       </p>
       <p>
         <a href="{{ route('signup') }}" class="btn btn-lg btn-success" role="button">现在注册</a>
       </p>
     </div>
   @endif
@endsection
