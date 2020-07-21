<template>
    <div id="newReceiptModal" class="modal newReceiptModal">
        <div class="modal-content">
            <h5>Nueva recepción</h5>
            <br />
            <div class="row" style="margin-bottom:0 !important;">
                <div class="col m5">
                    <div class="row">
                        <div class="col m12">
                            <span><b>DATOS DE RECEPCIÓN</b></span>
                        </div>
                        <div class="col s5">
                            <span><b>Folio</b></span>
                        </div>
                        <div class="col s7">
                            <span>{{ currentReceiptId }}</span>
                        </div>
                        <div class="col s5">
                            <span><b>Fecha</b></span>
                        </div>
                        <div class="col s7">
                            <span>{{ date }}</span>
                        </div>
                    </div>
                </div>
                <div class="col m7">
                    <div class="row">
                        <div class="col m12">
                            <span><b>DATOS DEL CLIENTE</b></span>
                        </div>
                        <div class="col m12">
                            <div class="row">
                                <div class="col m12">
                                    <div class="switch">
                                        <label>
                                            <b>¿Cliente nuevo?</b>
                                            <input
                                                type="checkbox"
                                                v-model="newClientToggle"
                                                v-on:click="newClientToggleHandler"
                                            />
                                            <span class="lever"></span>
                                        </label>
                                        <button
                                            v-on:click="showClientsList"
                                            class="mdc-button mdc-button--outlined"
                                            :disabled="newClientToggle == true"
                                        >
                                            Buscar cliente
                                        </button>
                                    </div>
                                    <br />
                                </div>
                                <div class="col m12">
                                    <form class="row">
                                        <div class="input-field col s4">
                                            <input
                                                placeholder=""
                                                v-model="receiptClientId"
                                                id="receipt_client_id"
                                                type="text"
                                                disabled
                                            />
                                            <label for="client_id">No. de cliente</label>
                                        </div>
                                        <div class="input-field col s8">
                                            <input
                                                placeholder=""
                                                v-model="clientName"
                                                id="receipt_client_name"
                                                type="text"
                                                :disabled="newClientToggle == false"
                                                v-on:blur="validateReceiptClientName"
                                                v-bind:class="{
                                                    valid: validClientName,
                                                    invalid: invalidClientName,
                                                }"
                                                data-length="50"
                                                maxlength="50"
                                                required
                                            />
                                            <label for="client_name">Nombre</label>
                                        </div>
                                        <div class="input-field col s8">
                                            <input
                                                placeholder=""
                                                v-model="clientEmail"
                                                id="receipt_client_email"
                                                type="email"
                                                :disabled="newClientToggle == false"
                                                v-on:blur="validateReceiptClientEmail"
                                                v-bind:class="{
                                                    valid: validClientEmail,
                                                    invalid: invalidClientEmail,
                                                }"
                                                data-length="40"
                                                maxlength="40"
                                            />
                                            <label for="client_email">E-mail</label>
                                        </div>
                                        <div class="input-field col s4">
                                            <input
                                                placeholder=""
                                                v-model="clientPhone"
                                                id="receipt_client_phone"
                                                type="tel"
                                                :disabled="newClientToggle == false"
                                                v-on:blur="validateReceiptClientPhone"
                                                v-bind:class="{
                                                    valid: validClientPhone,
                                                    invalid: invalidClientPhone,
                                                }"
                                                data-length="10"
                                                minlength="10"
                                                maxlength="10"
                                            />
                                            <label for="client_phone">Teléfono</label>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col m12">
                    <span><b>EQUIPOS</b></span>
                    <div class="row">
                        <div
                            class="col s12 m4"
                            v-show="newReceiptDevices.length > 0"
                            v-for="(device, index) in newReceiptDevices"
                            v-bind:key="device.device_id"
                        >
                            <div
                                v-on:click="updateDevice(device, index)"
                                class="card hoverable hoverable-card selectable"
                            >
                                <div class="card">
                                    <div class="card-content">
                                        <span class="card-title"
                                            ><b>{{ device.device_name }}</b></span
                                        >
                                        <span><b>SN:</b> {{ device.device_serial_number }}</span
                                        ><br />
                                        <span><b>Descripción:</b> {{ device.device_trouble_description }}</span
                                        ><br />
                                        <span><b>Accesorios:</b></span>
                                        <ul class="collection" v-show="device.device_accessories.length > 0">
                                            <li
                                                class="collection-item"
                                                v-for="accessory in device.device_accessories"
                                                v-bind:key="accessory.accessory_id"
                                            >
                                                {{ accessory.accessory_name }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h5 v-show="newReceiptDevices.length == 0" class="center grey-text">
                                No hay equipos registrados.<br /><br />
                            </h5>
                        </div>
                        <new-device-button-component></new-device-button-component>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button v-on:click="resetReceipt" class="modal-action modal-close waves-effect btn-flat">
                <b>Cancelar</b>
            </button>
            <button
                v-on:click="processReceipt"
                type="submit"
                v-bind:class="{ disabled: validateForm }"
                class="modal-action btn waves-effect submit_button"
            >
                <b>Registrar</b>
            </button>
        </div>
    </div>
</template>
<style type="text/css">
    .inline-icon-large {
        vertical-align: bottom;
        font-size: 48px !important;
    }
    .inline-icon-small {
        vertical-align: bottom;
        font-size: 20px !important;
    }
    .helper-text {
        min-height: 0 !important;
    }
    .no-vertical-margin {
        margin-top: 0;
        margin-bottom: 0;
    }
    .modal-content {
        padding-bottom: 0 !important;
    }
    .newReceiptModal {
        width: 75% !important;
    }
</style>
<script>
    import { mapGetters, mapMutations, mapActions } from 'vuex'
    export default {
        mounted() {
            console.log('New receipt modal mounted.')
        },

        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                validClientName: false,
                invalidClientName: false,
                validClientPhone: false,
                invalidClientPhone: false,
                validClientEmail: false,
                invalidClientEmail: false,
                newClientToggle: false,
            }
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

            validateForm: function(e) {
                if (this.newClientToggle) {
                    if (
                        this.newReceiptDevices.length == 0 ||
                        !this.validClientName ||
                        this.invalidClientPhone ||
                        this.invalidClientEmail
                    ) {
                        return true
                    }
                } else {
                    if (this.newReceiptDevices.length == 0 || this.clientName == '') {
                        return true
                    }
                }
            },

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
        },

        methods: {
            ...mapMutations('receipts', [
                'SET_RECEIPT_CLIENT_ID',
                'SET_RECEIPT_CLIENT_NAME',
                'SET_RECEIPT_CLIENT_PHONE',
                'SET_RECEIPT_CLIENT_EMAIL',
            ]),
            ...mapMutations('devices', ['RESET_DEVICES']),
            ...mapMutations('accessories', ['RESET_ACCESSORIES']),
            ...mapActions('receipts', ['saveReceipt', 'printReceipt', 'fetchReceipts', 'fetchLastReceiptId']),
            ...mapActions('devices', ['saveDevices']),
            ...mapActions('clients', ['saveClient', 'fetchClients', 'fetchLastClientId']),

            processReceipt: async function() {
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
                $('#newReceiptModal').modal('close')
            },

            validateReceiptClientName: function(e) {
                if (!this.clientName) {
                    this.validClientName = false
                    this.invalidClientName = true
                    $('.receipt_name_helper').attr('data-error', 'Este campo no puede quedar vacío.')
                } else {
                    this.validClientName = true
                    this.invalidClientName = false
                }
            },

            validateReceiptClientPhone: function(e) {
                const PHONE_REGEXP = /^[0-9]*$/gm

                if (this.clientPhone == null || this.clientPhone.length == 0) {
                    this.validClientPhone = false
                    this.invalidClientPhone = false
                } else if (!PHONE_REGEXP.test(this.clientPhone) || this.clientPhone.length < 10) {
                    this.validClientPhone = false
                    this.invalidClientPhone = true
                    $('.receipt_phone_helper').attr('data-error', 'Número telefónico no válido.')
                } else {
                    this.validClientPhone = true
                    this.invalidClientPhone = false
                }
            },

            validateReceiptClientEmail: function(e) {
                const MAIL_REGEXP = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/

                if (this.clientEmail == null || this.clientEmail.length == 0) {
                    this.validClientEmail = false
                    this.invalidClientEmail = false
                } else if (!MAIL_REGEXP.test(this.clientEmail)) {
                    this.validClientEmail = false
                    this.invalidClientEmail = true
                    $('.receipt_email_helper').attr('data-error', 'Correo electrónico no válido.')
                } else {
                    this.validClientEmail = true
                    this.invalidClientEmail = false
                }
            },

            resetReceipt: function(e) {
                this.SET_RECEIPT_CLIENT_ID(this.newClientId)
                this.SET_RECEIPT_CLIENT_NAME('')
                this.SET_RECEIPT_CLIENT_PHONE('')
                this.SET_RECEIPT_CLIENT_EMAIL('')
                this.RESET_DEVICES()
                this.RESET_ACCESSORIES()

                this.validClientName = false
                this.invalidClientName = false
                this.validClientPhone = false
                this.invalidClientPhone = false
                this.validClientEmail = false
                this.invalidClientEmail = false
                this.newClientToggle = false
            },

            showClientsList: function() {
                $('#clientsCompactListModal').modal({
                    dismissible: true,
                })
                $('#clientsCompactListModal').modal('open')
            },

            newClientToggleHandler: function() {
                this.SET_RECEIPT_CLIENT_ID(this.newClientId)
                this.SET_RECEIPT_CLIENT_NAME('')
                this.SET_RECEIPT_CLIENT_PHONE('')
                this.SET_RECEIPT_CLIENT_EMAIL('')

                this.validClientName = false
                this.invalidClientName = false
                this.validClientPhone = false
                this.invalidClientPhone = false
                this.validClientEmail = false
                this.invalidClientEmail = false
            },
        },
    }
</script>
