<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Place;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Auth;


class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->authorizeResource(Place::class,'place');
    }
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
   
            // Realizar la búsqueda en la base de datos
            $places = Place::withCount('favorited')
            ->where('name', 'like', "%$searchTerm%")
            ->paginate(5);
           
            return view('places.index', compact('places'));
        } else {
            $places = Place::withCount('favorited')
            ->orderBy('id', 'desc')
            ->paginate(5);            
            return view("places.index", [
                "places" => $places]);
        }
        }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("places.create");
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
                'author_id' =>auth()->user()->id,
            ]);
            Log::debug("DB Storage OK");
            return redirect()->route('places.show', $place)
                ->with('success','Place creat correctament');
        } else {
            Log::debug("Disk storage FAILS");
            // Patró PRG amb missatge d'error
            return redirect()->route("places.create")
                ->with('error', 'ERROR uploading file');
        }
    }

    /**
     * Display the specified resource.
     */

    public function show(Place $place)
    {
        //
        $place->loadCount('favorited');

        if (Storage::disk('public')->exists($place->file->filepath)) {
            return view("places.show", [
                "place" => $place
            ]);
        } else {
            return redirect()->route("places.index")
                ->with('error', 'ERROR: El archivo no existe');
        }; 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Place $place)
    {
        //
        return view("places.edit", [
            "place" => $place
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Place $place)
    {
       // Validar fitxer
       $validatedData = $request->validate([
        'upload' => 'required|mimes:gif,jpeg,jpg,png|max:1024'
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

    
        return redirect()->route('places.show', $place)
            ->with('success', ('Place actualizado'));
    } else {
        Log::debug("Local storage FAILS");
        // Patró PRG amb missatge d'error
        return redirect()->route("places.edit")
            ->with('error', ('ERROR: Problema al editar el place'));
    }
                      
           
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Place $place)
    {
        Storage::delete($place->file->filepath);
        $place->delete();
        $place->file->delete();
        return redirect()->route("places.index")->with('success', 'Place eliminado correctamente');
    }
    // public function favorite(Request $request, Place $place)
    // {
    //     $user = Auth::user();

    //     if ($user->isFavorited($place)) {
    //         // Si ya es favorito, quitar de favoritos
    //         $user->favorites()->detach($place->id);
    //         return redirect()->back()->with('success', 'Place eliminado de favoritos');
    //     } else {
    //         // Si no es favorito, añadir a favoritos
    //         $user->favorites()->attach($place->id);
    //         return redirect()->back()->with('success', 'Place añadido a favoritos');
    //     }
    // }
    // public function unfavorite(Request $request, Place $place)
    // {
    //     $user = Auth::user();

    //     if ($user->isFavorited($place)) {
    //         // Si es favorito, quitar de favoritos
    //         $user->favorites()->detach($place->id);
    //         return redirect()->back()->with('success', 'Place eliminado de favoritos');
    //     } else {
    //         // Si no es favorito, mostrar algún mensaje de error
    //         return redirect()->back()->with('error', 'Place no está en la lista de favoritos');
    //     }
    // }
    // public function favourite(Place $place){
    //     if (Favourite::where('user_id',auth()->user()->id)->where('place_id', $place->id )->first()){
    //         return redirect()->route('places.show', $place)
    //         ->with('error', __("fpp.place-favourite-error"));
    //     }else{
    //         $favourite = Favourite::create([
    //             'user_id' => auth()->user()->id,
    //             'place_id' => $place->id,
    //         ]);
    //         return redirect()->back()
    //         ->with('success', __("fpp.place-favourite"));
    //     }
    // }

    // public function unfavourite(Place $place){
    //     if (Favourite::where('user_id',auth()->user()->id)->where('place_id', $place->id )->first()){
    //         Favourite::where('user_id',auth()->user()->id)
    //                  ->where('place_id', $place->id )->delete();;
    //         return redirect()->back()
    //         ->with('success', __("fpp.place-unfavourite"));
    //     }else{
    //         return redirect()->route('places.show', $place)
    //         ->with('error', __("fpp.place-unfavourite-error"));
    //     }
    // }
    public function favorite (Request $request, Place $place){
        $favorite = Favorite::where('user_id',auth()->user()->id)->where('place_id', $place->id )->first();
        if($favorite){
            $favorite->delete();
            Log::debug("Fav eliminado");
            return redirect()->route("places.index");
        } else {
            $favorite = Favorite::create([
                'user_id' => auth()->user()->id,
                'place_id' => $place->id,
            ]);
            return redirect()->back();
            Log::debug("Fav creat");
        }

    }
}
