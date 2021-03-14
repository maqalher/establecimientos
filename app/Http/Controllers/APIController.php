<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Establecimiento;
use Illuminate\Http\Request;

class APIController extends Controller
{
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
}
