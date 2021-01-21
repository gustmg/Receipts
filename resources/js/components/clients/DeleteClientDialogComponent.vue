<template>
    <v-dialog v-model="deleteClientDialog" width="480">
        <template v-slot:activator="{ on, attrs }">
            <v-btn icon v-on="on" v-bind="attrs">
                <v-icon>mdi-delete</v-icon>
            </v-btn>
        </template>
        <v-card>
            <v-card-title class="font-weight-bold justify-center">Eliminar cliente</v-card-title>
            <v-card-text>
                Los registros de venta de este usuario serán eliminados también.
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn class="secondary--text px-4" text v-on:click="deleteClientDialog = false">Cancelar</v-btn>
                <v-btn class="error white--text px-4" v-on:click="triggerDeleteClient()">
                    Eliminar
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<style></style>
<script>
    import { mapActions } from 'vuex'

    export default {
        props: {
            clientId: {
                type: Number,
            },
        },

        data() {
            return {
                deleteClientDialog: false,
            }
        },

        methods: {
            ...mapActions('clients', ['deleteClient', 'fetchClients']),

            triggerDeleteClient: async function() {
                await this.deleteClient(this.clientId)
                await this.fetchClients()
                this.deleteClientDialog = false
            },
        },
    }
</script>
