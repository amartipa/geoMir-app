<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)

    {

        if ($request->has('search')) {

            $searchTerm = $request->input('search');

   

            // Realizar la búsqueda en la base de datos

            $places = Place::where('description', 'like', "%$searchTerm%")->paginate(5);

   

            return view('places.index', compact('places'));

        } else {

            return view("places.index", [

                "places" => Place::paginate(5),

            ]);

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
}

