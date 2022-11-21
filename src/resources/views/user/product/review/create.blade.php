@extends('layouts.app')

@section('content')
<div>
    <h1>この商品をレビュー</h1>
    <img src="{{$product->product_image_file}}" alt="{{$product->product_image_file}}" width="100">
    <p>{{ $product->product_name }}</p>
    
    {{-- 高評価部分 --}}
    @if($rate)
        @if($rate->rate_type == 1)
        <form method="POST" action="{{ route('rate.destroy', [$product->product_id, $rate->rate_id])}}">
            @csrf
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit">
                <iconify-icon icon="icon-park-solid:good-two" style="color: #0072BC;"></iconify-icon>
            </button>
        </form>
        @else
        <form method="POST" action="{{ route('rate.update', [$product->product_id, $rate->rate_id])}}">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="rate_type" value="1">
            <button type="submit">
                <iconify-icon icon="icon-park-solid:good-two"></iconify-icon>
            </button>
        </form>
        @endif
    @else
        <form method="POST" action="{{ route('rate.store', $product->product_id)}}">
            @csrf
            <input type="hidden" name="rate_type" value="1">
            <button type="submit">
                <iconify-icon icon="icon-park-solid:good-two"></iconify-icon>
            </button>
        </form>
    @endif
    <p>{{ $product->highrateCounts }}</p>

    {{-- 低評価部分 --}}
    @if($rate)
        @if($rate->rate_type == 2)
        <form method="POST" action="{{ route('rate.destroy', [$product->product_id, $rate->rate_id])}}">
            @csrf
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit">
                <iconify-icon icon="icon-park-solid:bad-two" style="color: #0072BC;"></iconify-icon>
            </button>
        </form>
        @else
        <form method="POST" action="{{ route('rate.update', [$product->product_id, $rate->rate_id])}}">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="rate_type" value="2">
            <button type="submit">
                <iconify-icon icon="icon-park-solid:bad-two"></iconify-icon>
            </button>
        </form>
        @endif
    @else
        <form method="POST" action="{{ route('rate.store', $product->product_id)}}">
            @csrf
            <input type="hidden" name="rate_type" value="2">
            <button type="submit">
                <iconify-icon icon="icon-park-solid:bad-two"></iconify-icon>
            </button>
        </form>
    @endif
    <p>{{ $product->lowrateCounts }}</p>

    <p>-----------------------------</p>
    {{-- バリデーションエラーの表示 --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('review.confirm', $product->product_id) }}">
        @csrf
        <h1>タグ</h1>
        <p>タグを入力</p>
        <input type="text" id="tagTextbox">
        <button type="button" onclick="addTag()">タグを追加</button>

        {{-- ここに追加されたタグを表示 --}}
        <div id='tags'>
            @if(old('tags'))
                @foreach(old('tags') as $tag_name)
                    <div>
                        <p>{{ $tag_name }}</p>
                        <input class="tag_input" name="{{"tags[" . $loop->index . "]"}}" type="hidden" value="{{$tag_name}}">
                        <button type="button" onclick="removeTag(this)">x</button>
                    </div>
                @endforeach
            @endif
        </div>

        <p>------------------------------</p>
        <h1>レビュー内容</h1>
        <input type="text" name="review_content" value="{{ old('review_content') }}">
        <a href="{{ route('product.show', $product->product_id) }}">戻る</a>
        <input type="submit" value="レビューを確認">
    </form>
    
</div>

@endsection

<script>
    function removeTag(button) {
        let parent = button.parentNode;
        parent.remove();
    };

    function addTag() {
        let tags = document.getElementById('tags');
        
        let tagTextbox = document.getElementById('tagTextbox');

        // 空白文字を消す
        tagTextbox.value = tagTextbox.value.replace(/\s+/g, "");

        if(tagTextbox.value == "") {
            return 0;
        }

        // 表示用要素
        let newTagName = document.createElement("p");
        newTagName.textContent = tagTextbox.value;

        // 送信用要素
        let newTagSubmit = document.createElement("input");
        newTagSubmit.setAttribute("name", "tags[" + tagCount + "]");
        newTagSubmit.setAttribute("type", "hidden");
        newTagSubmit.setAttribute("value", tagTextbox.value);

        // 削除用ボタン
        let deleteButton = document.createElement("button");
        deleteButton.setAttribute("type", "button");
        deleteButton.textContent = "x"
        deleteButton.setAttribute("onclick", "removeTag(this)")

        // 上記の要素を一つのdivに入れて挿入
        let newDiv = document.createElement("div");
        newDiv.appendChild(newTagName);
        newDiv.appendChild(newTagSubmit);
        newDiv.appendChild(deleteButton);
        
        tags.appendChild(newDiv);

        // インプットの中身を削除
        tagTextbox.value = "";

        tagCount += 1;
    };

    let tagCount = 0;

    // タグの長さを取得
    window.addEventListener('DOMContentLoaded', () => {
        tagCount = document.getElementsByClassName('tag_input').length;
    })
    
</script>