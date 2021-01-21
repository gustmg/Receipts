<template>
    <v-dialog v-model="newDeviceDialog" width="480">
        <template v-slot:activator="{ on, attrs }">
            <v-btn class="secondary" fab v-bind="attrs" v-on="on"><v-icon>mdi-plus</v-icon></v-btn>
        </template>
        <v-card>
            <v-card-title>Equipo a recibir</v-card-title>
            <v-card-text>
                <v-container>
                    <div class="text-caption">Datos generales</div>
                    <v-form v-model="newDeviceForm" ref="newDeviceForm">
                        <v-row>
                            <v-col cols="8">
                                <v-text-field
                                    color="secondary"
                                    v-model="newDeviceName"
                                    label="Nombre del equipo *"
                                    :rules="requiredRule"
                                    filled
                                    rounded
                                    dense
                                    validate-on-blur
                                ></v-text-field>
                            </v-col>
                            <v-col cols="4">
                                <v-text-field
                                    color="secondary"
                                    v-model="newDeviceSerialNumber"
                                    label="Número de serie"
                                    :rules="serialNumberRules"
                                    filled
                                    rounded
                                    dense
                                    validate-on-blur
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    color="secondary"
                                    v-model="newDeviceTroubleDescription"
                                    label="Descripción de la falla o servicio a realizar *"
                                    :rules="requiredRule"
                                    filled
                                    rounded
                                    dense
                                    validate-on-blur
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    color="secondary"
                                    v-model="newDeviceServiceCommentary"
                                    label="Comentario sobre el equipo"
                                    filled
                                    rounded
                                    dense
                                    validate-on-blur
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-form>
                    <div class="text-caption">Accesorios</div>
                    <v-row>
                        <v-col cols="12" align="center">
                            <div class="text-h6 pb-4" v-if="deviceAccessories.length == 0">
                                No hay accesorios registrados
                            </div>
                            <v-card class="mb-4" v-else>
                                <v-list>
                                    <v-list-item
                                        v-for="(accessory, index) in deviceAccessories"
                                        v-bind:key="accessory.accessory_id"
                                    >
                                        <v-list-item-content align="left">
                                            <v-list-item-title>
                                                {{ accessory.accessory_name }}
                                            </v-list-item-title>
                                            <v-list-item-subtitle v-if="accessory.accessory_serial_number">
                                                {{ accessory.accessory_serial_number }}
                                            </v-list-item-subtitle>
                                            <v-list-item-subtitle v-else>
                                                Sin número de serie
                                            </v-list-item-subtitle>
                                        </v-list-item-content>
                                        <v-list-item-action>
                                            <v-btn icon v-on:click="REMOVE_ACCESSORY(index)">
                                                <v-icon class="red--text">mdi-close-circle</v-icon>
                                            </v-btn>
                                        </v-list-item-action>
                                    </v-list-item>
                                </v-list>
                            </v-card>
                            <new-accessory-modal-component></new-accessory-modal-component>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>
            <v-card-actions class="py-0">
                <v-container>
                    <v-row>
                        <v-col cols="6">
                            <v-btn class="secondary--text" block text v-on:click="resetNewDeviceInputs">
                                Cancelar
                            </v-btn>
                        </v-col>
                        <v-col cols="6">
                            <v-btn class="secondary" block v-on:click="addDevice" :disabled="!newDeviceForm">
                                Agregar
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
    import { mapMutations, mapGetters } from 'vuex'
    export default {
        mounted() {
            console.log('New device modal mounted.')
        },

        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                newDeviceDialog: false,
                newDeviceForm: false,
                newDeviceName: null,
                newDeviceSerialNumber: null,
                newDeviceTroubleDescription: null,
                newDeviceServiceCommentary: null,
                requiredRule: [v => !!v || 'Este campo es requerido.'],
                serialNumberRules: [
                    v => {
                        if (!v || v.length == 0) return true
                        if (!v || v.length > 3) return true
                        return 'El número de serie debe contener al menos 4 caracteres.'
                    },
                ],
            }
        },

        computed: {
            ...mapGetters('accessories', {
                deviceAccessories: 'getAccessories',
            }),

            validateForm: function(e) {
                if (!this.validDeviceName || !this.validDeviceTroubleDescription) {
                    return true
                }
            },
        },

        methods: {
            ...mapMutations('devices', ['ADD_DEVICE_TO_LIST']),
            ...mapMutations('accessories', ['RESET_ACCESSORIES', 'REMOVE_ACCESSORY']),

            addDevice: function() {
                this.ADD_DEVICE_TO_LIST({
                    device_name: this.newDeviceName,
                    device_serial_number: this.newDeviceSerialNumber,
                    device_trouble_description: this.newDeviceTroubleDescription,
                    device_service_commentary: this.newDeviceServiceCommentary,
                    device_accessories: this.deviceAccessories,
                })
                this.resetNewDeviceInputs()
                this.newDeviceDialog = false
            },

            validateDeviceName: function(e) {
                if (!this.newDeviceName) {
                    this.validDeviceName = false
                    this.invalidDeviceName = true
                    $('.device_name_helper').attr('data-error', 'Este campo no puede quedar vacío.')
                } else {
                    this.validDeviceName = true
                    this.invalidDeviceName = false
                }
            },

            validateDeviceTroubleDescription: function(e) {
                if (!this.newDeviceTroubleDescription) {
                    this.validDeviceTroubleDescription = false
                    this.invalidDeviceTroubleDescription = true
                    $('.device_trouble_description_helper').attr('data-error', 'Este campo no puede quedar vacío.')
                } else {
                    this.validDeviceTroubleDescription = true
                    this.invalidDeviceTroubleDescription = false
                }
            },

            resetNewDeviceInputs: function(e) {
                this.$refs.newDeviceForm.reset()
                this.$refs.newDeviceForm.resetValidation()
                this.RESET_ACCESSORIES()
                this.newDeviceDialog = false
            },
        },
    }
</script>
