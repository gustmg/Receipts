<template>
    <div class="row">
        <receipt-search-bar-component></receipt-search-bar-component>
        <receipts-list-component></receipts-list-component>
        <new-receipt-button-component></new-receipt-button-component>
        <new-receipt-modal-component></new-receipt-modal-component>
        <new-device-modal-component></new-device-modal-component>
        <new-accessory-modal-component></new-accessory-modal-component>
        <clients-list-modal-component></clients-list-modal-component>
    </div>
</template>
<script>
    import { mapActions, mapGetters, mapMutations } from 'vuex'
    export default {
        props: {
            worker: {
                type: Object,
            },
        },

        mounted() {
            this.fetchClients()
            this.fetchReceipts()
            this.fetchLastReceiptId()
            this.fetchLastClientId()
            this.fetchServices()
        },

        computed: {
            ...mapGetters('services', ['getServices']),
        },

        methods: {
            ...mapActions('receipts', ['fetchReceipts', 'fetchLastReceiptId']),
            ...mapActions('services', ['fetchServices']),
            ...mapActions('clients', ['fetchClients', 'fetchLastClientId']),
        },
    }
</script>
