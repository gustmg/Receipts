<template>
    <div id="servicesCompactListModal" class="modal modal-fixed-footer servicesCompactListModal">
        <div class="modal-content">
            <service-search-bar-component></service-search-bar-component>
            <ul class="collection with-header">
                <a
                    class="collection-item selectable service-element"
                    v-on:click="addToCart(service)"
                    v-for="service in filteredServices"
                    v-bind:key="service.service_id"
                >
                    {{ service.service_name }}
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
            ...mapGetters('services', {
                services: 'getServices',
                searchServiceValue: 'getSearchServiceValue',
            }),

            ...mapGetters('sales', {
                cart: 'getCart',
            }),

            filteredServices: function() {
                return this.services.filter(service => {
                    return service.service_name.toLowerCase().indexOf(this.searchServiceValue.toLowerCase()) >= 0
                })
            },
        },

        methods: {
            ...mapMutations('sales', ['ADD_TO_CART']),

            addToCart: function(service) {
                this.ADD_TO_CART({
                    articleId: service.service_id,
                    articleAmount: 1,
                    articleType: 0,
                    articleName: service.service_name,
                    articleDescription: service.service_description,
                    articleCode: service.service_code,
                    articleCost: service.service_cost,
                    articleBasePricePercentage: service.service_base_price_percentage,
                    articleRetailPricePercentage: service.service_retail_price_percentage,
                    articleWholesalePricePercentage: service.service_wholesale_price_percentage,
                    articleUnitPrice: (
                        service.service_cost +
                        (service.service_cost * service.service_base_price_percentage) / 100
                    ).toFixed(2),
                })

                $('#servicesCompactListModal').modal('close')
            },
        },
    }
</script>
