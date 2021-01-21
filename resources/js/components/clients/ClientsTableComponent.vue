<template>
    <v-row>
        <v-col cols="12">
            <v-card>
                <v-data-table
                    :headers="clientsTableHeaders"
                    :items="filteredClients"
                    show-select
                    item-key="client_id"
                    hide-default-footer
                >
                    <template v-slot:item.client_options="{ item }">
                        <edit-client-dialog-component :client="item"></edit-client-dialog-component>
                        <delete-client-dialog-component :client-id="item.client_id"></delete-client-dialog-component>
                    </template>
                </v-data-table>
            </v-card>
        </v-col>
    </v-row>
</template>
<script>
    import { mapState, mapMutations, mapActions, mapGetters } from 'vuex'

    export default {
        data() {
            return {
                clientsTableHeaders: [
                    { text: 'Nombre', value: 'client_name' },
                    { text: 'Teléfono', value: 'client_phone' },
                    { text: 'Correo electrónico', value: 'client_email' },
                    { text: 'Opciones', value: 'client_options' },
                ],
            }
        },

        methods: {
            ...mapActions(['setClientToUpdate', 'openModal']),

            updateClient: function(client) {
                this.setClientToUpdate(client)
                this.openModal($('#updateClientModal'))
            },
        },

        computed: {
            ...mapState(['client_to_update']),
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
    }
</script>
