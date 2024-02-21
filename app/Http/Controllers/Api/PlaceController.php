<?php

namespace App\Http\Controllers\Api;

use App\Models\File;
use App\Models\Place;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;


class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $places = Place::all();
        if ($places) {
            return response()->json([
                'success' =>true,
                'data' =>$places,
            ],200);
        }else{
            return response()->json([
                'success' =>false,
                'message' =>'error al llistar els places',
            ],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar fitxer
        $validatedData = $request->validate([
            'upload' => 'required|mimes:gif,jpeg,jpg,png|max:1024',
            'name' => 'required',
            'description' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
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
            // Patró PRG amb missatge d'èxit
            $place = Place::create([
                'name' =>$request->name,
                'description' =>$request->description,
                'file_id' =>$file->id,
                'latitude' =>$request->latitude,
                'longitude' =>$request->longitude,
                'visibility_id'=>1,
                'author_id' =>1
            ]);
            Log::debug("DB Storage OK");
            return response()->json([
                'success' => true,
                'data' => $place,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error al editar',
            ], 500);
        }
    }
    /**

     * Display the specified resource.
     */

    public function show(string $id)
    {
        //
        $place = Place::find($id);
        if ($place) {
            $place->loadCount('favorited');
     
            return response()->json([
                'success' => true,
                'data' => $place,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar un place',
            ], 404);
        }; 
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $place = Place::find($id);
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
        Storage::disk('public')->delete($place->file->filepath);
        Log::debug("Local storage OK");
        $fullPath = Storage::disk('public')->path($filePath);
        Log::debug("File saved at {$fullPath}");
        // Desar dades a BD
        $place->file->filepath=$filePath;
        $place->file->filesize=$fileSize;
        $place->file->save();
        Log::debug("DB storage OK");
        // Patró PRG amb missatge d'èxit

        $place->name = $request->name;
        $place->description = $request->description;
        $place->longitude = $request->longitude;
        $place->latitude = $request->latitude;
        $place->save();

    
        return response()->json([
            'success' => true,
            'data' => $place,
        ],200);
    } else {
        Log::debug("Local storage FAILS");
        // Patró PRG amb missatge d'error
        return response()->json([
            'success' => false,
            'message' => 'error al actualitzar el place'
        ], 421);
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $place = Place::find($id);
        if($place){
            Storage::delete($place->file->filepath);
            
            $place->delete();

            $place->file->delete();

            return response()->json([
                'success' => true,
                'data' => $place,
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Archivo no encontrado',
            ], 404);

        }
    }
    
    public function favorite(Request $request,string  $id)
    {
        $place = Place::find($id);
        // $this->authorize('favorite', $place);
        $favorite =Favorite::where('user_id',1)
                    ->where('place_id',1 )
                    ->first();
        
        if($favorite){
            $favorite->delete();
            Log::debug("Favorite eliminado correctamente");
            return response()->json([
                'success' => true,
                'message' => 'favorite deleted'
            ], 200);

        }else{
            $favorite = Favorite::create([
                'user_id' => (auth()->user()->id) ? : 1,
                'place_id' => $place->id,
            ]); 
            $isFavorited=True;
            Log::debug("Favorite creado correctamente");
            return response()->json([
                'success' => true,
                'message' => 'favorited',
            ], 200);
            
        }
    }

    public function update_workaround(Request $request, $id)
    {
        return $this->update($request, $id);
    }
}
