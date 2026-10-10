<?php

namespace App\Http\Controllers\Api\Almacenes;

use App\Http\Controllers\Controller;
use App\Models\Almacen; 
use Illuminate\Http\Request;

class AlmacenController extends Controller
{
    /**
     * Listar todos los registros (Read - GET)
     */
    public function index()
    {
        $almacenes = Almacen::all();
        return response()->json([
            'status' => true,
            'message' => 'Listado de almacenes recuperado con éxito, bro',
            'data' => $almacenes
        ], 200);
    }

    /**
     * Guardar un nuevo registro (Create - POST)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio'      => 'required|numeric'
        ]);

        $nuevo = Almacen::create([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio'      => $request->precio
        ]);

        return response()->json([
            'status' => true,
            'message' => '¡Guardado por API con éxito en la URL oficial, bro!',
            'data' => $nuevo
        ], 201);
    }

    /**
     * Actualizar un registro existente (Update - PUT)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio'      => 'required|numeric'
        ]);

        $almacen = Almacen::find($id);
        if (!$almacen) {
            return response()->json(['status' => false, 'message' => 'No encontrado'], 404);
        }

        $almacen->update([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio'      => $request->precio
        ]);

        return response()->json([
            'status' => true,
            'message' => '¡Registro actualizado de forma exitosa!'
        ], 200);
    }

    /**
     * Eliminar un registro (Delete - DELETE)
     */
    public function destroy($id)
    {
        $almacen = Almacen::find($id);
        if (!$almacen) {
            return response()->json(['status' => false, 'message' => 'No encontrado'], 404);
        }

        $almacen->delete();

        return response()->json([
            'status' => true,
            'message' => '¡Registro eliminado correctamente de phpMyAdmin!'
        ], 200);
    }
}
