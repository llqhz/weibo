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

        <!-- 用户动态 -->
        <section class="status">
          @include('shared._feed', ['feed_items' => $statuses])
        </section>
        <!-- 用户动态 -->
      </div>
    </div>
  </div>
@endsection
