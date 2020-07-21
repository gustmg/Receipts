<template>
    <div id="clientsCompactListModal" class="modal modal-fixed-footer clientsCompactListModal">
        <div class="modal-content">
            <client-search-bar-component></client-search-bar-component>
            <ul class="collection with-header">
                <a
                    class="collection-item selectable client-element"
                    v-on:click="selectSaleClient(client)"
                    v-for="client in filteredClients"
                    v-bind:key="client.client_id"
                >
                    {{ client.client_name }}
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
<style type="text/css">
    .modal-content {
        padding-bottom: 0 !important;
    }

    .client-element {
        color: #039be5 !important;
    }
</style>
<script>
    import { mapGetters, mapMutations } from 'vuex'
    export default {
        computed: {
            ...mapGetters('clients', {
                clients: 'getClients',
                searchClientValue: 'getSearchClientValue',
            }),

            filteredClients: function() {
                return this.clients.filter(client => {
                    return client.client_name.toLowerCase().indexOf(this.searchClientValue.toLowerCase()) >= 0
                })
            },
        },

        methods: {
            ...mapMutations('sales', [
                'SET_SALE_CLIENT_ID',
                'SET_SALE_CLIENT_NAME',
                'SET_SALE_CLIENT_PHONE',
                'SET_SALE_CLIENT_EMAIL',
            ]),

            ...mapMutations('receipts', [
                'SET_RECEIPT_CLIENT_ID',
                'SET_RECEIPT_CLIENT_NAME',
                'SET_RECEIPT_CLIENT_PHONE',
                'SET_RECEIPT_CLIENT_EMAIL',
            ]),

            ...mapMutations('clients', ['SET_SEARCH_CLIENT_VALUE']),

            selectSaleClient: function(client) {
                this.SET_RECEIPT_CLIENT_ID(client.client_id)
                this.SET_RECEIPT_CLIENT_NAME(client.client_name)
                this.SET_RECEIPT_CLIENT_PHONE(client.client_phone)
                this.SET_RECEIPT_CLIENT_EMAIL(client.client_email)
                this.SET_SALE_CLIENT_ID(client.client_id)
                this.SET_SALE_CLIENT_NAME(client.client_name)
                this.SET_SALE_CLIENT_PHONE(client.client_phone)
                this.SET_SALE_CLIENT_EMAIL(client.client_email)
                this.SET_SEARCH_CLIENT_VALUE('')

                $('#clientsCompactListModal').modal('close')
            },
        },
    }
</script>
