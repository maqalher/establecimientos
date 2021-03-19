<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Establecimiento;
use App\Imagen;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class EstablecimientoController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Consultar las Categorias
        $categorias = Categoria::all();
        return view("estableciminetos.create", compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validacion

        $data = $request->validate([
            'nombre' => 'required',
            'categoria_id' => 'required|exists:App\Categoria,id',  // dede de exixstir el modelo(tabla ) e id
            'imagen_principal' => 'required|image|max:2000',  // tipo imagen y maximo de 2m
            'direccion' => 'required',
            'colonia' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'telefono' => 'required|numeric',
            'descripcion' => 'required',
            'apertura' => 'date_format:H:i', // formato de fecha requerido hora:minutos
            'cierre' => 'date_format:H:i|after:apertura', // formato de fecha requerido hora:minutos y despues de apertura
            'uuid' => 'required|uuid',
        ]);

        // Guaradr la imagen
        $ruta_imagen = $request['imagen_principal']->store('principales', 'public');

        // Rezise a la imagen
        $img = Image::make( public_path("storage/{$ruta_imagen}"))->fit(800, 600);
        $img->save();

        // Guardar en la BD

        $establecimiento = new Establecimiento($data);
        $establecimiento->imagen_principal = $ruta_imagen;
        $establecimiento->user_id = auth()->user()->id;
        $establecimiento->save();

        // auth()->user()->establecimiento()->create([
        //     'nombre' => $data['nombre'],
        //     'categoria_id' => $data['categoria_id'],
        //     'imagen_principal' => $data['imagen_principal'],
        //     'direccion' => $data['direccion'],
        //     'colonia' => $data['colonia'],
        //     'lat' => $data['lat'],
        //     'lng' => $data['lng'],
        //     'telefono' => $data['telefono'],
        //     'descripcion' => $data['descripcion'],
        //     'apertura' => $data['apertura'],
        //     'cierre' => $data['cierre'],
        //     'uuid' => $data['uuid'],
        // ]);

        return back()->with('estado', 'Tu información se almaceno correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function show(Establecimiento $establecimiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function edit(Establecimiento $establecimiento)
    {
        // Consultar las Categorias
        $categorias = Categoria::all();

        // obtener el establecimiento (viene de la relacion)
        $establecimiento = auth()->user()->establecimiento;
        $establecimiento->apertura = date('H:i', strtotime($establecimiento->apertura));
        $establecimiento->cierre = date('H:i', strtotime($establecimiento->cierre));


        // Obtener las imagenes del establecimineto
        $imagenes = Imagen::where('id_establecimiento', $establecimiento->uuid)->get();

        // dd($imagenes);

        return view('estableciminetos.edit', compact('categorias', 'establecimiento', 'imagenes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Establecimiento $establecimiento)
    {
        // Ejecutar el policy

        $this->authorize('update', $establecimiento);

        // Validacion

        $data = $request->validate([
            'nombre' => 'required',
            'categoria_id' => 'required|exists:App\Categoria,id',  // dede de exixstir el modelo(tabla ) e id
            'imagen_principal' => 'image|max:2000',  // tipo imagen y maximo de 2m
            'direccion' => 'required',
            'colonia' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'telefono' => 'required|numeric',
            'descripcion' => 'required',
            'apertura' => 'date_format:H:i', // formato de fecha requerido hora:minutos
            'cierre' => 'date_format:H:i|after:apertura', // formato de fecha requerido hora:minutos y despues de apertura
            'uuid' => 'required|uuid',
        ]);

        $establecimiento->nombre = $data['nombre'];
        $establecimiento->categoria_id = $data['categoria_id'];
        $establecimiento->direccion = $data['direccion'];
        $establecimiento->colonia = $data['colonia'];
        $establecimiento->lat = $data['lat'];
        $establecimiento->lng = $data['lng'];
        $establecimiento->telefono = $data['telefono'];
        $establecimiento->descripcion = $data['descripcion'];
        $establecimiento->apertura = $data['apertura'];
        $establecimiento->cierre = $data['cierre'];
        $establecimiento->uuid = $data['uuid'];

        // Si el usuario sube una imagen 
        if(request('imagen_principal')){
            // Guaradr la imagen
            $ruta_imagen = $request['imagen_principal']->store('principales', 'public');

            // Rezise a la imagen
            $img = Image::make( public_path("storage/{$ruta_imagen}"))->fit(800, 600);
            $img->save();

            $establecimiento->imagen_principal = $ruta_imagen;
        }

        $establecimiento->save();

        // Mensaje al usuario
        return back()->with('estado', 'Tu informacion se almaceno correctamante');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Establecimiento $establecimiento)
    {
        //
    }
}
