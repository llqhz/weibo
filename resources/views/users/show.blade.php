@extends("layouts/default")

@section('title', $user->name)

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="offset-md-2 col-md-8">
        <!-- 用户详情 -->
        <section class="user_info">
          @include('shared/_user_info', ['user' => $user])
        </section>
        <!-- 用户详情 -->

        <!-- 关注按钮 -->
        {{-- 用check判断是否已登录, 已登录的用户才展示关注按钮 --}}
        @if(\Auth::check())
          @include('users._follow_form', ['user' => $user])
        @endif
        <!-- 关注按钮 -->

        <!-- 关系统计 -->
        <section class="stats mt-2">
          @include('shared._stats', ['user' => $user])
        </section>
        <!-- 关系统计 -->

        <!-- 用户动态 -->
        <section class="status">
          @include('shared._feed', ['feed_items' => $statuses])
        </section>
        <!-- 用户动态 -->
      </div>
    </div>
  </div>
@endsection
