@if($feed_items->isNotEmpty())
  <ul class="list-unstyled">
    @foreach($feed_items as $status)
      @include('statuses._status', ['user' => $status->user, 'status' => $status])
    @endforeach
  </ul>

  <dev class="mt-5">
    {!! $feed_items->render() !!}
  </dev>
@else
  <p>没有数据！</p>
@endif
