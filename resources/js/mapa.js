// import
// import { OpenStreetMapProvider } from 'leaflet-geosearch';
// const provider = new OpenStreetMapProvider();

document.addEventListener('DOMContentLoaded', () => {

    if (document.querySelector('#mapa')) {
        const lat = 20.666332695977;
        const lng = -103.392177745699;

        const mapa = L.map('mapa').setView([lat, lng], 16);

        // Elimiar pines previos
        // let markers = new L.FeatureGroup().add(mapa); // Crea capa para los pines

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
        // markers.addLayer(marker);

        // Geocode Service
        const geocodeService = L.esri.Geocoding.geocodeService();

        // Buscador direcciones
        // const buscador = document.querySelector('#formbuscador');
        // buscador.addEventListener('blur', buscarDireccion);

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

        // function buscarDireccion(e) {

        //     if (e.target.value.length > 10) {
        //         provider.search({ query: e.target.value + 'Pachuca MX' })
        //             .then(resultado => {
        //                 if (resultado) { // eviter error al eviter null

        //                     // Limpara los pines previos
        //                     markers.clearLayers();

        //                     // Reverse Geocoding, cuando el usuario reubica el pin
        //                     geocodeService.reverse().latlng(resultado[0].bounds[0], 16).run(function (error, resultado) {

        //                         // llenar los input
        //                         llenarInputs(resultado);

        //                         // centrar el mapa
        //                         map.setView(resultado.latlng);

        //                         // Agregar el Pin
        //                         marker = new L.marker([lat, lng], {
        //                             draggable: true, // mover pin
        //                             autoPan: true // mover cuadro
        //                         }).addTo(mapa);

        //                         // asignar el contenedro de markers el nuevo pin
        //                         markers.addLayer(marker);

        //                         // Mover el pin
        //                         reubicarPin(marker);

        //                     })
        //                 }
        //             }).catch(error => {
        //                 console.log(error);
        //             })
        //     }
        // }

        function llenarInputs(resultado) {
            // console.log(resultado);
            document.querySelector('#direccion').value = resultado.address.Address || '';
            document.querySelector('#colonia').value = resultado.address.Neighborhood || '';
            document.querySelector('#lat').value = resultado.latlng.lat || '';
            document.querySelector('#lng').value = resultado.latlng.lng || '';
        }
    }
});
