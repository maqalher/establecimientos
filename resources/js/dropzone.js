const { default: Axios } = require("axios");

document.addEventListener('DOMContentLoaded', () => {
    if(document.querySelector('#dropzone')){
        Dropzone.autoDiscover = false; // esto para pararlo ya que al ponerlo en la clase del div hace la instancia

        const dropzone = new Dropzone('div#dropzone', {
            url: '/imagenes/store',
            directDefaultMessage: 'Sube hasta 10 imágenes',
            maxFiles: 10,
            required: true,
            acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
            addRemoveLinks: true,
            dictRemoveFile: "Eliminar imágen",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            },
            init: function() {
                const galeria = document.querySelectorAll('.galeria');

                if(galeria.length > 0){
                    galeria.forEach(imagen => {
                        const imagenPublicada = {};
                        imagenPublicada.size = 1;
                        imagenPublicada.name = imagen.value;
                        imagenPublicada.nombreServidor = imagen.value; // uuid para eliminar
                        
                        this.options.addedfile.call(this, imagenPublicada);
                        this.options.thumbnail.call(this, imagenPublicada, `/storage/${imagenPublicada.name}`);

                        imagenPublicada.previewElement.classList.add('dz-success');
                        imagenPublicada.previewElement.classList.add('dz-complete');
                    })
                }
            },
            success: function(file, respuesta) {
                // console.log(file); // respuesta cliente
                // console.log(respuesta); // respuesta servidor
                file.nombreServidor = respuesta.archivo;
            },
            sending: function(file, xhr, formData) {
                formData.append('uuid', document.querySelector('#uuid').value)
                // console.log('enviando');
            },
            removedfile: function(file, respuesta){
                // console.log(file)

                const params = {
                    imagen: file.nombreServidor,
                    uuid: document.querySelector('#uuid').value
                }

                axios.post('/imagenes/destroy', params)
                .then(respuesta => {
                    // console.log(respuesta);

                    // Eliminar del DOM
                    file.previewElement.parentNode.removeChild(file.previewElement);

                })
            }
        });

    }
})
