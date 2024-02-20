<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\File;
use App\Models\Like;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { 
        $posts = Post::all();
        if ($posts) {
            return response()->json([
                'success' =>true,
                'data' =>$posts,
            ],200);
        }else{
            return response()->json([
                'success' =>false,
                'message' =>'error al llistar els posts',
            ],500);
        }
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        // if(empty($post)){
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'post no trobat'
        //     ],404);
        // }
        
        
        // Validar fitxer
          $validatedData = $request->validate([
            'upload' => 'required|mimes:gif,jpeg,jpg,png|max:1024',
            'body'          => 'required',
            'latitude'      => 'required|numeric',
            'longitude'     => 'required|numeric',
            

        ]);

        // Obtenir dades del fitxer
        $upload = $request->file('upload');
        $fileName = $upload->getClientOriginalName();
        $fileSize = $upload->getSize();
        Log::debug("Storing file '{$fileName}' ($fileSize)...");

         // Pujar fitxer al disc dur
         $uploadName = time() . '_' . $fileName;
         $filePath = $upload->storeAs(
             'uploads',      // Path
             $uploadName ,   // Filename
             'public'        // Disk
         );
        
         if (Storage::disk('public')->exists($filePath)) {
             Log::debug("Disk storage OK");
             $fullPath = Storage::disk('public')->path($filePath);
             Log::debug("File saved at {$fullPath}");
             // Desar dades a BD
             $file = File::create([
                 'filepath' => $filePath,
                 'filesize' => $fileSize,
                 
             ]);
             Log::debug("DB storage OK");
             $post = Post::create([
                 'body' =>$request->body,
                 'file_id' =>$file->id,
                 'latitude' =>$request->latitude,
                 'longitude' =>$request->longitude,
                 'visibility_id'=>1,
                 'author_id' =>1
 
             ]);
             Log::debug("DB Storage OK");
             return response()->json([
                'success' => true,
                'data'    => $post
                ], 200);
         }else{
            return response()->json([
                'success'  => false,
                'message' => 'Error uploading post'
            ], 500);
         }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        if (Storage::disk('public')->exists($post->file->filepath)) {
            // Cargar el conteo de 'likes' para el post
            $post->loadCount('liked');
     
            return response()->json([
                'success' => true,
                'data' => $post,
            ], 200);
        } else {
            // Redirigir si el archivo no existe
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar un post',
            ], 404);
        };   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::find($id);
         // Validar fitxer
       $validatedData = $request->validate([
        'upload' => 'required|mimes:gif,jpeg,jpg,png|max:1024'
    ]);

    // Obtenir dades del fitxer
    $upload = $request->file('upload');
    $fileName = $upload->getClientOriginalName();
    $fileSize = $upload->getSize();
    \Log::debug("Storing file '{$fileName}' ($fileSize)...");

    // Pujar fitxer al disc dur
    $uploadName = time() . '_' . $fileName;
    $filePath = $upload->storeAs(
        'uploads',      // Path
        $uploadName ,   // Filename
        'public'        // Disk
    );
    if (Storage::disk('public')->exists($filePath)) {
        Storage::disk('public')->delete($post->file->filepath);
        Log::debug("Local storage OK");
        $fullPath = Storage::disk('public')->path($filePath);
        Log::debug("File saved at {$fullPath}");
        // Desar dades a BD
        $post->file->filepath=$filePath;
        $post->file->filesize=$fileSize;
        $post->file->save();
        Log::debug("DB storage OK");
        // Patró PRG amb missatge d'èxit

        $post->body = $request->body;
        $post->longitude = $request->longitude;
        $post->latitude = $request->latitude;
        $post->save();

    
        return response()->json([
            'success' => true,
            'data' => $post,
        ],200);
    } else {
        Log::debug("Local storage FAILS");
        // Patró PRG amb missatge d'error
        return response()->json([
            'success' => false,
            'message' => 'error al actualitzar el post'
        ], 421);
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //borramos archivo local
        $post = Post::find($id);
        if($post){
            Storage::delete($post->file->filepath);
            
            //borramos el post
            $post->delete();

            //borramos en base de datos
            $post->file->delete();

            return response()->json([
                'success' => true,
                'data' => $post,
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Archivo no encontrado',
            ], 404);

        }
    }

    public function like(Request $request,string  $id)
    {
        $post = Post::find($id);
        $this->authorize('like', $post);
        $like =Like::where('user_id',1)
                    ->where('post_id',1 )
                    ->first();
        
        if($like){
            $like->delete();
            Log::debug("Like eliminado correctamente");
            return response()->json([
                'success' => true,
                'message' => 'like deleted'
            ], 200);

        }else{
            $like = Like::create([
                'user_id' => auth()->user()->id,
                'post_id' => $post->id,
            ]);
            $isLiked=True;
            Log::debug("Like creado correctamente");
            return response()->json([
                'success' => true,
                'message' => 'liked',
            ], 200);
            
        }
    }


    //metodo update API
    public function update_workaround(Request $request, $id)
    {
        return $this->update($request, $id);
    }
}
