<template>
    <v-dialog width="480" v-model="clientsListDialog">
        <template v-slot:activator="{ on, attrs }">
            <v-btn v-on="on" v-bind="attrs" class="primary white--text" :disabled="newClientToggle">
                Buscar cliente
            </v-btn>
        </template>
        <v-card>
            <v-card-title class="justify-center">
                Seleccione un cliente
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col cols="12" class="py-0"><client-search-bar-component></client-search-bar-component></v-col>
                    <v-col cols="12" class="py-0">
                        <v-card>
                            <v-list class="clients-list">
                                <v-list-item-group>
                                    <v-list-item
                                        v-for="client in filteredClients"
                                        v-bind:key="client.client_id"
                                        v-on:click="selectSaleClient(client)"
                                    >
                                        <v-list-item-content>
                                            <v-list-item-title>{{ client.client_name }}</v-list-item-title>
                                            <v-list-item-subtitle>{{ client.client_phone }}</v-list-item-subtitle>
                                        </v-list-item-content>
                                    </v-list-item>
                                </v-list-item-group>
                            </v-list>
                        </v-card>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions class="justify-center">
                <v-btn class="primary--text" text v-on:click="clientsListDialog = false">Cancelar</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<style scoped>
    .clients-list {
        overflow-y: auto !important;
        height: auto;
        max-height: 300px;
    }
</style>
<script>
    import { mapGetters, mapMutations } from 'vuex'
    export default {
        data() {
            return {
                clientsListDialog: false,
            }
        },

        props: {
            newClientToggle: {
                type: Boolean,
            },
        },

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

                this.clientsListDialog = false
            },
        },
    }
</script>
