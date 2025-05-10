@extends('layouts.UserDesign')

@section('title', 'Reviews - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/templates/userModules.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/ratings.css') }}">
@endsection

@section('main-content')
    <!-- Design -->
    <style>
        .main-section {
            height: 100%;
            width: 100%;
            padding: 0 10px 10px;
        }
    </style>

    <!-- Structure -->
    <div class="user-content-container">
        <div class="user-content-header">
            <div class="custom-header">
                <a href="{{ route('user.settings')}}"><i class="fa-solid fa-arrow-left"></i></a>
                <h3>My Reviews</h3>
            </div>
        </div>
        <div class="user-main-content">
            <div class="main-section">
                <div class="review-container">
                    <div class="">
                        <div class="rw-review-form">
                            <h1>Write a Review</h1>
                            
                            <form action="{{ route('review.store') }}" method="POST">
                                @csrf
                            
                                <!-- Star Rating -->
                                <label for="rating">Your Rating:</label>
                                <div class="star-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="star" data-value="{{ $i }}">&#9733;</span>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="rating" value="">
                            
                                <!-- Comment -->
                                <label for="comment">Leave a Comment:</label>
                                <textarea name="comment" required></textarea>
                            
                                <button type="submit">Submit Review</button>
                            </form>
                        </div>
                        
                        <h4 style="margin: 10px 0 5px;">Your Reviews and Feedbacks:</h4>

                        @forelse ($reviews as $review)
                            <div class="review-item">
                                <p>{{ $review->user->first_name ?? ''}} {{ $review->user->last_name ?? ''}}<span style="margin: 0 0.5rem;">&bull;</span>{{ $review->created_at->format('F j, Y') }}</p>
                                <p><strong>Rating:</strong> {{ $review->rating }} <span style="color: #f5b301; font-size: medium;">&#9733;</span></p>
                                <p><strong>Comment:</strong> {{ $review->comment }}</p>

                                @if ($review->replies->count())
                                    <div class="admin-replies">
                                        @foreach ($review->replies as $reply)
                                            <div class="reply-item">
                                                <strong>Admin {{ $reply->admin->first_name }} Replied:</strong>
                                                <p>{{ $reply->reply }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p><strong>No admin replies yet.</strong></p>
                                @endif
                            </div>
                        @empty
                            <p>You have not submitted any reviews yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <!-- Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stars = document.querySelectorAll('.star-rating .star');
            const ratingInput = document.getElementById('rating');

            stars.forEach(star => {
                star.addEventListener('click', function () {
                    const value = this.getAttribute('data-value');
                    ratingInput.value = value;

                    // Remove 'selected' class from all stars
                    stars.forEach(s => s.classList.remove('selected'));

                    // Add 'selected' class to the clicked star and all previous stars
                    for (let i = 0; i < value; i++) {
                        stars[i].classList.add('selected');
                    }
                });
            });
        });

    </script>
@endsection

@section('js-container')
    <!-- Backup Js -->
@endsection