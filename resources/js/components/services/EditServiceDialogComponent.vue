<template>
    <v-dialog v-model="editServiceDialog" width="480">
        <template v-slot:activator="{ on, attrs }">
            <v-btn icon v-on="on" v-bind="attrs"><v-icon>mdi-pencil</v-icon></v-btn>
        </template>
        <v-card>
            <v-card-title class="font-weight-bold justify-center">Editar serviceo</v-card-title>
            <v-card-text>
                <v-container>
                    <v-form v-model="editServiceForm">
                        <v-row>
                            <v-col cols="7">
                                <v-text-field
                                    label="Nombre"
                                    color="secondary"
                                    v-model="service_name"
                                    filled
                                    rounded
                                ></v-text-field>
                            </v-col>
                            <v-col cols="5">
                                <v-text-field
                                    label="Código interno"
                                    color="secondary"
                                    v-model="service_code"
                                    filled
                                    rounded
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    label="Descripción"
                                    color="secondary"
                                    v-model="service_description"
                                    filled
                                    rounded
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    label="Costo"
                                    color="secondary"
                                    type="number"
                                    min="0"
                                    v-model="service_cost"
                                    :rules="costRules"
                                    filled
                                    rounded
                                    validate-on-blur
                                ></v-text-field>
                                <v-expand-transition>
                                    <v-alert v-if="lowerCost" color="warning">
                                        <div class="text-subtitle-2">
                                            El costo ingresado es menor que el costo previamente registrado. Esto puede
                                            ocasionar pérdidas en sus ventas.
                                        </div>
                                    </v-alert>
                                </v-expand-transition>
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
                                    v-model="service_base_price_percentage"
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
                                    v-model="service_retail_price_percentage"
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
                                    v-model="service_wholesale_price_percentage"
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
                <v-btn class="secondary--text px-4" text v-on:click="editServiceDialog = false">Cancelar</v-btn>
                <v-btn
                    class="secondary primary--text px-4"
                    :disabled="!editServiceForm"
                    v-on:click="triggerUpdateService()"
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
        mounted() {
            this.service_name = this.service.service_name
            this.service_code = this.service.service_code
            this.service_description = this.service.service_description
            this.service_cost = this.service.service_cost
            this.service_base_price_percentage = this.service.service_base_price_percentage
            this.service_retail_price_percentage = this.service.service_retail_price_percentage
            this.service_wholesale_price_percentage = this.service.service_wholesale_price_percentage
        },

        props: {
            service: {
                type: Object,
            },
        },

        data() {
            return {
                editServiceDialog: false,
                editServiceForm: false,
                lowerCost: false,
                service_name: '',
                service_code: '',
                service_description: '',
                service_cost: 0,
                service_base_price_percentage: 0,
                service_retail_price_percentage: 0,
                service_wholesale_price_percentage: 0,

                serviceNameRules: [v => !!v || 'Este campo es requerido.'],
                percentageRules: [v => (v >= 0 && v <= 100) || 'Porcentaje no válido.'],
                costRules: [v => !!v || 'Campo requerido.', v => v > 0 || 'El costo ingresado no es válido'],
            }
        },

        watch: {
            service_cost: function(newCost) {
                if (newCost < this.service.service_cost) {
                    this.lowerCost = true
                } else this.lowerCost = false
            },
        },

        methods: {
            ...mapActions('services', ['updateService', 'fetchServices']),

            triggerUpdateService: async function() {
                await this.updateService({
                    service_id: this.service.service_id,
                    service_name: this.service_name,
                    service_code: this.service_code,
                    service_description: this.service_description,
                    service_cost: this.service_cost,
                    service_base_price_percentage: this.service_base_price_percentage,
                    service_retail_price_percentage: this.service_retail_price_percentage,
                    service_wholesale_price_percentage: this.service_wholesale_price_percentage,
                })
                await this.fetchServices()
                this.editServiceDialog = false
            },
        },
    }
</script>
