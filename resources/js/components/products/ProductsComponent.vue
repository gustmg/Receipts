<template>
    <div class="row">
        <product-search-bar-component :search-value-product.sync="searchProduct"></product-search-bar-component>
        <products-list-component :products="products" :key="componentKey"></products-list-component>
        <new-product-button-component></new-product-button-component>
        <new-product-modal-component></new-product-modal-component>
    </div>
</template>
<script>
    export default {
        props: {
            products: {
                type: Array
            },
            searchValueProduct:String,
        },

        data() {
            return {
                searchProduct: '',
                componentKey: 0
            }
        },

        mounted() {
            console.log('Products component mounted');
        },

        methods: {
            forceRerender() {
                this.componentKey += 1;  
            }
        }
    }
</script>