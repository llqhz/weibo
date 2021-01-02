@foreach(['danger', 'warning', 'success', 'info'] as $level)
  @if(session()->has($level))
    <div class="flash-message">
      <p class="alert alert-{{$level}} ">
        <a href="#" class="close" data-dismiss="alert">
          &times;
        </a>
        {{ session()->get($level)}}
      </p>
    </div>
  @endif
@endforeach
