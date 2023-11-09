<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("files.index", [
            "files" => File::all()
        ]);
    }
 

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("files.create");
    }
 

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
            return redirect()->route('files.show', $file)
                ->with('success', 'File successfully saved');
        } else {
            Log::debug("Disk storage FAILS");
            // Patró PRG amb missatge d'error
            return redirect()->route("files.create")
                ->with('error', 'ERROR uploading file');
        }
    }
 

    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
      
        if (Storage::disk('public')->exists($file->filepath)) {
            return view("files.show", [
                "file" => $file
            ]);
        } else {
            return redirect()->route("files.index")
                ->with('error', 'ERROR: El archivo no existe');
        };   
    }
 

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $file)
    {
        //
        return view("files.edit", [
            "file" => $file
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, File $file)
    {
        //
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
            Storage::disk('public')->delete($file->filepath);
            Log::debug("Local storage OK");
            $fullPath = Storage::disk('public')->path($filePath);
            Log::debug("File saved at {$fullPath}");
            // Desar dades a BD
            $file->filepath=$filePath;
            $file->filesize=$fileSize;
            $file->save();
            Log::debug("DB storage OK");
            // Patró PRG amb missatge d'èxit
            return redirect()->route('files.show', $file)
                ->with('success', ('Fichero actualizado'));
        } else {
            Log::debug("Local storage FAILS");
            // Patró PRG amb missatge d'error
            return redirect()->route("files.edit")
                ->with('error', ('ERROR: Problema al editar el fichero'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        Log::info('destruyo fichero en local'. $file->id);
        //borramos archivo local
        Storage::delete($file->filepath);
        
        Log::info('destruyo fichero en BD '. $file->id);
        //borramos en base de datos
        $file->delete();
        return redirect()->route("files.index")->with('success', 'Archivo eliminado correctamente');



    }
}
