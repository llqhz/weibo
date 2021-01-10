<?php
    // 转换密码重置成功提示
    if (session()->has('status')) {
        session()->flash('success', session()->pull('status'));
    }
?>
@foreach(['danger', 'warning', 'success', 'info'] as $level)
  @if(session()->has($level))
    <div class="flash-message">
      <p class="alert alert-{{$level}} ">
        <a href="#" class="close" data-dismiss="alert">
          &times;
        </a>
        {{ session()->pull($level)}}
      </p>
    </div>
  @endif
@endforeach
