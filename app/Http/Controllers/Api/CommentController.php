<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;

class CommentController extends Controller
{
    public function comment(Request $request, string $id) 
    {
        $validatedData = $request->validate([
            'message'  => 'required',
        ]);

        $comment = Comment::create([
            'user_id'  => (auth()->user()->id) ? : 1,
            'post_id' => $id,
            'message' => $request->get('message')
        ]);

        if ($comment){
            return response()->json([
                'success' => true,
                'data' => $comment
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'comentari no trobat'
            ], 404);
        };
    }

    public function unComment($id) 
    {

        $post = Post::find($id);
        $comment = Comment::where([

            ['user_id',  '=', (auth()->user()->id) ? : 1],
            ['post_id', '=', $id],
        ])->first();

        $ok = $comment->delete();

        if ($ok){
            return response()->json([
                'success' => true,
                'data' => $comment
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'comentari no trobat'
            ], 404);
        };
    }
}
