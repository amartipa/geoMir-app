<?php

namespace App\Http\Controllers\Api;

use App\Models\File;
use App\Models\Place;
use App\Models\Favorite;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;


class ReviewsController extends Controller
{
    public function review(Request $request, string $id) 
    {
        $validatedData = $request->validate([
            'message'  => 'required',
        ]);

        $review = Review::create([
            'user_id'  => (auth()->user()->id) ? : 1,
            'place_id' => $id,
            'message' => $request->get('message')
        ]);

        if ($review){
            return response()->json([
                'success' => true,
                'data' => $review
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'arxiu no trobat'
            ], 404);
        };
    }

    public function unreview($id) 
    {

        $place = Place::find($id);
        $review = Review::where([

            ['user_id',  '=', (auth()->user()->id) ? : 1],
            ['place_id', '=', $id],
        ])->first();

        $ok = $review->delete();

        if ($ok){
            return response()->json([
                'success' => true,
                'data' => $review
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'arxiu no trobat'
            ], 404);
        };
    }
}