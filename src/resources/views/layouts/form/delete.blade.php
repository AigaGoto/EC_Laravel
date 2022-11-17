<form method="POST" action="{{ $action }}">
    @csrf
    <input type="hidden" name="_method" value="DELETE">
    <button type="submit">
        <iconify-icon icon="icon-park-solid:good-two" style="color: #0072BC;"></iconify-icon>
    </button>
</form>