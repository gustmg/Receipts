<template>
    <v-container fluid>
        <v-row>
            <sale-detail-component></sale-detail-component>
            <sale-info-component></sale-info-component>
        </v-row>
    </v-container>
    <!-- <div class="row" style="margin-bottom:0px; !important;">
        
        
        <clients-list-modal-component></clients-list-modal-component>
    </div> -->
</template>
<style type="text/css">
    .modal-content {
        padding-bottom: 0 !important;
    }

    .custom-sale-field {
        margin-top: 0 !important;
        margin-bottom: 0 !important;
    }

    .client-element,
    .service-element,
    .product-element {
        color: #039be5 !important;
    }
</style>
<script>
    import { parseCurrency } from 'vue-currency-input'
    import { CurrencyDirective } from 'vue-currency-input'
    import { mapState, mapMutations, mapActions, mapGetters } from 'vuex'

    export default {
        directives: {
            currency: CurrencyDirective,
        },

        mounted() {
            this.fetchProducts()
            this.fetchServices()
            this.fetchClients()
            this.fetchLastSaleId()
            this.fetchLastClientId()
        },

        props: {
            worker: {
                type: Object,
            },
        },

        computed: {
            ...mapState(['searchProductValue']),
            ...mapGetters('products', {
                products: 'getProducts',
            }),
            ...mapGetters('services', {
                services: 'getServices',
            }),
            ...mapGetters('clients', {
                clients: 'getClients',
            }),
            ...mapGetters('sales', {
                currentSaleId: 'getCurrentSaleId',
                cart: 'getCart',
            }),
        },

        methods: {
            ...mapActions('products', ['fetchProducts']),
            ...mapActions('services', ['fetchServices']),
            ...mapActions('clients', ['fetchClients', 'fetchLastClientId']),
            ...mapActions('sales', ['fetchLastSaleId']),
        },
    }
</script>
