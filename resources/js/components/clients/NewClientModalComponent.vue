<template>
    <v-dialog v-model="newClientDialog" width="480">
        <template v-slot:activator="{ on, attrs }">
            <v-speed-dial fixed bottom right>
                <template v-slot:activator>
                    <v-btn class="secondary primary--text" v-bind="attrs" v-on="on" fab>
                        <v-icon>mdi-plus</v-icon>
                    </v-btn>
                </template>
            </v-speed-dial>
        </template>
        <v-card>
            <v-card-title class="justify-center">Nuevo cliente</v-card-title>
            <v-card-text>
                <v-container>
                    <v-form v-model="newClientForm">
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                    label="Nombre"
                                    v-model="newClient.client_name"
                                    filled
                                    rounded
                                    :rules="clientNameRules"
                                    validate-on-blur
                                ></v-text-field>
                            </v-col>
                            <v-col cols="5">
                                <v-text-field
                                    label="Teléfono"
                                    v-model="newClient.client_phone"
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
                                    v-model="newClient.client_email"
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
                <v-btn class="secondary--text px-4" text v-on:click="closeClientDialog()">Cancelar</v-btn>
                <v-btn class="secondary primary--text px-4" :disabled="!newClientForm" v-on:click="triggerSaveClient()">
                    Registrar
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<style scoped>
    .newClientModal {
        width: 37%;
        max-height: 80%;
        height: 55%;
    }
    .money {
        height: 84px;
    }
    .no-margin-bottom {
        margin-bottom: 0;
    }
</style>
<script>
    import { mapState, mapMutations, mapActions } from 'vuex'
    export default {
        mounted() {},

        data() {
            return {
                newClientDialog: false,
                newClientForm: false,
                newClient: {
                    client_name: '',
                    client_phone: '',
                    client_email: '',
                },

                clientNameRules: [v => !!v || 'Este campo es requerido.'],
                clientPhoneRules: [v => v.length == 10 || 'Ingrese el teléfono a 10 dígitos'],
            }
        },

        methods: {
            ...mapActions('clients', ['saveClient', 'fetchClients']),

            triggerSaveClient: async function() {
                await this.saveClient(this.newClient)
                await this.fetchClients()
                this.closeClientDialog()
            },

            closeClientDialog: function() {
                this.newClientDialog = false
                this.resetNewClientForm()
            },

            resetNewClientForm: function(e) {
                this.newClient.client_name = ''
                this.newClient.client_phone = ''
                this.newClient.client_email = ''
            },
        },
    }
</script>
