<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Log;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
     public function index()
    {
        $files = File::all();

        if ($files) {
            return response()->json([
                'success' =>true,
                'data' =>$files,
            ],200);
        }else{
            return response()->json([
                'success' =>false,
                'message' =>'error al llistar els arxius',
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
            'upload' => 'required|mimes:gif,jpeg,jpg,png|max:2048'
        ]);
        // Desar fitxer al disc i inserir dades a BD
        $upload = $request->file('upload');
        $file = new File();
        $ok = $file->diskSave($upload);
 
 
        if ($ok) {
            return response()->json([
                'success' => true,
                'data'    => $file
            ], 201);
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'Error uploading file'
            ], 500);
        }
    }
 

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $file = File::find($id);
        if ($file) {
            return response()->json([
                'success' => true,
                'data' => $file,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar un archivo',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $file = File::find($id);
        if(empty($file)){
            return response()->json([
                'success' => false,
                'message' => 'arxiu no trobat'
            ],404);
        }

        // Validar fitxer
         $validatedData = $request->validate([
            'upload' => 'required|mimes:gif,jpeg,jpg,png|max:2048'
        ]);

       

        if($file){
            //borrem arxiu existent
            $file->diskDelete();

            //guardem el nou arxiu
            $upload = $request->file('upload');
            $ok = $file->diskSave($upload);

            if($ok){
                return response()->json([
                    'success' => true,
                    'data' => $file,
                ],200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'error al actualitzar el arxiu'
                ], 421);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $file = File::find($id);

        if ($file) {
            $file->diskDelete();
            $file->delete();

            return response()->json([
                'success' => true,
                'data' => $file,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Archivo no encontrado',
            ], 404);
        }
    }

    //metodo update API
    public function update_workaround(Request $request, $id)
    {
        return $this->update($request, $id);
    }
 
}
