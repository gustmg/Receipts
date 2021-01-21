<template>
    <v-dialog v-model="editClientDialog" width="480">
        <template v-slot:activator="{ on, attrs }">
            <v-btn icon v-on="on" v-bind="attrs"><v-icon>mdi-pencil</v-icon></v-btn>
        </template>
        <v-card>
            <v-card-title class="font-weight-bold justify-center">Editar cliente</v-card-title>
            <v-card-text>
                <v-container>
                    <v-form v-model="editClientForm">
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                    label="Nombre"
                                    v-model="copyClient.client_name"
                                    filled
                                    rounded
                                    :rules="clientNameRules"
                                    validate-on-blur
                                ></v-text-field>
                            </v-col>
                            <v-col cols="5">
                                <v-text-field
                                    label="Teléfono"
                                    type="tel"
                                    v-model="copyClient.client_phone"
                                    filled
                                    rounded
                                    :rules="clientPhoneRules"
                                    validate-on-blur
                                    counter="10"
                                    maxlength="10"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="7">
                                <v-text-field
                                    label="Correo electrónico"
                                    v-model="copyClient.client_email"
                                    filled
                                    rounded
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn class="secondary--text px-4" text v-on:click="editClientDialog = false">Cancelar</v-btn>
                <v-btn
                    class="secondary primary--text px-4"
                    :disabled="!editClientForm"
                    v-on:click="triggerUpdateClient()"
                >
                    Editar
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
            client: {
                type: Object,
            },
        },

        data() {
            return {
                editClientDialog: false,
                editClientForm: false,

                clientNameRules: [v => !!v || 'Este campo es requerido.'],
                clientPhoneRules: [v => v.length == 10 || 'Ingrese el teléfono a 10 dígitos'],
            }
        },

        computed: {
            copyClient: function() {
                return _.cloneDeep(this.client)
            },
        },

        methods: {
            ...mapActions('clients', ['updateClient', 'fetchClients']),

            triggerUpdateClient: async function() {
                await this.updateClient(this.copyClient)
                await this.fetchClients()
                this.editClientDialog = false
            },
        },
    }
</script>
