<form action="{{ route('statuses.store') }}" method="post">
  @include('shared._errors')
  {{ csrf_field() }}
  <div class="form-group">
    <label for="content">发表动态</label>
    <textarea class="form-control" name="content" id="content" rows="3"  placeholder="聊聊新鲜事儿...">{{ old('content') }}</textarea>
  </div>

  <div class="text-right">
    <button type="submit" class="btn btn-primary btn-sm">提交</button>
  </div>
</form>
