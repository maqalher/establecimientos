document.addEventListener('DOMContentLoaded', () => {
    if(document.querySelector('#dropzone')){
        Dropzone.autoDiscover = false; // esto para pararlo ya que al ponerlo en la clase del div hace la instancia

        const dropzone = new Dropzone('div#dropzone', {
            url: '/imagenes/store',
            directDefaultMessage: 'Sube hasta 10 imágenes',
            maxFiles: 10,
            required: true,
            acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            },
            success: function(file, respuesta) {
                // console.log(file); // respuesta cliente
                console.log(respuesta); // respuesta servidor

            },
            sending: function(file, xhr, formData) {
                formData.append('uuid', document.querySelector('#uuid').value)
                console.log('enviando');
            }
        });
        
    }
})