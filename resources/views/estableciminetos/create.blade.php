@extends('layouts.app')

@section('styles')

<!-- Load Leaflet from CDN -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
crossorigin=""/>

<!-- Load Esri Leaflet Geocoder from CDN -->
<link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.3.3/dist/esri-leaflet-geocoder.css"
integrity="sha512-IM3Hs+feyi40yZhDH6kV8vQMg4Fh20s9OzInIIAc4nx7aMYMfo+IenRUekoYsHZqGkREUgx0VvlEsgm7nCDW9g=="
crossorigin="">

<link rel="stylesheet"
href="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.css" />


@endsection

@section('content')
    <div class="container">
        <h1 class="text-center mt-4">Registrar Establecimiento</h1>

        <div class="mt-5 row justify-content-center">
            <form class="col-md-9 col-xs-12 card card-body">

                <fieldset class="border p-4">
                    <legend class="text-primary">Nombre, Categoría e Imagen Principal</legend>

                    <div class="form-group">
                        <label for="nombre">Nombre Establecimiento</label>
                        <input
                            id="nombre"
                            type="text"
                            class="form-control @error('nombre') is-invalid @enderror"
                            placeholder="Nombre Establecimiento"
                            name="nombre"
                            value="{{old('nombre')}}"
                        >
                        @error('nombre')
                            <div class="invalid-feedback">
                                {{message}}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="categosia">Categoría</label>

                        <select
                            name="categoria_id"
                            id="categoria"
                            class="form-control @error('categoria_id') is-invalid @enderror"
                        >
                            <option value="" selected disabled>-- Seleccione --</option>
                            @foreach ($categorias as $categoria)
                                <option
                                    value="{{$categoria->id}}"
                                    {{old('categoria_id') == $categoria->id ? 'selected' : ''}}
                                >{{$categoria->nombre}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="imagen_principal">Imagen Principal</label>
                        <input
                            id="imagen_principal"
                            type="file"
                            class="form-control @error('imagen_principal') is-invalid @enderror"
                            name="imagen_principal"
                            value="{{old('imagen_principal')}}"
                        >
                        @error('imagen_principal')
                            <div class="invalid-feedback">
                                {{message}}
                            </div>
                        @enderror
                    </div>

                </fieldset>

                <fieldset class="border p-4">
                    <legend class="text-primary">Ubicacíon</legend>

                    <div class="form-group">
                        <label for="formbuscador">Coloca la dirección del Establecimiento</label>
                        <input
                            id="formbuscador"
                            type="text"
                            placeholder="Calle del Negocio o Establecimiento"
                            class="form-control"
                        >
                        <p class="text-secondary mt-5 mb-3 text-center">El asistente colocará una dirección estimada o mueve el Pin hacia el lugar correcto</p>
                    </div>

                    <div class="form-group">
                        <div id="mapa" style="height: 400px;"></div>
                    </div>

                    <p class="informacion">Confirma que los siguientes campos son correctos</p>

                    <div class="form-group">
                        <label for="direccion">Direccíon</label>
                        <input
                            id="direccion"
                            type="text"
                            class="form-control @error('direccion') is-invalid @enderror"
                            name="direccion"
                            placeholder="Direccíon"
                            value="{{old('direccion')}}"
                        >
                        @error('direccion')
                            <div class="invalid-feedback">
                                {{message}}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="colonia">Colonia</label>
                        <input
                            id="colonia"
                            type="text"
                            class="form-control @error('colonia') is-invalid @enderror"
                            name="colonia"
                            placeholder="Colonia"
                            value="{{old('colonia')}}"
                        >
                        @error('colonia')
                            <div class="invalid-feedback">
                                {{message}}
                            </div>
                        @enderror
                    </div>

                    <input type="hidden" id="lat" name="lat" value="{{old('lat')}}">
                    <input type="hidden" id="lng" name="lng" value="{{old('lng')}}">

                </fieldset>
            </form>
        </div>

    </div>
@endsection


@section('scripts')
<!-- Load Leaflet from CDN -->

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
crossorigin=""></script>

<!-- Load Esri Leaflet from CDN -->
<script src="https://unpkg.com/esri-leaflet@2.5.3/dist/esri-leaflet.js"
integrity="sha512-K0Vddb4QdnVOAuPJBHkgrua+/A9Moyv8AQEWi0xndQ+fqbRfAFd47z4A9u1AW/spLO0gEaiE1z98PK1gl5mC5Q=="
crossorigin=""></script>

<!-- Load Esri Leaflet Geocoder from CDN -->

<script src="https://unpkg.com/esri-leaflet-geocoder@2.3.3/dist/esri-leaflet-geocoder.js"
integrity="sha512-HrFUyCEtIpxZloTgEKKMq4RFYhxjJkCiF5sDxuAokklOeZ68U2NPfh4MFtyIVWlsKtVbK5GD2/JzFyAfvT5ejA=="
crossorigin=""></script>

{{-- <script src="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.umd.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-geosearch/3.2.1/geosearch.umd.js" integrity="sha512-fxMi4KPmEusX79+0hZgNwVP4LeBXMf45loYW3ueCAFw8tBHPdsPiFjchrHADHcORgurJIW1tqHSDJi2n1PkxsA==" crossorigin="anonymous"></script>



@endsection
