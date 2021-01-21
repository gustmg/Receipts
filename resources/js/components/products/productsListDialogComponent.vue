<template>
    <v-dialog v-model="productsListDialog" width="480">
        <template v-slot:activator="{ on, attrs }">
            <v-speed-dial>
                <template v-slot:activator>
                    <v-btn class="secondary primary--text" v-bind="attrs" v-on="on" fab>
                        <v-icon>mdi-plus</v-icon>
                    </v-btn>
                </template>
            </v-speed-dial>
        </template>
        <v-card>
            <v-card-title class="justify-center">Elige productos</v-card-title>
            <v-card-text>
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
            <v-card-actions>
                <v-btn color="secondary" v-on:click="setProductsToEntry()">Aceptar</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
    import { mapGetters, mapMutations, mapState, mapActions } from 'vuex'
    export default {
        props: {
            route: {
                type: Number, //1->entries, 2->exits
            },
        },

        data() {
            return {
                productsListDialog: false,
                selectedProductsList: [],
            }
        },

        computed: {
            ...mapGetters('inventoryEntries', {
                productsEntryDetail: 'getProductsEntryDetail',
            }),
            ...mapGetters('inventoryExits', {
                productsExitDetail: 'getProductsExitDetail',
            }),

            ...mapGetters('products', {
                products: 'getProducts',
            }),

            filteredProducts: function() {
                if (this.route == 1) {
                    if (this.productsEntryDetail.length == 0) {
                        return this.products
                    } else {
                        return this.products.filter(product => {
                            return !this.productsEntryDetail.some(
                                productEntryDetail => productEntryDetail.product_id == product.product_id
                            )
                        })
                    }
                } else if (this.route == 2) {
                    if (this.productsExitDetail.length == 0) {
                        return this.products
                    } else {
                        return this.products.filter(product => {
                            return !this.productsExitDetail.some(
                                productExitDetail => productExitDetail.product_id == product.product_id
                            )
                        })
                    }
                }
            },
        },

        methods: {
            ...mapMutations('inventoryEntries', ['SET_PRODUCTS_TO_ENTRY']),
            ...mapMutations('inventoryExits', ['SET_PRODUCTS_TO_EXIT']),

            setProductsToEntry: function() {
                this.SET_PRODUCTS_TO_ENTRY(this.selectedProductsList)
                this.SET_PRODUCTS_TO_EXIT(this.selectedProductsList)
                this.productsListDialog = false
                this.selectedProductsList = []
            },
        },
    }
</script>
