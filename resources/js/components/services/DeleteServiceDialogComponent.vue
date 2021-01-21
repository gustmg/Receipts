<template>
    <v-dialog v-model="deleteServiceDialog" width="480">
        <template v-slot:activator="{ on, attrs }">
            <v-btn icon v-on="on" v-bind="attrs">
                <v-icon>mdi-delete</v-icon>
            </v-btn>
        </template>
        <v-card>
            <v-card-title class="font-weight-bold justify-center">Eliminar serviceo</v-card-title>
            <v-card-text>
                Los registros relacionados con este serviceo serán eliminados.
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn class="secondary--text px-4" text v-on:click="deleteServiceDialog = false">Cancelar</v-btn>
                <v-btn class="error white--text px-4" v-on:click="triggerDeleteService()">
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
            serviceId: {
                type: Number,
            },
        },

        data() {
            return {
                deleteServiceDialog: false,
            }
        },

        methods: {
            ...mapActions('services', ['deleteService', 'fetchServices']),

            triggerDeleteService: async function() {
                await this.deleteService(this.serviceId)
                await this.fetchServices()
                this.deleteServiceDialog = false
            },
        },
    }
</script>
