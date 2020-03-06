<form action="{{ route('statuses.store') }}" method="post">
    @include('shared._error')
    {{ csrf_field() }}
    <textarea class="form-control" name="content" id="" rows="3" placeholder="现在的心情..."></textarea>
    <div class="text-right">
        <button type="submit" class="btn mt-3 btn-primary">发布</button>
    </div>
</form>