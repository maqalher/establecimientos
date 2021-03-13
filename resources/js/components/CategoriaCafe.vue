<template>
    <div class="container my-5">
        <h2>Cafés</h2>

        <div class="row">
            <div class="col-md-4 mt-4" v-for="cafe in this.cafes" v-bind:key="cafe.id">
                <div class="card">
                    <img :src="`storage/${cafe.imagen_principal}`" alt="img cafe" class="card-img-top">
                    <div class="card-body">
                        <h3 class="card-title text-primary font-weight-bold">{{cafe.nombre}}</h3>
                        <p class="card-text">{{cafe.direccion}}</p>
                        <p class="card-text">
                            <span class="font-weight-bold">Horario</span>
                                {{cafe.apertura}} - {{cafe.cierre}}
                        </p>

                        <a class="btn btn-primary d-block">Ver Lugar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        data: function() {
            return {
                cafes: []
            }
        },
        mounted(){
            axios.get('/api/categoria/cafe')
                .then(respuesta => {
                    this.cafes = respuesta.data;
                    // console.log(this.cafes);
                }).catch((err) => {
                    console.log(err);
                });
        }
    }
</script>
