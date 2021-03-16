<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Establecimiento;
use App\Imagen;
use Illuminate\Http\Request;

class APIController extends Controller
{


    // Metodo para obtener todos los establecimientos
    public function index()
    {
        // $establecimientos = Establecimiento::all();
        $establecimientos = Establecimiento::with('categoria')->get(); // incluye el nombre de la categoria

        return response()->json($establecimientos);
    }

    // Metodo para obtener todas las categorias
    public function categorias()
    {
        $categorias = Categoria::all();

        return response()->json($categorias);
    }

    // Muestra los establecimientos de la categoria especifico
    public function categoria(Categoria $categoria)
    {
        // dd($categoria);

        // $estableciminetos = Establecimiento::where('categoria_id', $categoria->id)->get();
        $estableciminetos = Establecimiento::where('categoria_id', $categoria->id)->with('categoria')->take(3)->get();
        // $estableciminetos = Establecimiento::where('categoria_id', $categoria->id)->with('categoria')->get(); // with trea los datos de la categoria con la que esta relacionada

        return response()->json($estableciminetos);
    }

    // Muestra un establecimiento en espesifico
    public function show(Establecimiento $establecimiento){

        $imagenes = Imagen::where('id_establecimiento', $establecimiento->uuid)->get(); //relacionar las imagenes con el establecimiento
        $establecimiento->imagenes = $imagenes; // agregar  imagenes al objeto

        return response()->json($establecimiento);
    }
}
