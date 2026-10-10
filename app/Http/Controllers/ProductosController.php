<?php

namespace App\Http\Controllers;

use App\Models\Almacen; 
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    /**
     * Muestra el formulario azul y la tabla gris de la derecha
     */
    public function create()
    {
        // Traemos todos los almacenes guardados en phpMyAdmin
        $almacenes = Almacen::all();

        // Se los mandamos a tu vista dentro de la carpeta productos
        return view('productos.index', compact('almacenes'));
    }

    /**
     * Recibe los datos de los cuadros de texto y los guarda
     */
    public function store(Request $request)
    {
        // 1. Validamos que el usuario llene los cuadros obligatoriamente
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio'      => 'required|numeric'
        ]);

        // 2. Guardamos la información en la tabla 'almacens' de tu base de datos
        Almacen::create([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio'      => $request->precio
        ]);

        // 3. Regresa al formulario automáticamente y actualiza la tabla de la derecha
        return redirect()->route('productos.create')->with('success', '¡Guardado con éxito!');
    }
}
