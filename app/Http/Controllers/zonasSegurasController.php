<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\zonasSeguras;

class zonasSegurasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $zonas = zonasSeguras::all();
        return view('zonasSeguras.index', compact('zonas'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('zonasSeguras.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $datos = [
            'nombre' => $request->nombre,
            'radio' => $request->radio,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'tipo' => $request->tipo
        ];

        zonasSeguras::create($datos);
        return redirect()->route('zonasSeguras.index')->with('message', 'Zona segura creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $zona = zonasSeguras::findOrFail($id);
        return view('zonasSeguras.show', compact('zona'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $zona = zonasSeguras::findOrFail($id);
        return view('zonasSeguras.edit', compact('zona'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $zona = zonasSeguras::findOrFail($id);
        $zona->update([
            'nombre' => $request->nombre,
            'radio' => $request->radio,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'tipo' => $request->tipo
        ]);

        return redirect()->route('zonasSeguras.index')->with('message', 'Zona segura actualizada correctamente');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $zona = zonasSeguras::findOrFail($id);
        $zona->delete();
        return redirect()->route('zonasSeguras.index')->with('message', 'Zona segura eliminada');
    
    }
}
