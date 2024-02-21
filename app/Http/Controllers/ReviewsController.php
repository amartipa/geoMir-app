<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewsController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $review = new Review();
        $review->user_id = auth()->user()->id;
        $review->place_id = $request->input('place_id');
        $review->message = $request->input('message');
        $review->save();

        return redirect()->back()->with('success', 'Review created successfully.');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully.');
    }
}
