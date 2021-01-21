<template>
    <v-container>
        <product-search-bar-component></product-search-bar-component>
        <products-table-component></products-table-component>
        <new-product-modal-component></new-product-modal-component>
    </v-container>
</template>
<script>
    import { mapActions, mapGetters, mapMutations } from 'vuex'
    export default {
        mounted() {
            this.fetchProducts()
        },

        computed: {
            ...mapGetters('products', ['getProducts']),
        },

        methods: {
            ...mapActions('products', ['fetchProducts']),
        },
    }
</script>
