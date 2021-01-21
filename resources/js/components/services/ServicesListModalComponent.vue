<template>
    <v-dialog v-model="servicesListModal" width="480">
        <template v-slot:activator="{ on, attrs }">
            <v-btn color="secondary" v-on="on" v-bind="attrs">Lista de servicios</v-btn>
        </template>
        <v-card>
            <v-card-title>Agrega un servicio</v-card-title>
            <v-card-text>
                <service-search-bar-component></service-search-bar-component>
                <v-list>
                    <v-list-item-group multiple active-class="">
                        <v-list-item v-for="service in filteredServices" v-bind:key="service.service_id">
                            <template v-slot:default="{ active }">
                                <v-list-item-action>
                                    <v-checkbox
                                        v-model="selectedServicesList"
                                        :value="service"
                                        color="secondary"
                                    ></v-checkbox>
                                </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title>
                                        {{ service.service_name }}
                                    </v-list-item-title>
                                    <v-list-item-subtitle>{{ service.service_description }}</v-list-item-subtitle>
                                </v-list-item-content>
                            </template>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>
            </v-card-text>
            <v-card-actions>
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
                servicesListModal: false,
                selectedServicesList: [],
            }
        },

        props: {
            parent: {
                type: String,
            },
        },

        computed: {
            ...mapGetters('services', {
                services: 'getServices',
                searchServiceValue: 'getSearchServiceValue',
            }),

            ...mapGetters('sales', {
                cart: 'getCart',
            }),

            filteredServices: function() {
                return this.services.filter(service => {
                    return !this.cart.some(
                        serviceInCart => serviceInCart.articleId == service.service_id && serviceInCart.articleType == 2
                    )
                })
            },
        },

        methods: {
            ...mapMutations('sales', ['ADD_TO_CART']),

            addToCart: function(service) {
                this.selectedServicesList.forEach(service => {
                    this.ADD_TO_CART({
                        articleId: service.service_id,
                        articleAmount: 1,
                        articleType: 2,
                        articleName: service.service_name,
                        articleDescription: service.service_description,
                        articleCode: service.service_code,
                        articleCost: service.service_cost,
                        articleSalePriceType: 1,
                        articleBasePricePercentage: service.service_base_price_percentage,
                        articleRetailPricePercentage: service.service_retail_price_percentage,
                        articleWholesalePricePercentage: service.service_wholesale_price_percentage,
                        articleUnitPrice: (
                            service.service_cost +
                            (service.service_cost * service.service_base_price_percentage) / 100
                        ).toFixed(2),
                    })
                })
                this.servicesListModal = false
                this.selectedServicesList = []
            },
        },
    }
</script>
