@extends('layouts.default')

@section('title', '登录')

@section('content')
  <div class="offset-md-2 col-md-8">
    <div class="card">
      <div class="card-header">
        <h5>登录</h5>
      </div>

      <div class="card-body">
        @include('shared._errors')

        <form action="{{ route('login') }}" method="post">
          {{ csrf_field() }}

          <div class="form-group">
            <label for="email">邮箱：</label>
            <input id="email" type="text" name="email" class="form-control" value="{{ old('email') }}">
          </div>

          <div class="form-group">
            <label for="password" id="password">
              密码：
              <a href="{{ route('password.request') }}" title="点击重置密码">忘记密码 ?</a>
            </label>
            <input id="password" type="password" name="password" class="form-control" value="{{ old('password') }}">
          </div>

          <div class="form-group">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" name="remember" id="remember">
              <label class="form-check-label" for="remember">记住我</label>
            </div>
          </div>

          <button class="btn btn-primary" type="submit">登录</button>
        </form>

        <hr>

        <p>还没账号？<a href="{{ route('signup') }}">现在注册！</a></p>
      </div>
  </div>
@endsection
