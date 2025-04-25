<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ReviewRep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function show()
    {
        $reviews = Review::with('replies.admin')->orderBy('created_at', 'DESC')->get(); // Eager load replies and their admins
        return view('admin.reviews.reviews', compact('reviews'));
    }

    public function create()
    {
        $reviews = Review::with('replies.admin')
            ->where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'DESC')
            ->get();
    
        return view('user.review', compact('reviews'));
    }

























    public function reply(Request $request, Review $review)
    {
        $validated = $request->validate([
            'reply' => 'required|string|max:1000',
        ]);

        $reviewRep = new ReviewRep();
        $reviewRep->review_id = $review->id;
        $reviewRep->admin_id = Auth::id();
        $reviewRep->reply = $validated['reply'];
        $reviewRep->save();

        return redirect()->back()->with('success', 'Reply posted successfully!');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating' => 'nullable|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);
    
        $review = new Review();
        $review->user_id = Auth::user()->id;
        $review->type = 'Review';
        $review->rating = $validated['rating'];
        $review->comment = $validated['comment'];
        $review->save();
    
        return redirect()->back()->with('success', 'Thank you for your review!');
    }
}
