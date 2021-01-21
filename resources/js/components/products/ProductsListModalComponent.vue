<template>
    <v-dialog v-model="productsListModal" width="480">
        <template v-slot:activator="{ on, attrs }">
            <v-btn color="secondary" v-on="on" v-bind="attrs">Lista de productos</v-btn>
        </template>
        <v-card>
            <v-card-title>Agrega un producto</v-card-title>
            <v-card-text>
                <product-search-bar-component></product-search-bar-component>
                <v-list>
                    <v-list-item-group multiple active-class="">
                        <v-list-item v-for="product in filteredProducts" v-bind:key="product.product_id">
                            <template v-slot:default="{ active }">
                                <v-list-item-action>
                                    <v-checkbox
                                        v-model="selectedProductsList"
                                        :value="product"
                                        color="secondary"
                                    ></v-checkbox>
                                </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title>
                                        {{ product.product_name }}
                                        <div class="d-inline-flex text-caption font-weight-bold text--secondary">
                                            Stock: {{ product.product_stock }}
                                        </div>
                                    </v-list-item-title>
                                    <v-list-item-subtitle>{{ product.product_description }}</v-list-item-subtitle>
                                </v-list-item-content>
                            </template>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>
            </v-card-text>
            <v-card-actions class="justify-center">
                <v-btn color="secondary" v-on:click="addToCart()">Aceptar</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
    import { mapGetters, mapMutations } from 'vuex'

    export default {
        data() {
            return {
                productsListModal: false,
                selectedProductsList: [],
            }
        },

        props: {
            parent: {
                type: String,
            },
        },

        computed: {
            ...mapGetters('products', {
                products: 'getProducts',
                searchProductValue: 'getSearchProductValue',
            }),

            ...mapGetters('sales', {
                cart: 'getCart',
            }),

            filteredProducts: function() {
                return this.products.filter(product => {
                    return !this.cart.some(
                        productInCart => productInCart.articleId == product.product_id && productInCart.articleType == 1
                    )
                })
            },
        },

        methods: {
            ...mapMutations('sales', ['ADD_TO_CART']),

            addToCart: function(product) {
                this.selectedProductsList.forEach(product => {
                    this.ADD_TO_CART({
                        articleId: product.product_id,
                        articleAmount: 1,
                        articleType: 1,
                        articleName: product.product_name,
                        articleDescription: product.product_description,
                        articleCode: product.product_code,
                        articleCost: product.product_cost,
                        articleSalePriceType: 1,
                        articleBasePricePercentage: product.product_base_price_percentage,
                        articleRetailPricePercentage: product.product_retail_price_percentage,
                        articleWholesalePricePercentage: product.product_wholesale_price_percentage,
                        articleUnitPrice: (
                            +product.product_cost +
                            (+product.product_cost * +product.product_base_price_percentage) / 100
                        ).toFixed(2),
                    })
                })
                this.productsListModal = false
                this.selectedProductsList = []
            },
        },
    }
</script>
