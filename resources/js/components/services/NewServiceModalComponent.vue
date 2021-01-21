<template>
    <v-dialog v-model="newServiceDialog" width="480">
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
            <v-card-title class="justify-center">Nuevo servicio</v-card-title>
            <v-card-text>
                <v-container>
                    <v-form v-model="newServiceForm" ref="newServiceForm">
                        <v-row>
                            <v-col cols="7">
                                <v-text-field
                                    label="Nombre"
                                    color="secondary"
                                    v-model="newService.service_name"
                                    :rules="serviceNameRules"
                                    filled
                                    rounded
                                ></v-text-field>
                            </v-col>
                            <v-col cols="5">
                                <v-text-field
                                    label="Código interno"
                                    color="secondary"
                                    v-model="newService.service_code"
                                    filled
                                    rounded
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    label="Descripción"
                                    color="secondary"
                                    v-model="newService.service_description"
                                    filled
                                    rounded
                                ></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    label="Costo ($)"
                                    color="secondary"
                                    min="1"
                                    type="number"
                                    v-model="newService.service_cost"
                                    filled
                                    rounded
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <div class="text-subtitle-2">Porcentaje de ganancias</div>
                            </v-col>
                            <v-col cols="4">
                                <v-text-field
                                    label="PEG"
                                    color="secondary"
                                    type="number"
                                    min="0"
                                    max="100"
                                    :rules="percentageRules"
                                    v-model="newService.service_base_price_percentage"
                                    filled
                                    rounded
                                    validate-on-blur
                                ></v-text-field>
                            </v-col>
                            <v-col cols="4">
                                <v-text-field
                                    label="Menudeo"
                                    color="secondary"
                                    type="number"
                                    min="0"
                                    max="100"
                                    :rules="percentageRules"
                                    v-model="newService.service_retail_price_percentage"
                                    filled
                                    rounded
                                    validate-on-blur
                                ></v-text-field>
                            </v-col>
                            <v-col cols="4">
                                <v-text-field
                                    label="Mayoreo"
                                    color="secondary"
                                    type="number"
                                    min="0"
                                    max="100"
                                    :rules="percentageRules"
                                    v-model="newService.service_wholesale_price_percentage"
                                    filled
                                    rounded
                                    validate-on-blur
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn class="secondary--text px-4" text v-on:click="closeServiceDialog()">Cancelar</v-btn>
                <v-btn
                    class="secondary primary--text px-4"
                    :disabled="!newServiceForm"
                    v-on:click="triggerSaveService()"
                >
                    Registrar
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<style scoped>
    .newServiceModal {
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
        data() {
            return {
                newServiceDialog: false,
                newServiceForm: false,
                newService: {
                    service_name: '',
                    service_code: '',
                    service_description: '',
                    service_cost: 0,
                    service_base_price_percentage: 0,
                    service_retail_price_percentage: 0,
                    service_wholesale_price_percentage: 0,
                },

                serviceNameRules: [v => !!v || 'Este campo es requerido.'],
                percentageRules: [v => (v >= 0 && v <= 100) || 'Porcentaje no válido.'],
            }
        },

        methods: {
            ...mapActions('services', ['saveService', 'fetchServices']),

            triggerSaveService: async function() {
                await this.saveService(this.newService)
                await this.fetchServices()
                this.closeServiceDialog()
            },

            closeServiceDialog: function() {
                this.newServiceDialog = false
                this.resetNewServiceForm()
            },

            resetNewServiceForm: function(e) {
                this.newService.service_name = ''
                this.newService.service_code = ''
                this.newService.service_description = ''
                this.$refs.newServiceForm.reset()
            },
        },
    }
</script>
