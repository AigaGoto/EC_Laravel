<div class="rate-button-block">
    {{-- 高評価部分 --}}
    <div class="high-rate">
        @if($rate)
        @if($rate->rate_type == Consts::RATE_HIGH)
        <form method="POST" action="{{ route('user.product.rate.destroy', [$product->product_id, $rate->rate_id])}}">
            @csrf
            <input type="hidden" name="_method" value="DELETE">
            <button class="rate-button" type="submit">
                <iconify-icon icon="icon-park-solid:good-two" style="color: #0072BC;"></iconify-icon>
            </button>
        </form>
        @else
        <form method="POST" action="{{ route('user.product.rate.update', [$product->product_id, $rate->rate_id])}}">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="rate_type" value="{{Consts::RATE_HIGH}}">
            <button class="rate-button" type="submit">
                <iconify-icon icon="icon-park-solid:good-two"></iconify-icon>
            </button>
        </form>
        @endif
        @else
        <form method="POST" action="{{ route('user.product.rate.store', $product->product_id)}}">
            @csrf
            <input type="hidden" name="rate_type" value="{{Consts::RATE_HIGH}}">
            <button class="rate-button" type="submit">
                <iconify-icon icon="icon-park-solid:good-two"></iconify-icon>
            </button>
        </form>
        @endif
        <span>{{ $product->highrateCounts }}</span>
    </div>

    {{-- 低評価部分 --}}
    <div class="low-rate">
        @if($rate)
            @if($rate->rate_type == Consts::RATE_LOW)
            <form method="POST" action="{{ route('user.product.rate.destroy', [$product->product_id, $rate->rate_id])}}">
                @csrf
                <input type="hidden" name="_method" value="DELETE">
                <button class="rate-button" type="submit">
                    <iconify-icon icon="icon-park-solid:bad-two" style="color: #0072BC;"></iconify-icon>
                </button>
            </form>
            @else
            <form method="POST" action="{{ route('user.product.rate.update', [$product->product_id, $rate->rate_id])}}">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="rate_type" value="{{Consts::RATE_LOW}}">
                <button class="rate-button" type="submit">
                    <iconify-icon icon="icon-park-solid:bad-two"></iconify-icon>
                </button>
            </form>
            @endif
        @else
            <form method="POST" action="{{ route('user.product.rate.store', $product->product_id)}}">
                @csrf
                <input type="hidden" name="rate_type" value="{{Consts::RATE_LOW}}">
                <button class="rate-button" type="submit">
                    <iconify-icon icon="icon-park-solid:bad-two"></iconify-icon>
                </button>
            </form>
        @endif
        <span>{{ $product->lowrateCounts }}</span>
    </div>
</div>