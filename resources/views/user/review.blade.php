@extends('layouts.UserDesign')

@section('title', 'Module - Xtreme Gym World')

@section('head-access')
    <link rel="stylesheet" href="{{ asset('css/templates/userModules.css') }}">
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

            <h3>My Reviews</h3>

            <div class="user-content-button">
                <a href="#" id="openModalButton"><i class="fa-solid fa-plus"></i><span>Send a Review</span></a>
            </div>
             
        </div>
        <div class="user-main-content">
            <div class="main-section">
                <div class="review-container">
                    <div class="">
                    @forelse ($reviews as $review)
                        <div>
                            <p><strong>User:</strong> {{ $review->user->first_name }}</p>
                            <p><strong>Rating:</strong> {{ $review->rating }} &#9733;</p>
                            <p><strong>Comment:</strong> {{ $review->comment }}</p>
                            <p><strong>Date:</strong> {{ $review->created_at->format('F j, Y') }}</p>

                            @if ($review->replies->count())
                                <div class="admin-replies">
                                    <strong>Admin Replies:</strong>
                                    @foreach ($review->replies as $reply)
                                        <div class="reply-item">
                                            <strong>{{ $reply->admin->first_name }}:</strong>
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

    <div style="display: none;">
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
</div>

    <!-- Script -->
    <script src="{{ asset('js/star-rating.js')}}"></script>
@endsection

@section('js-container')
    <!-- Backup Js -->
@endsection