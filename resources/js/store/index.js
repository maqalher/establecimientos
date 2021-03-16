import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        cafes: [],
        restaurantes: [],
        hoteles: [],
        establecimiento: {},
        establecimientos: []
    },
    mutations: {
        AGREGAR_CAFES(state, cafes){
            state.cafes = cafes;
        },
        AGREGAR_RESTAURANTES(state, restaurantes){
            state.restaurantes = restaurantes;
        },
        AGREGAR_HOTELES(state, hoteles){
            state.hoteles = hoteles;
        },
        AGREGAR_ESTABLECIMIENTO(state, establecimiento){
            state.establecimiento = establecimiento;
        },
        AGREGAR_ESTABLECIMIENTOS(state, establecimientos){
            state.establecimientos = establecimientos;
        },
    },
    getters: {
        obtenerEstablecimiento: state => {
            return state.establecimiento;
        },
        obtenerImagenes: state => {
            return state.establecimiento.imagenes;
        },
        obtenerEstablecimientos: state => {
            return state.establecimientos;
        },
    },
})
