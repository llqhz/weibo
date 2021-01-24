<a href="{{ route('users.followings', [$user]) }}">
  <strong id="followings" class="stat">
    {{ $user->followings()->count() }}
  </strong>
  关注
</a>

<a href="{{ route('users.followers', [$user]) }}">
  <strong id="followers" class="stat">
    {{ $user->followers()->count() }}
  </strong>
  粉丝
</a>

<a href="{{ route('users.show', [$user]) }}">
  <strong id="statuses" class="stat">
    {{ $user->statuses()->count() }}
  </strong>
  微博
</a>
