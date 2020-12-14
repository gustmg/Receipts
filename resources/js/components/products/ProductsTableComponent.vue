<template>
    <v-row>
        <v-col cols="12">
            <v-card>
                <v-data-table
                    :headers="productsTableHeaders"
                    :items="filteredProducts"
                    show-select
                    item-key="product_id"
                    hide-default-footer
                >
                </v-data-table>
            </v-card>
        </v-col>
    </v-row>
</template>
<script>
    import { mapState, mapMutations, mapActions, mapGetters } from 'vuex'
    export default {
        data() {
            return {
                productsTableHeaders: [
                    { text: 'Producto', value: 'product_name' },
                    { text: 'Existencias', value: 'product_stock' },
                    { text: 'Costo', value: 'product_cost' },
                    { text: 'Ganancia público en general', value: 'product_base_price_percentage' },
                    { text: 'Ganancia menudeo', value: 'product_retail_price_percentage' },
                    { text: 'Ganancia mayoreo', value: 'product_wholesale_price_percentage' },
                ],
            }
        },

        methods: {
            ...mapActions(['setProductToUpdate', 'openModal']),

            updateProduct: function(product) {
                this.setProductToUpdate(product)
                this.openModal($('#updateProductModal'))
            },
        },

        computed: {
            ...mapState(['product_to_update']),
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
    }
</script>
