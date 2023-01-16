<div class="review-item">
    <div class="review-item-top">
        @include('layouts.userIcon', ['user_icon_image'=>$review->user->user_icon_image])
        <p class="review-user-name">{{$review->user->user_name}}</p>
        <p class="review-time">{{ $review->updated_at->format('Y/m/d H:i:s') }}</p>
    </div>
    <div class="review-tag-block">
        @foreach($review->tags as $tag)
            <p class="tag review-tag">{{  $tag->tag_name }}</p>
        @endforeach
    </div>
    <p class="review-content">{{ $review->review_content }}</p>
</div>