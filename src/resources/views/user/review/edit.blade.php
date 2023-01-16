@extends('layouts.app')

@section('content')
<div class="main-container">
    <h1>この商品のレビューを編集</h1>
    <div class="product-top">
        <img src="{{$product->product_image_file}}" alt="{{$product->product_image_file}}">
        <p>{{ $product->product_name }}</p>
    </div>

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
        <div class="review-create-tag-block">
            <h1>タグ</h1>
            <p>タグを入力</p>
            <input class="tag-input" type="text" id="tagTextbox">
            <button class="gray-button" type="button" onclick="addTag()">タグを追加</button>

            <p class="review-add-tag-text">追加するタグ</p>
            {{-- ここに追加されたタグを表示 --}}
            <div id='tags' class="review-add-tags">
                @if(old('tags'))
                    @foreach(old('tags') as $tag_name)
                        <div class="tag-wrapper">
                            <span class="tag add-tag">{{ $tag_name }}</span>
                            <input class="tag_input" name="{{"tags[" . $loop->index . "]"}}" type="hidden" value="{{$tag_name}}">
                            <button class="tag-delete-button" type="button" onclick="removeTag(this)">
                                <iconify-icon icon="material-symbols:cancel" />
                            </button>
                        </div>
                    @endforeach
                @elseif($tags)
                    @foreach($tags as $tag)
                        <div class="tag-wrapper">
                            <span class="tag add-tag">{{ $tag->tag_name }}</span>
                            <input class="tag_input" name="{{"tags[" . $loop->index . "]"}}" type="hidden" value="{{$tag->tag_name}}">
                            <button class="tag-delete-button" type="button" onclick="removeTag(this)">
                                <iconify-icon icon="material-symbols:cancel" />
                            </button>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="review-create-reviewcontent-block">
            <h1>レビュー内容</h1>
            @if (old('review_content') || $errors->any())
                <textarea class="review-input" type="text" name="review_content" >{{ old('review_content') }}</textarea>
            @else
                <textarea class="review-input" type="text" name="review_content">{{ $review->review_content }}</textarea>
            @endif
        </div>

        <div class="after-content">
            <a class="left-button white-button" href="{{ route('user.review.index') }}">戻る</a>
            <input class="gray-button" type="submit" value="レビューを確認">
        </div>
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
        let newTagName = document.createElement("span");
        newTagName.textContent = tagTextbox.value;
        newTagName.classList.add("tag", "add-tag");

        // 送信用要素
        let newTagSubmit = document.createElement("input");
        newTagSubmit.setAttribute("name", "tags[" + tagCount + "]");
        newTagSubmit.setAttribute("type", "hidden");
        newTagSubmit.setAttribute("value", tagTextbox.value);

        // 削除用ボタン
        let deleteButton = document.createElement("button");
        deleteButton.setAttribute("type", "button");
        deleteButton.setAttribute("onclick", "removeTag(this)")
        deleteButton.classList.add("tag-delete-button");
        let deleteIcon = document.createElement("iconify-icon");
        deleteIcon.setAttribute("icon", "material-symbols:cancel")
        deleteButton.appendChild(deleteIcon);

        // 上記の要素を一つのdivに入れて挿入
        let newDiv = document.createElement("div");
        newDiv.appendChild(newTagName);
        newDiv.appendChild(newTagSubmit);
        newDiv.appendChild(deleteButton);
        newDiv.classList.add("tag-wrapper");

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