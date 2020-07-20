<template>
    <div id="productsCompactListModal" class="modal modal-fixed-footer productsCompactListModal">
        <div class="modal-content">
            <product-search-bar-component></product-search-bar-component>
            <ul class="collection with-header">
                <a
                    class="collection-item selectable product-element"
                    v-on:click="addToCart(product)"
                    v-for="product in filteredProducts"
                    v-bind:key="product.product_id"
                >
                    {{ product.product_name }}
                </a>
            </ul>
        </div>
        <div class="modal-footer">
            <button class="modal-action modal-close waves-effect btn-flat">
                <b>Cancelar</b>
            </button>
        </div>
    </div>
</template>
<script>
    import { mapGetters, mapMutations } from 'vuex'
    export default {
        computed: {
            ...mapGetters('products', {
                products: 'getProducts',
                searchProductValue: 'getSearchProductValue',
            }),

            filteredProducts: function() {
                return this.products.filter(product => {
                    return product.product_name.toLowerCase().indexOf(this.searchProductValue.toLowerCase()) >= 0
                })
            },
        },

        methods: {
            ...mapMutations('sales', ['ADD_TO_CART']),

            addToCart: function(product) {
                this.ADD_TO_CART({
                    articleId: product.product_id,
                    articleAmount: 1,
                    articleType: 1,
                    articleName: product.product_name,
                    articleDescription: product.product_description,
                    articleCode: product.product_code,
                    articleCost: product.product_cost,
                    articleBasePricePercentage: product.product_base_price_percentage,
                    articleRetailPricePercentage: product.product_retail_price_percentage,
                    articleWholesalePricePercentage: product.product_wholesale_price_percentage,
                    articleUnitPrice: (
                        product.product_cost +
                        (product.product_cost * product.product_base_price_percentage) / 100
                    ).toFixed(2),
                })

                $('#productsCompactListModal').modal('close')
            },
        },
    }
</script>
