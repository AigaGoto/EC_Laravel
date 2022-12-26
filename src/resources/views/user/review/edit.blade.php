@extends('layouts.app')

@section('content')
<div>
    <h1>この商品のレビューを編集</h1>
    <img src="{{$product->product_image_file}}" alt="{{$product->product_image_file}}" width="100">
    <p>{{ $product->product_name }}</p>

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

    <form method="POST" action="{{ route('user.review.confirm', $review->review_id) }}">
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
            @elseif($tags)
                @foreach($tags as $tag)
                    <div>
                        <p>{{ $tag->tag_name }}</p>
                        <input class="tag_input" name="{{"tags[" . $loop->index . "]"}}" type="hidden" value="{{$tag->tag_name}}">
                        <button type="button" onclick="removeTag(this)">x</button>
                    </div>
                @endforeach
            @endif
        </div>

        <p>------------------------------</p>
        <h1>レビュー内容</h1>
        @if (old('review_content') || $errors->any())
            <input type="text" name="review_content" value="{{ old('review_content') }}">
        @else
            <input type="text" name="review_content"  value="{{ $review->review_content }}">
        @endif
        <a href="{{ route('user.review.index') }}">戻る</a>
        <input type="submit" value="レビューを確認">
    </form>

</div>

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
@endsection