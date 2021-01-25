<li class="media mt-4 mb-4">
  <a href="{{ route('users.show', [$user]) }}">
    <img src="{{ $user->gravatar() }}" alt="{{ $user->name }}" class="mr-3 gravatar"/>
  </a>
  <div class="media-body">
    <h5 class="mt-0 mb-1">{{ $user->name }} <small> / {{ $status->created_at->diffForHumans() }}</small></h5>
    {!! $status->content !!}
  </div>

  @can('destroy', $status)
    <form method="post"
          action="{{ route('statuses.destroy', [$status]) }}"
          onsubmit="return confirm('您确定要删除本条微博吗？');"
    >
      {{ csrf_field() }}
      {{ method_field('delete') }}
      <button type="submit" class="btn btn-danger btn-sm">删除</button>
    </form>
  @endcan
</li>
