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
                    imagen: file.nombreServidor
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
