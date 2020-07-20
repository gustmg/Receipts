<template>
    <div class="col m8" style="padding-left:24px !important;">
        <div class="row" style="margin-bottom:0px; !important;">
            <div class="col m6 center-align" style="padding-top:18px !important;">
                <button v-on:click="showProductsList" class="mdc-button mdc-button--outlined">
                    Lista de productos
                </button>
                &nbsp;&nbsp;
                <button v-on:click="showServicesList" class="mdc-button mdc-button--outlined">
                    Lista de servicios
                </button>
            </div>
            <div class="col m12 card">
                <table class="centered">
                    <thead class="">
                        <tr>
                            <th style="width:10%;">Cantidad</th>
                            <th style="width:10%;">Tipo</th>
                            <th style="width:25%;">Descripción</th>
                            <th style="width:25%;">Tipo de precio</th>
                            <th style="width:15%;">Precio Unitario</th>
                            <th style="width:10%;">Importe</th>
                            <th style="width:5%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(article, index) in cart" v-bind:key="article.article_id">
                            <td>
                                <div class="input-field custom-sale-field">
                                    <input v-model="article.articleAmount" class="validate" type="number" min="1" />
                                </div>
                            </td>
                            <td>
                                {{ setArticleType(article.articleType) }}
                            </td>
                            <td>
                                <span
                                    ><b>{{ article.articleName }}</b></span
                                ><br />
                                <span>{{ article.articleDescription }}</span>
                            </td>
                            <td>
                                <div class="input-field col s12">
                                    <select v-on:change="selectSalePrice($event, article)" class="browser-default">
                                        <option value="1" selected>Público en general</option>
                                        <option value="2">Menudeo</option>
                                        <option value="3">Mayoreo</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <FormulateInput
                                    type="text"
                                    validation="number"
                                    v-model="article.articleUnitPrice"
                                    v-on:blur="validateSalePrice(article.articleUnitPrice, article.articleCost)"
                                />
                            </td>
                            <td>${{ getFormatedNumber(article.articleAmount * article.articleUnitPrice) }}</td>
                            <td>
                                <a class="selectable red-text" v-on:click="removeArticle(index)"
                                    ><i class="material-icons">cancel</i></a
                                >
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapGetters } from 'vuex'
    export default {
        computed: {
            ...mapGetters('sales', {
                cart: 'getCart',
            }),
        },

        methods: {
            showProductsList: function() {
                $('#productsCompactListModal').modal('open')
            },

            showServicesList: function() {
                $('#servicesCompactListModal').modal('open')
            },

            setArticleType: function(articleType) {
                if (articleType == 0) {
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

            validateSalePrice: function(salePrice, cost) {
                if (salePrice < cost && salePrice != '') {
                    $('#warningProductCostModal').modal('open')
                }
            },

            removeArticle: function(index) {
                this.cart.splice(index, 1)
            },

            selectSalePrice: function(event, article) {
                if (event.target.value == 1) {
                    article.articleUnitPrice = (
                        article.articleCost +
                        (article.articleCost * article.articleBasePricePercentage) / 100
                    ).toFixed(2)
                } else if (event.target.value == 2) {
                    article.articleUnitPrice = (
                        article.articleCost +
                        (article.articleCost * article.articleRetailPricePercentage) / 100
                    ).toFixed(2)
                } else {
                    article.articleUnitPrice = (
                        article.articleCost +
                        (article.articleCost * article.articleWholesalePricePercentage) / 100
                    ).toFixed(2)
                }
            },
        },
    }
</script>
