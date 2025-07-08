<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZonasRiesgo;

class ZonaRiesgoController extends Controller
{
    /**
     * Mostar el mapa de las zonas.
     */

    public function verMapa()
    {
        $zonas = ZonasRiesgo::all();
        return view('zonasRiesgo.mapaZonas', compact('zonas'));
    }
    public function index()
    {
        //Ver la lista 
        $zonas=ZonasRiesgo::all();
        //Renderizar la vista y pasan los datos 
        return view('zonasRiesgo.index',compact('zonas'));
        
    }

    /**
     * Show the form for creating a new resource.   
     */
    public function create()
    {
        //
        $zonas = ZonasRiesgo::all(); // Asegúrate que este modelo existe y esté importado
        return view('zonasRiesgo.nueva', compact('zonas'));
         
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'nivelRiesgo' => 'required|string',
        'latitud1' => 'required|numeric',
        'longitud1' => 'required|numeric',
        'latitud2' => 'required|numeric',
        'longitud2' => 'required|numeric',
        'latitud3' => 'required|numeric',
        'longitud3' => 'required|numeric',
        'latitud4' => 'required|numeric',
        'longitud4' => 'required|numeric',
    ]);

    // Asumiendo que tienes modelo ZonaRiesgo con fillable correcto
    ZonasRiesgo::create($request->all());
    return redirect()->route('zonasRiesgo.index')->with('mensaje', 'Zona de riesgo creada correctamente.')->with('tipo', 'success');


   

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //7
        $zona = ZonasRiesgo::findOrFail($id);
        return view('zonasRiesgo.editar', compact('zona'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
         $zona = ZonasRiesgo::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|min:3',
            'descripcion' => 'nullable|string|max:255',
            'nivelRiesgo' => 'required|string',
            'latitud1' => 'required|numeric',
            'longitud1' => 'required|numeric',
            'latitud2' => 'required|numeric',
            'longitud2' => 'required|numeric',
            'latitud3' => 'required|numeric',
            'longitud3' => 'required|numeric',
            'latitud4' => 'required|numeric',
            'longitud4' => 'required|numeric',
        ]);

        $zona->nombre = $request->nombre;
        $zona->descripcion = $request->descripcion;
        $zona->nivelRiesgo = $request->nivelRiesgo;
        $zona->latitud1 = $request->latitud1;
        $zona->longitud1 = $request->longitud1;
        $zona->latitud2 = $request->latitud2;
        $zona->longitud2 = $request->longitud2;
        $zona->latitud3 = $request->latitud3;
        $zona->longitud3 = $request->longitud3;
        $zona->latitud4 = $request->latitud4;
        $zona->longitud4 = $request->longitud4;

        $zona->save();
        return redirect()->route('zonasRiesgo.index')->with('mensaje', 'Zona de riesgo actualizada correctamente')->with('tipo', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        if (auth()->user()->rol !== 'administrador') {
            return redirect()->route('zonasRiesgo.index')->with('mensaje', 'No tienes permisos para eliminar zonas de riesgo')->with('tipo', 'error');
       
        }

        $zona = ZonasRiesgo::findOrFail($id);
        $zona->delete();
        return redirect()->route('zonasRiesgo.index')->with('mensaje', 'Zona de riesgo eliminada correctamente')->with('tipo', 'success');


    }
}
