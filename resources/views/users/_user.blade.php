<div class="list-group-item">
  <img class="mr-3" src="{{ $user->gravatar() }}" alt="{{ $user->name }}" width="32" />
  <a href="{{ route('users.show', $user) }}">
    {{ $user->name }}
  </a>

  <!-- 管理员删除功能 -->
  @can('destroy', $user)
    <form method="post" action="{{ route('users.destroy', $user) }}" class="float-right">
      {{ csrf_field() }}
      {{ method_field('delete') }}

      <button type="submit" class="btn btn-sm btn-danger">删除</button>
    </form>
  @endcan
</div>
