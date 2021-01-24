{{-- 用户有关注权限(不能关注自己),才进行展示 --}}
@can('follow', $user)
  <div class="text-center mt-2 mb-4">
      {{-- 如果已关注,则展示取消关注 --}}
    @if(\Auth::user()->isFollowing($user))
      <form action="{{ route('followers.destroy', [$user]) }}" method="post">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-sm btn-outline-primary">取消关注</button>
      </form>
    @else
      {{-- 如果未关注,则展示关注按钮 --}}
      <form action="{{ route('followers.store', [$user]) }}" method="post">
        @csrf
        @method('post')
        <button type="submit" class="btn btn-sm btn-primary">关注</button>
      </form>
    @endif
  </div>
@endcan

