<template>
    <div>
        <categoria-cafe></categoria-cafe>
        <categoria-restaurant></categoria-restaurant>
    </div>
</template>

<script>

    import CategoriaCafe from './CategoriaCafe';
    import CategoriaRestaurant from './CategoriaRestaurant';

    export default {
        components: {
            CategoriaCafe,
            CategoriaRestaurant
        }
    }
</script>
