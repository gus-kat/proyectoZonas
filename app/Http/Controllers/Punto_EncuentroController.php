<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Http\Request;
use App\Models\Punto_Encuentro;
class Punto_EncuentroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Ver la lista 
        $punto = Punto_Encuentro::all();
        return view("puntos.index", compact("punto"));
    }
    public function mapa()
    {
        $punto = Punto_Encuentro::all();
        return view('puntos.mapa', compact('punto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $puntos = Punto_Encuentro::all();
        return view("puntos.nuevo",compact('puntos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verificar si se subió una imagen
        if ($request->hasFile('imagen')) {
            $ruta_imagen = $request->file('imagen')->store('imagenes', 'public');
        } else {
            $ruta_imagen = 'sin imagen';
        }

        // Capturar valores y almacenarlos en base de datos
        $punto = [
            'nombre' => $request->nombre,
            'capacidad' => $request->capacidad,
            'responsable' => $request->responsable,
            'imagen' => $ruta_imagen,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
        ];

        Punto_Encuentro::create($punto);

        return redirect()->route('puntos.index')->with('mensaje', 'Punto creado correctamente');
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

        // Buscar punto por id
        $punto = Punto_Encuentro::findOrFail($id);
        // Retornar vista de edición pasando el punto
        
        return view('puntos.editar', compact('punto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $punto = Punto_Encuentro::findOrFail($id);

        if ($request->hasFile('imagen')) {
            // Opcional: eliminar imagen antigua 
            if ($punto->imagen && \Storage::disk('public')->exists($punto->imagen)) {
                \Storage::disk('public')->delete($punto->imagen);
            }
            $ruta_imagen = $request->file('imagen')->store('imagenes', 'public');
        } else {
            $ruta_imagen = $punto->imagen;
        }

        $punto->update([
            'nombre' => $request->nombre,
            'capacidad' => $request->capacidad,
            'responsable' => $request->responsable,
            'imagen' => $ruta_imagen,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
        ]);

        return redirect()->route('puntos.index')->with('mensaje', 'Punto actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (auth()->user()->role !== 'Administrador') {
            return redirect()->route('puntos.index')->with('mensaje', 'No tienes permisos para eliminar zonas Seguras')->with('tipo', 'error');
       
        }
        $punto = Punto_Encuentro::findOrFail($id);

        if ($punto->imagen && $punto->imagen !== 'sin imagen') {
            if (Storage::disk('public')->exists($punto->imagen)) {
                Storage::disk('public')->delete($punto->imagen);
            } else {
                logger("La imagen no existe en disco: " . $punto->imagen);
            }
        }

        $punto->delete();

        return redirect()->route('puntos.index')->with('mensaje', 'Punto eliminado correctamente.');
    }
}
