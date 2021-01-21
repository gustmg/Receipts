<template>
    <v-col cols="8">
        <v-row>
            <v-col cols="6" align="center">
                <products-list-modal-component parent="cart"></products-list-modal-component>
                <services-list-modal-component parent="cart"></services-list-modal-component>
            </v-col>
            <v-col cols="12">
                <v-data-table
                    :headers="entryProductsTableHeaders"
                    :items="cart"
                    item-key="product_id"
                    hide-default-footer
                >
                    <template v-slot:item.articleAmount="{ item }">
                        <v-text-field
                            class="pt-6"
                            solo
                            min="1"
                            type="number"
                            v-model="item.articleAmount"
                            dense
                        ></v-text-field>
                    </template>
                    <template v-slot:item.articleDescription="{ item }">
                        <div class="text-caption">{{ setArticleType(item.articleType) }}</div>
                        <div class="text-body-2">{{ item.articleName }}</div>
                    </template>
                    <template v-slot:item.articleSalePriceType="{ item }">
                        <v-select
                            solo
                            dense
                            v-model="item.articleSalePriceType"
                            :items="salePriceTypes"
                            item-value="sale_price_type_id"
                            item-text="sale_price_type_name"
                            class="pt-6"
                            v-on:change="selectSalePrice(item)"
                        >
                        </v-select>
                    </template>
                    <template v-slot:item.articleUnitPrice="{ item }">
                        <v-text-field
                            class="pt-6"
                            solo
                            min="1"
                            type="number"
                            v-model="item.articleUnitPrice"
                            prefix="$"
                            dense
                        >
                            <template v-slot:append-outer v-if="isValidSalePrice(item)">
                                <v-tooltip bottom max-width="240">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-icon color="warning" v-bind="attrs" v-on="on">
                                            mdi-alert
                                        </v-icon>
                                    </template>
                                    <span>
                                        El valor ingresado es menor al costo de compra del producto, por lo que se
                                        generaría una pérdida al venderlo bajo dicho precio. Se recomienda modificar la
                                        cantidad a un valor mayor.
                                    </span>
                                </v-tooltip>
                            </template>
                        </v-text-field>
                    </template>
                    <template v-slot:item.articleImport="{ item }">
                        <v-text-field
                            readonly
                            class="pt-6"
                            solo
                            :value="item.articleUnitPrice * item.articleAmount"
                            prefix="$"
                            dense
                        ></v-text-field>
                    </template>
                    <template v-slot:item.articleOptions="{ item }">
                        <v-btn icon color="error" v-on:click="removeArticleFromCart(item.articleId)">
                            <v-icon>mdi-close-circle</v-icon>
                        </v-btn>
                    </template>
                </v-data-table>
            </v-col>
        </v-row>
    </v-col>
</template>
<script>
    import { mapGetters } from 'vuex'
    export default {
        data() {
            return {
                entryProductsTableHeaders: [
                    { text: 'Cantidad', value: 'articleAmount', width: '12%' },
                    { text: 'Descripción', value: 'articleDescription', width: '20%' },
                    { text: 'Tipo de precio', value: 'articleSalePriceType', width: '28%' },
                    { text: 'Precio unitario', value: 'articleUnitPrice', width: '20%' },
                    { text: 'Importe', value: 'articleImport', width: '15%' },
                    { text: '', value: 'articleOptions', width: '5%' },
                ],

                salePriceTypes: [
                    { sale_price_type_id: 1, sale_price_type_name: 'Público en general' },
                    { sale_price_type_id: 2, sale_price_type_name: 'Menudeo' },
                    { sale_price_type_id: 3, sale_price_type_name: 'Mayoreo' },
                ],
            }
        },

        computed: {
            ...mapGetters('sales', {
                cart: 'getCart',
            }),
        },

        methods: {
            setArticleType: function(articleType) {
                if (articleType == 2) {
                    return 'Servicio'
                } else {
                    return 'Producto'
                }
            },

            getFormatedNumber: function(number) {
                var int_amount = parseInt(number)
                var decimal_amount = (number % 1).toFixed(2).slice(1)
                return int_amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + decimal_amount
            },

            isValidSalePrice: function(cartProduct) {
                if (cartProduct.articleUnitPrice < cartProduct.articleCost) {
                    return true
                }
                return false
            },

            removeArticleFromCart: function(article_id) {
                const index = this.cart.findIndex(function(cartItem) {
                    return cartItem.articleId === article_id
                })
                this.cart.splice(index, 1)
            },

            selectSalePrice: function(article) {
                if (article.articleSalePriceType == 1) {
                    article.articleUnitPrice = (
                        article.articleCost +
                        (article.articleCost * article.articleBasePricePercentage) / 100
                    ).toFixed(2)
                } else if (article.articleSalePriceType == 2) {
                    if (article.articleRetailPricePercentage != 0) {
                        article.articleUnitPrice = (
                            article.articleCost +
                            (article.articleCost * article.articleRetailPricePercentage) / 100
                        ).toFixed(2)
                    } else {
                        article.articleUnitPrice = (
                            article.articleCost +
                            (article.articleCost * article.articleBasePricePercentage) / 100
                        ).toFixed(2)
                    }
                } else {
                    if (article.articleWholesalePricePercentage != 0) {
                        article.articleUnitPrice = (
                            article.articleCost +
                            (article.articleCost * article.articleWholesalePricePercentage) / 100
                        ).toFixed(2)
                    } else {
                        article.articleUnitPrice = (
                            article.articleCost +
                            (article.articleCost * article.articleBasePricePercentage) / 100
                        ).toFixed(2)
                    }
                }
            },
        },
    }
</script>
