<template>
    <div class="row">
        <product-search-bar-component :search-value-product.sync="searchProduct"></product-search-bar-component>
        <products-table-component :key="componentKey"></products-table-component>
        <new-product-button-component></new-product-button-component>
        <new-product-modal-component></new-product-modal-component>
        <warning-product-cost-modal-component></warning-product-cost-modal-component>
    </div>
</template>
<script>
    export default {
        props: {
            searchValueProduct:String,
        },

        data() {
            return {
                searchProduct: '',
                componentKey: 0
            }
        },

        methods: {
            forceRerender() {
                this.componentKey += 1;  
            }
        }
    }
</script>