<template>
    <v-col cols="4">
        <v-row>
            <v-col cols="12">
                <div class="text-subtitle-1 text--secondary pb-2">Información de venta</div>
                <div class="subtitle-2">Folio: {{ currentSaleId }}</div>
                <div class="subtitle-2">Fecha: {{ date }}</div>
                <v-divider></v-divider>
                <v-row>
                    <v-col cols="12" class="pb-0">
                        <div class="text-subtitle-1 text--secondary">Información de cliente</div>
                        <v-form v-model="saleClientForm">
                            <v-row align="center">
                                <v-col cols="6" class="pt-0">
                                    <v-switch
                                        v-model="newClientToggle"
                                        v-on:change="newClientToggleHandler"
                                        label="¿Cliente nuevo?"
                                        color="secondary"
                                        dense
                                    >
                                    </v-switch>
                                </v-col>
                                <v-col cols="6" align="center" class="pt-0">
                                    <clients-list-modal-component
                                        :new-client-toggle="newClientToggle"
                                    ></clients-list-modal-component>
                                </v-col>
                                <v-col cols="5" class="py-0">
                                    <v-text-field
                                        label="Id cliente"
                                        color="secondary"
                                        v-model="saleClientId"
                                        :disabled="newClientToggle == false"
                                        readonly
                                        filled
                                        rounded
                                        dense
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="7" class="py-0">
                                    <v-text-field
                                        label="Teléfono"
                                        color="secondary"
                                        v-model="clientPhone"
                                        :disabled="newClientToggle == false"
                                        :rules="clientPhoneRules"
                                        validate-on-blur
                                        type="tel"
                                        maxlength="10"
                                        minlength="10"
                                        filled
                                        rounded
                                        dense
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" class="py-0">
                                    <v-text-field
                                        label="Nombre *"
                                        color="secondary"
                                        v-model="clientName"
                                        :disabled="newClientToggle == false"
                                        :rules="clientNameRules"
                                        validate-on-blur
                                        maxlength="50"
                                        filled
                                        rounded
                                        dense
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-col>
                </v-row>
                <v-divider></v-divider>
                <v-row>
                    <v-col cols="12" class="pb-0">
                        <div class="text-subtitle-1 text--secondary">Información de pago</div>
                    </v-col>
                    <v-col cols="6">
                        <v-row>
                            <v-col cols="12">
                                <div class="text-caption pb-1">Forma de pago</div>
                                <v-select
                                    :items="paymentForms"
                                    item-text="name"
                                    item-value="value"
                                    v-model="paymentForm"
                                    dense
                                    solo
                                ></v-select>
                                <v-switch
                                    v-model="invoicedSaleToggle"
                                    dense
                                    inset
                                    class="pt-0 mt-3"
                                    label="Venta facturada"
                                    color="secondary"
                                ></v-switch>
                                <v-switch
                                    v-model="printSaleToggle"
                                    dense
                                    inset
                                    class="pt-0 mt-3"
                                    label="Imprimir ticket"
                                    color="secondary"
                                ></v-switch>
                            </v-col>
                        </v-row>
                    </v-col>
                    <v-col cols="6">
                        <v-card color="secondary">
                            <v-card-text>
                                <v-row class="white--text" align="center">
                                    <v-col cols="6">
                                        <div class="text-subtitle-2">Subtotal:</div>
                                    </v-col>
                                    <v-col cols="6" align="right">
                                        <div class="text-body-2">${{ getFormatedNumber(saleSubtotalAmount) }}</div>
                                    </v-col>
                                    <v-col cols="6">
                                        <div class="text-subtitle-2">IVA:</div>
                                    </v-col>
                                    <v-col cols="6" align="right">
                                        <div class="text-body-2">${{ getFormatedNumber(saleVatAmount) }}</div>
                                    </v-col>
                                    <v-col cols="6">
                                        <div class="text-subtitle-2">Comisión:</div>
                                    </v-col>
                                    <v-col cols="6" align="right">
                                        <div class="text-body-2">${{ getFormatedNumber(saleCreditCardCharge) }}</div>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                            <v-card-title class="white--text justify-center">
                                Total: ${{ getFormatedNumber(saleTotalAmount) }}
                            </v-card-title>
                        </v-card>
                    </v-col>
                    <v-col cols="6" offset-md="6">
                        <v-btn block color="secondary" v-on:click="processSale" v-bind:disabled="!validSaleForm"
                            >Realizar venta</v-btn
                        >
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-col>
</template>
<script>
    import { mapGetters, mapMutations, mapActions } from 'vuex'
    export default {
        data() {
            return {
                validClientName: false,
                invalidClientName: false,
                validClientPhone: false,
                invalidClientPhone: false,
                validClientEmail: false,
                invalidClientEmail: false,
                newClientToggle: false,
                saleClientForm: false,
                printSaleToggle: true,

                paymentForms: [
                    { name: 'Efectivo', value: 1 },
                    { name: 'Tarjeta', value: 2 },
                    { name: 'Transferencia', value: 3 },
                ],

                clientNameRules: [v => !!v || 'Este campo es requerido.'],
                clientPhoneRules: [
                    v => {
                        if (!v || v.length == 0 || v.length == 10) return true
                        return 'Por favor, ingrese el número telefónico a 10 dígitos.'
                    },
                ],
                clientEmailRules: [],
            }
        },

        computed: {
            ...mapGetters('sales', {
                currentSaleId: 'getCurrentSaleId',
                saleClientId: 'getSaleClientId',
                saleClientName: 'getSaleClientName',
                saleClientPhone: 'getSaleClientPhone',
                saleClientEmail: 'getSaleClientEmail',
                salePaymentForm: 'getSalePaymentForm',
                saleSubtotalAmount: 'getSaleSubtotalAmount',
                saleVatAmount: 'getSaleVatAmount',
                isInvoicedSale: 'getIsInvoicedSale',
                saleCreditCardCharge: 'getSaleCreditCardCharge',
                saleTotalAmount: 'getSaleTotalAmount',
                cart: 'getCart',
            }),

            ...mapGetters('clients', {
                clients: 'getClients',
                clientId: 'getNewClientId',
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
                    return this.saleClientName
                },
                set(value) {
                    this.SET_SALE_CLIENT_NAME(value)
                },
            },

            clientPhone: {
                get() {
                    return this.saleClientPhone
                },
                set(value) {
                    this.SET_SALE_CLIENT_PHONE(value)
                },
            },

            clientEmail: {
                get() {
                    return this.saleClientEmail
                },
                set(value) {
                    this.SET_SALE_CLIENT_EMAIL(value)
                },
            },

            paymentForm: {
                get() {
                    return this.salePaymentForm
                },
                set(value) {
                    this.SET_SALE_PAYMENT_FORM(value)
                },
            },

            invoicedSaleToggle: {
                get() {
                    return this.isInvoicedSale
                },
                set(value) {
                    this.SET_INVOICED_SALE(value)
                },
            },

            validSaleForm: function() {
                if (
                    this.cart.length > 0 &&
                    this.clientName != '' &&
                    this.clientPhone.length == 10 &&
                    this.validateUnitPrices == 0
                ) {
                    return true
                } else {
                    return false
                }
            },

            validateUnitPrices: function() {
                var amount_zero_prices = 0
                this.cart.forEach(article => {
                    if (article.articleUnitPrice == 0) {
                        amount_zero_prices = amount_zero_prices + 1
                    }
                })
                return amount_zero_prices
            },
        },

        methods: {
            ...mapActions('clients', ['fetchClients', 'fetchLastClientId']),
            ...mapActions('sales', ['fetchLastSaleId']),

            ...mapMutations('sales', [
                'SET_SALE_CLIENT_ID',
                'SET_SALE_CLIENT_NAME',
                'SET_SALE_CLIENT_PHONE',
                'SET_SALE_CLIENT_EMAIL',
                'SET_SALE_PAYMENT_FORM',
                'SET_INVOICED_SALE',
            ]),

            ...mapActions('sales', ['saveSale', 'saveSaleDetail', 'printSale']),
            ...mapActions('clients', ['saveClient']),

            newClientToggleHandler: function() {
                this.SET_SALE_CLIENT_ID(this.clientId)
                this.SET_SALE_CLIENT_NAME('')
                this.SET_SALE_CLIENT_PHONE('')
                this.SET_SALE_CLIENT_EMAIL('')

                this.validClientName = false
                this.invalidClientName = false
                this.validClientPhone = false
                this.invalidClientPhone = false
                this.validClientEmail = false
                this.invalidClientEmail = false
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

            getFormatedNumber: function(number) {
                var int_amount = parseInt(number)
                var decimal_amount = (number % 1).toFixed(2).slice(1)
                return int_amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + decimal_amount
            },

            processSale: async function() {
                if (this.newClientToggle) {
                    await this.saveClient({
                        client_name: this.clientName,
                        client_email: this.clientEmail,
                        client_phone: this.clientPhone,
                    })
                    await this.fetchClients()
                    await this.fetchLastClientId()
                }

                await this.saveSale()
                await this.saveSaleDetail()
                await this.printSale(this.printSaleToggle)

                this.validClientName = false
                this.invalidClientName = false
                this.validClientPhone = false
                this.invalidClientPhone = false
                this.validClientEmail = false
                this.invalidClientEmail = false
                this.newClientToggle = false
            },
        },
    }
</script>
