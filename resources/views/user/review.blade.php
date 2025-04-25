<style>
.star-rating {
    display: flex;
    flex-direction: row;
}

.star {
    font-size: 2rem;
    color: #ccc;
    cursor: pointer;
    transition: color 0.2s;
}

.star.selected {
    color: #f5b301;
}

.review-history {
    margin-top: 20px;
}

.review-item {
    margin-bottom: 20px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.admin-reply {
    margin-top: 10px;
    background-color: #f9f9f9;
    padding: 10px;
    border-left: 5px solid #f5b301;
}

.admin-replies {
    margin-top: 10px;
    padding-left: 20px;
    border-left: 2px solid #f0f0f0;
}

.reply-item {
    margin-bottom: 10px;
}

textarea {
    width: 100%;
    margin-bottom: 10px;
}
</style>

<h1>Write a Review</h1>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif
@if(session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif

<form action="{{ route('review.store') }}" method="POST">
    @csrf

    <!-- Star Rating -->
    <label for="rating">Rating:</label>
    <div class="star-rating">
        @for ($i = 1; $i <= 5; $i++)
            <span class="star" data-value="{{ $i }}">&#9733;</span>
        @endfor
    </div>
    <input type="hidden" name="rating" id="rating" value="">

    <!-- Comment -->
    <label for="comment">Comment:</label>
    <textarea name="comment" required></textarea>

    <button type="submit">Submit</button>
</form>

<h2>Your Reviews</h2>
@foreach ($reviews as $review)
    <div>
        <strong>{{ $review->user->name }}</strong> ({{ $review->type }})
        @if ($review->rating)
            - {{ $review->rating }} Star{{ $review->rating > 1 ? 's' : '' }}
        @endif
        <p>{{ $review->comment }}</p>

        @if ($review->reply)
            <div>
                <strong>Admin Reply:</strong>
                <p>{{ $review->reply->reply }}</p>
            </div>
        @endif
    </div>
@endforeach

<!-- Display Replies -->
<div class="replies">
    @foreach($review->replies as $reply)
        <div class="reply-item">
            <strong>{{ $reply->admin->name }}:</strong>
            <p>{{ $reply->reply }}</p>
        </div>
    @endforeach
</div>

@forelse ($reviews as $review)
    <div class="review-item">
        <p><strong>Rating:</strong> {{ $review->rating }} &#9733;</p>
        <p><strong>Comment:</strong> {{ $review->comment }}</p>
        <p><strong>Date:</strong> {{ $review->created_at->format('F j, Y') }}</p>

        <!-- Admin Reply -->
        @if ($review->reply)
            <div class="admin-reply">
                <strong>Admin Reply:</strong> {{ $review->reply->reply }}
                <p>By: Admin {{ $review->reply->admin->first_name }} {{ $review->reply->admin->last_name }}</p>
            </div>
        @endif
    </div>
@empty
    <p>You have not submitted any reviews yet.</p>
@endforelse
