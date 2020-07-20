<template>
    <div class="row" style="margin-bottom:0px; !important;">
        <sale-detail-component></sale-detail-component>
        <sale-info-component></sale-info-component>
        <products-list-modal-component></products-list-modal-component>
        <services-list-modal-component></services-list-modal-component>
        <clients-list-modal-component></clients-list-modal-component>
    </div>
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
            document.addEventListener('DOMContentLoaded', function() {
                var elems = document.querySelectorAll('select')
                var instances = M.FormSelect.init(elems)
            })
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
