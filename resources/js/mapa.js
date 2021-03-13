const provider = new GeoSearch.OpenStreetMapProvider();

document.addEventListener('DOMContentLoaded', () => {

    if (document.querySelector('#mapa')) {
        const lat = document.querySelector('#lat').value === '' ? 20.12686724784655 : document.querySelector('#lat').value;
        const lng = document.querySelector('#lng').value === '' ? -98.73111105310079 : document.querySelector('#lng').value;

        const mapa = L.map('mapa').setView([lat, lng], 16);

        // Delete previous markers
        let markers = new L.FeatureGroup().addTo(mapa)

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mapa);

        let marker;

        // agregar el pin
        marker = new L.marker([lat, lng], {
            draggable: true, // mover pin
            autoPan: true // mover cuadro
        }).addTo(mapa);

        // Agregar el pin a la capa
        markers.addLayer(marker);

        // Geocode Service
        const geocodeService = L.esri.Geocoding.geocodeService();

        // Buscador direcciones
        const buscador = document.querySelector('#formbuscador');
        buscador.addEventListener('blur', buscarDireccion);

        reubicarPin(marker);

        function reubicarPin(marker) {
            // Detectar movimineto del marker
            marker.on('moveend', function (e) {
                marker = e.target;
                // console.log(marker)

                // console.log(marker.getLatLng());
                const posicion = marker.getLatLng();

                // Centrar mapa automaticamante
                mapa.panTo(new L.LatLng(posicion.lat, posicion.lng));

                // Reverse Geocoding, cuando el usuario reubica el pin
                geocodeService.reverse().latlng(posicion, 16).run(function (error, resultado) {
                    // console.log(error);

                    // console.log(resultado.address);

                    marker.bindPopup(resultado.address.LongLabel);
                    marker.openPopup();

                    // Llenar los campos
                    llenarInputs(resultado);
                })

            });
        }

        function buscarDireccion(e) {

            if (e.target.value.length > 5) {
                provider
                    .search({ query: e.target.value + ' Pachuca MX' })
                    .then(resp => {
                        if (resp[0]) {
                            markers.clearLayers()

                            geocodeService
                                .reverse()
                                .latlng(resp[0].bounds[0], 16)
                                .run((error, result) => {

                                    llenarInputs(result);

                                    mapa.setView(result.latlng)

                                    marker = new L.marker(result.latlng, {
                                        draggable: true,
                                        autoPan: true,
                                    }).addTo(mapa)

                                    markers.addLayer(marker)

                                    marker.bindPopup(result.address.LongLabel)
                                    marker.openPopup()

                                    reubicarPin(marker)
                                })
                        }
                    })
                    .catch(console.error)
            }
        }

        function llenarInputs(resultado) {
            // console.log(resultado);
            document.querySelector('#direccion').value = resultado.address.Address || '';
            document.querySelector('#colonia').value = resultado.address.Neighborhood || '';
            document.querySelector('#lat').value = resultado.latlng.lat || '';
            document.querySelector('#lng').value = resultado.latlng.lng || '';
        }
    }
});
