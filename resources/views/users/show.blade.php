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
          @if($statuses->count() > 0)
            <ul class="list-unstyled">
              @foreach($statuses as $status)
                @include('statuses._status', ['user' => $user, 'status' => $status])
              @endforeach
            </ul>

            <dev class="mt-5">
              {!! $statuses->render() !!}
            </dev>
          @else
            <p>没有数据！</p>
          @endif
        </section>
        <!-- 用户动态 -->
      </div>
    </div>
  </div>
@endsection
