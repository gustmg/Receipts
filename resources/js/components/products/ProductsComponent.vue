<template>
    <v-container>
        <product-search-bar-component></product-search-bar-component>
        <products-table-component></products-table-component>
        <new-product-modal-component></new-product-modal-component>
    </v-container>
    <!-- <div class="row">
        <products-table-component></products-table-component>
        <new-product-button-component></new-product-button-component>
        <new-product-modal-component></new-product-modal-component>
        <warning-product-cost-modal-component></warning-product-cost-modal-component>
    </div> -->
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
