@extends('layouts.AdminLayout')

@section('title', 'Reviews and Feedbacks')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/layouts/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/reviews.css') }}">
@endsection

@section('main-content')
    <div class="content">
        <div class="page-header">
            <h2>Reviews and Feedbacks</h2>
        </div>
        <div class="page-content">
            <div class="review-container">
                @foreach ($reviews as $review)
                    <div class="review-item">
                        <div class="review-user">
                            <div class="image-holder">
                                <img src="{{ $review->user->image ?? asset('images/profile-placeholder.png') }}" alt="Member Image">
                            </div>
                            <div class="user-info">
                                <p>{{ $review->user->first_name }} {{ $review->user->last_name ?? '' }}</p>
                                <p>{{ $review->user->membership_type }} Member</p>
                            </div>
                        </div>
                        @if ($review->rating)
                            <div class="star-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="star {{ $i <= $review->rating ? 'selected' : '' }}">&#9733;</span>
                                @endfor
                                <p>{{ $review->created_at->format('n/j/Y') }}</p>
                            </div>
                        @endif

                        <p class="review-comment">{{ $review->comment }}</p>

                        <!-- Display Replies -->
                        <div class="replies">
                            @foreach($review->replies as $reply)
                                <div class="reply-item">
                                    <p>Admin {{ $reply->admin->first_name }} {{ $reply->admin->last_name }}:</p>
                                    <p>{{ $reply->reply }}</p>
                                </div>
                            @endforeach
                        </div>

                        <form method="POST" action="{{ route('review.reply', $review->id) }}" class="reply-form">
                            @csrf
                            <textarea name="reply" rows="1" placeholder="Write a reply..." required></textarea>
                            <button type="submit">Reply</button>
                        </form>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
@endsection