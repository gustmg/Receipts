<template>
    <v-dialog v-model="newReceiptDialog" width="480">
        <template v-slot:activator="{ on, attrs }">
            <v-speed-dial fixed bottom right>
                <template v-slot:activator>
                    <v-btn class="primary white--text" v-bind="attrs" v-on="on" fab>
                        <v-icon>mdi-plus</v-icon>
                    </v-btn>
                </template>
            </v-speed-dial>
        </template>
        <v-card>
            <v-stepper class="elevation-0" v-model="newReceiptStepper">
                <v-stepper-header>
                    <v-stepper-step step="1">Datos generales</v-stepper-step>
                    <v-divider></v-divider>
                    <v-stepper-step step="2">Equipos</v-stepper-step>
                </v-stepper-header>
                <v-stepper-content step="1">
                    <v-container class="py-0" fluid>
                        <v-row>
                            <v-col cols="6" class="py-0">
                                <div class="text-caption d-block text--secondary">{{ date }}</div>
                                <div class="text-subtitle-1 d-block">Recepción #{{ currentReceiptId }}</div>
                                <div class="text-subtitle-2 d-block">Realizada por Gustavo Mitre</div>
                            </v-col>
                            <v-col cols="12" class="py-0">
                                <v-form v-model="receiptClientForm">
                                    <v-row align="center">
                                        <v-col cols="6">
                                            <v-switch
                                                :value="newClientToggle"
                                                v-on:change="newClientToggleHandler"
                                                label="¿Cliente nuevo?"
                                            >
                                            </v-switch>
                                        </v-col>
                                        <v-col cols="6" align="center">
                                            <clients-list-modal-component
                                                :new-client-toggle="newClientToggle"
                                            ></clients-list-modal-component>
                                        </v-col>
                                        <v-col cols="5" class="py-0">
                                            <v-text-field
                                                label="Id cliente"
                                                v-model="receiptClientId"
                                                :disabled="newClientToggle == false"
                                                readonly
                                                filled
                                                rounded
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="7" class="py-0">
                                            <v-text-field
                                                label="Teléfono"
                                                v-model="clientPhone"
                                                :disabled="newClientToggle == false"
                                                :rules="clientPhoneRules"
                                                validate-on-blur
                                                type="tel"
                                                maxlength="10"
                                                minlength="10"
                                                filled
                                                rounded
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" class="py-0">
                                            <v-text-field
                                                label="Nombre *"
                                                v-model="clientName"
                                                :disabled="newClientToggle == false"
                                                :rules="clientNameRules"
                                                validate-on-blur
                                                maxlength="50"
                                                filled
                                                rounded
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-form>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-stepper-content>
                <v-stepper-content step="2">
                    <v-container class="py-0" fluid>
                        <v-row>
                            <v-col cols="12" v-show="newReceiptDevices.length > 0">
                                <div class="text-caption pb-2">Lista de equipos ({{ newReceiptDevices.length }})</div>
                                <v-expansion-panels v-model="devicesList">
                                    <v-expansion-panel
                                        v-for="(device, index) in newReceiptDevices"
                                        v-bind:key="device.device_id"
                                    >
                                        <v-expansion-panel-header>
                                            {{ device.device_name }}
                                        </v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                            <v-row>
                                                <v-col cols="12">
                                                    <div class="text-caption text--secondary">Número de serie</div>
                                                    <div v-if="device.device_serial_number" class="text-body-1">
                                                        {{ device.device_serial_number }}
                                                    </div>
                                                    <div v-else class="text-body-1">
                                                        Sin número de serie.
                                                    </div>
                                                </v-col>
                                                <v-col cols="12">
                                                    <div class="text-caption text--secondary">Servicio a realizar</div>
                                                    <div class="text-body-1">
                                                        {{ device.device_trouble_description }}
                                                    </div>
                                                </v-col>
                                                <v-col cols="12">
                                                    <div class="text-caption text--secondary pb-2">Accesorios</div>
                                                    <div
                                                        v-if="device.device_accessories.length == 0"
                                                        class="text-body-1 text--secondary text-center"
                                                    >
                                                        Sin accesorios.
                                                    </div>
                                                    <v-list class="elevation-1" v-else>
                                                        <v-list-item
                                                            v-for="(accessory, index) in device.device_accessories"
                                                            v-bind:key="accessory.accessory_id"
                                                        >
                                                            <v-list-item-content align="left">
                                                                <v-list-item-title>
                                                                    {{ accessory.accessory_name }}
                                                                </v-list-item-title>
                                                                <v-list-item-subtitle
                                                                    v-if="accessory.accessory_serial_number"
                                                                >
                                                                    {{ accessory.accessory_serial_number }}
                                                                </v-list-item-subtitle>
                                                                <v-list-item-subtitle v-else>
                                                                    Sin número de serie
                                                                </v-list-item-subtitle>
                                                            </v-list-item-content>
                                                        </v-list-item>
                                                    </v-list>
                                                </v-col>
                                                <v-col cols="12" align="right">
                                                    <v-btn icon v-on:click="removeDevice(index)">
                                                        <v-icon class="error--text">mdi-delete</v-icon>
                                                    </v-btn>
                                                </v-col>
                                            </v-row>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                                </v-expansion-panels>
                            </v-col>
                            <v-col cols="12" align="center">
                                <div class="text-h6 text--secondary pb-4" v-show="newReceiptDevices.length == 0">
                                    No hay equipos registrados
                                </div>
                                <new-device-modal-component></new-device-modal-component>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-stepper-content>
            </v-stepper>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn class="primary--text px-4" text v-on:click="closeReceiptDialog()">Cancelar</v-btn>
                <v-btn
                    class="primary white--text px-4"
                    v-on:click="newReceiptStepper++"
                    :disabled="!validStepForm"
                    :loading="loadingNextStepButton"
                >
                    {{ nextStepButtonText }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
    import { mapGetters, mapMutations, mapActions } from 'vuex'
    export default {
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                newReceiptDialog: false,
                newReceiptStepper: 1,
                nextStepButtonText: 'Siguiente',
                newClientToggle: false,
                receiptClientForm: false,
                loadingNextStepButton: false,
                devicesList: [],
                clientNameRules: [v => !!v || 'Este campo es requerido.'],
                clientPhoneRules: [
                    v => {
                        if (!v || v.length == 0 || v.length == 10) return true
                        return 'Por favor, ingrese el número telefónico a 10 dígitos.'
                    },
                ],
            }
        },

        watch: {
            newReceiptStepper: function(newStep) {
                if (newStep == 1) {
                    this.nextStepButtonText = 'Siguiente'
                } else if (newStep == 2) {
                    this.nextStepButtonText = 'Registrar'
                } else this.processReceipt()
            },
        },

        computed: {
            ...mapGetters('receipts', {
                currentReceiptId: 'getCurrentReceiptId',
                receiptClientId: 'getReceiptClientId',
                receiptClientName: 'getReceiptClientName',
                receiptClientPhone: 'getReceiptClientPhone',
                receiptClientEmail: 'getReceiptClientEmail',
            }),

            ...mapGetters('clients', {
                clients: 'getClients',
                newClientId: 'getNewClientId',
            }),

            ...mapGetters('devices', {
                newReceiptDevices: 'getDevices',
            }),

            date: function() {
                var d = new Date()

                switch (d.getMonth()) {
                    case 0:
                        return 'Enero ' + d.getDate() + ', ' + d.getFullYear()
                    case 1:
                        return 'Febrero ' + d.getDate() + ', ' + d.getFullYear()
                    case 2:
                        return 'Marzo ' + d.getDate() + ', ' + d.getFullYear()
                    case 3:
                        return 'Abril ' + d.getDate() + ', ' + d.getFullYear()
                    case 4:
                        return 'Mayo ' + d.getDate() + ', ' + d.getFullYear()
                    case 5:
                        return 'Junio ' + d.getDate() + ', ' + d.getFullYear()
                    case 6:
                        return 'Julio ' + d.getDate() + ', ' + d.getFullYear()
                    case 7:
                        return 'Agosto ' + d.getDate() + ', ' + d.getFullYear()
                    case 8:
                        return 'Septiembre ' + d.getDate() + ', ' + d.getFullYear()
                    case 9:
                        return 'Octubre ' + d.getDate() + ', ' + d.getFullYear()
                    case 10:
                        return 'Noviembre ' + d.getDate() + ', ' + d.getFullYear()
                    case 11:
                        return 'Diciembre ' + d.getDate() + ', ' + d.getFullYear()
                    default:
                        break
                }
            },

            clientName: {
                get() {
                    return this.receiptClientName
                },
                set(value) {
                    this.SET_RECEIPT_CLIENT_NAME(value)
                },
            },

            clientPhone: {
                get() {
                    return this.receiptClientPhone
                },
                set(value) {
                    this.SET_RECEIPT_CLIENT_PHONE(value)
                },
            },

            clientEmail: {
                get() {
                    return this.receiptClientEmail
                },
                set(value) {
                    this.SET_RECEIPT_CLIENT_EMAIL(value)
                },
            },

            validStepForm: function() {
                if (!this.loadingNextStepButton) {
                    if (this.newReceiptStepper == 1) {
                        if (this.newClientToggle) {
                            if (this.receiptClientForm) {
                                return true
                            } else return false
                        } else {
                            if (this.clientName != '' && this.clientPhone != '') {
                                return true
                            } else return false
                        }
                    } else if (this.newReceiptStepper == 2) {
                        if (this.newReceiptDevices.length != 0) {
                            return true
                        } else return false
                    }
                } else return false
            },
        },

        methods: {
            ...mapMutations('receipts', [
                'SET_RECEIPT_CLIENT_ID',
                'SET_RECEIPT_CLIENT_NAME',
                'SET_RECEIPT_CLIENT_PHONE',
                'SET_RECEIPT_CLIENT_EMAIL',
            ]),
            ...mapMutations('devices', ['RESET_DEVICES', 'REMOVE_DEVICE']),
            ...mapMutations('accessories', ['RESET_ACCESSORIES']),
            ...mapActions('receipts', ['saveReceipt', 'printReceipt', 'fetchReceipts', 'fetchLastReceiptId']),
            ...mapActions('devices', ['saveDevices']),
            ...mapActions('clients', ['saveClient', 'fetchClients', 'fetchLastClientId']),

            processReceipt: async function() {
                this.loadingNextStepButton = true
                if (this.newClientToggle) {
                    await this.saveClient({
                        client_name: this.clientName,
                        client_phone: this.clientPhone,
                        client_email: this.clientEmail,
                    })
                    await this.fetchClients()
                    await this.fetchLastClientId()
                }

                await this.saveReceipt()
                await this.saveDevices(this.currentReceiptId)
                // await this.printReceipt(this.currentReceiptId)

                await this.fetchReceipts()
                await this.fetchLastReceiptId()
                this.resetReceipt()
                this.newReceiptDialog = false
                this.loadingNextStepButton = false
            },

            resetReceipt: function(e) {
                this.newReceiptStepper = 1
                this.SET_RECEIPT_CLIENT_ID(this.newClientId)
                this.SET_RECEIPT_CLIENT_NAME('')
                this.SET_RECEIPT_CLIENT_PHONE('')
                this.SET_RECEIPT_CLIENT_EMAIL('')
                this.RESET_DEVICES()
                this.RESET_ACCESSORIES()
                this.newClientToggle = false
            },

            newClientToggleHandler: function() {
                this.newClientToggle = !this.newClientToggle
                if (this.newClientToggle) {
                    this.SET_RECEIPT_CLIENT_ID(this.newClientId)
                } else {
                    this.SET_RECEIPT_CLIENT_ID('')
                }
                this.SET_RECEIPT_CLIENT_NAME('')
                this.SET_RECEIPT_CLIENT_PHONE('')
                this.SET_RECEIPT_CLIENT_EMAIL('')
            },

            removeDevice: function(deviceIndex) {
                this.devicesList = []
                this.REMOVE_DEVICE(deviceIndex)
            },

            closeReceiptDialog: function() {
                this.newReceiptDialog = false
                this.resetReceipt()
            },
        },
    }
</script>
