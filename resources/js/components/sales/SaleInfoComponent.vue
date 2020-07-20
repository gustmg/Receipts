<template>
    <div class="col m4" style="padding-left:24px !important;padding-top:8px !important;">
        <div class="row">
            <div class="col m12">
                <span class="grey-text"><b>Información de venta</b></span
                ><br />
                <span><b>Folio:</b> {{ currentSaleId }}</span
                ><br />
                <span><b>Fecha:</b> {{ date }}</span
                ><br />
                <div class="row" style="padding-top:12px !important;">
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
                                            v-model="saleClientId"
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
                    <div class="input-field col s12 m8" style="margin-top:0 !important;">
                        <select v-model="paymentForm" class="icons test">
                            <option value="1" data-icon="svg/baseline-attach_money-24px.svg">Efectivo</option>
                            <option value="2" data-icon="svg/baseline-payment-24px.svg"
                                >Tarjeta de crédito / débito</option
                            >
                        </select>
                        <label>Forma de pago</label>
                    </div>
                    <div class="col m8 switch">
                        <label>
                            Venta facturada
                            <input type="checkbox" v-model="invoicedSaleToggle" />
                            <span class="lever"></span>
                        </label>
                    </div>
                    <div class="col m7">
                        <br /><span
                            ><b>Subtotal: ${{ getFormatedNumber(saleSubtotalAmount) }}</b></span
                        >
                        <br /><span
                            ><b>IVA: ${{ getFormatedNumber(saleVatAmount) }}</b></span
                        >
                        <br v-show="paymentForm == '2'" /><span v-show="paymentForm == '2'"
                            ><b>Comisión tarjeta: ${{ getFormatedNumber(saleCreditCardCharge) }}</b></span
                        >
                        <br /><span
                            ><b>Total: ${{ getFormatedNumber(saleTotalAmount) }}</b></span
                        >
                    </div>
                    <div class="col m5 right-align">
                        <button
                            class="mdc-button mdc-button--outlined"
                            v-on:click="processSale"
                            v-bind:disabled="validateForm"
                        >
                            Realizar venta
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                newClientId: 'getNewClientId',
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

            validateForm: function() {
                if (this.newClientToggle) {
                    if (
                        this.cart.length == 0 ||
                        !this.validClientName ||
                        this.invalidClientPhone ||
                        this.invalidClientEmail
                    ) {
                        return true
                    } else if (this.cart.length > 0 && this.validateUnitPrices != 0) {
                        return true
                    }
                } else {
                    if (this.cart.length == 0 || this.clientName == '') {
                        return true
                    } else if (this.cart.length > 0 && this.validateUnitPrices != 0) {
                        return true
                    }
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
                this.SET_SALE_CLIENT_ID(this.newClientId)
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

            showClientsList: function() {
                $('#clientsCompactListModal').modal('open')
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
                await this.printSale()

                $('.test').formSelect()
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
