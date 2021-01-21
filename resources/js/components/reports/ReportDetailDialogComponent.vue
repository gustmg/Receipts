<template>
    <v-dialog v-model="reportDetailDialog">
        <template v-slot:activator="{ on, attrs }">
            <v-btn icon v-on="on" v-bind="attrs"><v-icon>mdi-card-text</v-icon></v-btn>
        </template>
        <v-card>
            <v-card-title>Detalle de venta #{{ sale.sale_id }}</v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="2">
                            <div class="text-caption">Fecha</div>
                            <div class="text-subtitle-1">{{ sale.created_at }}</div>
                        </v-col>
                        <v-col cols="2">
                            <div class="text-caption">Cliente</div>
                            <div class="text-subtitle-1">{{ sale.client.client_name }}</div>
                        </v-col>
                        <v-col cols="2">
                            <div class="text-caption">Forma de pago</div>
                            <div class="text-subtitle-1">{{ sale.payment_form.payment_form_name }}</div>
                        </v-col>
                        <v-col cols="2">
                            <div class="text-caption">Venta facturada</div>
                            <v-icon v-if="sale.sale_invoiced" color="success">mdi-check-circle</v-icon>
                            <v-icon v-else color="error">mdi-cancel</v-icon>
                        </v-col>
                        <v-col cols="12">
                            <div class="text-caption" v-if="sale.services.length > 0">Servicios</div>
                            <v-data-table
                                :headers="saleServicesTableHeaders"
                                :items="sale.services"
                                hide-default-footer
                                calculate-widths
                                v-if="sale.services.length > 0"
                            >
                                <template v-slot:item.service_vat="{ item }">
                                    <div class="text-body-1">
                                        {{ getServiceVatAmount(item) }}
                                    </div>
                                </template>
                                <template v-slot:item.service_comision="{ item }">
                                    <div class="text-body-1">
                                        {{ getServiceComision(item) }}
                                    </div>
                                </template>
                                <template v-slot:item.service_import="{ item }">
                                    <div class="text-body-1" v-if="sale.sale_invoiced">
                                        {{
                                            (
                                                +item.pivot.service_unit_price +
                                                +getServiceVatAmount(item) +
                                                +getServiceComision(item)
                                            ).toFixed(2)
                                        }}
                                    </div>
                                </template>
                            </v-data-table>
                            <div class="text-caption" v-if="sale.products.length > 0">Productos</div>
                            <v-data-table
                                :headers="saleProductsTableHeaders"
                                :items="sale.products"
                                hide-default-footer
                                calculate-widths
                                v-if="sale.products.length > 0"
                            >
                                <template v-slot:item.product_vat="{ item }">
                                    <div class="text-body-1">
                                        {{ getProductVatAmount(item) }}
                                    </div>
                                </template>
                                <template v-slot:item.product_comision="{ item }">
                                    <div class="text-body-1">
                                        {{ getProductComision(item) }}
                                    </div>
                                </template>
                                <template v-slot:item.product_import="{ item }">
                                    <div class="text-body-1" v-if="sale.sale_invoiced">
                                        {{
                                            (
                                                +item.pivot.product_unit_price +
                                                +getProductVatAmount(item) +
                                                +getProductComision(item)
                                            ).toFixed(2)
                                        }}
                                    </div>
                                </template>
                            </v-data-table>
                        </v-col>
                        <v-col cols="3" offset-md="9">
                            <v-card color="secondary">
                                <v-card-text>
                                    <v-row class="white--text" align="center">
                                        <v-col cols="6">
                                            <div class="text-subtitle-2">Subtotal:</div>
                                        </v-col>
                                        <v-col cols="6" align="right">
                                            <div class="text-body-2">${{ saleSubtotalAmount }}</div>
                                        </v-col>
                                        <v-col cols="6">
                                            <div class="text-subtitle-2">IVA:</div>
                                        </v-col>
                                        <v-col cols="6" align="right">
                                            <div class="text-body-2">${{ saleVatAmount }}</div>
                                        </v-col>
                                        <v-col cols="6">
                                            <div class="text-subtitle-2">Comisión:</div>
                                        </v-col>
                                        <v-col cols="6" align="right">
                                            <div class="text-body-2">${{ saleCreditCardCharge }}</div>
                                        </v-col>
                                    </v-row>
                                </v-card-text>
                                <v-card-title class="white--text justify-center">
                                    Total: ${{ sale.sale_total_amount }}
                                </v-card-title>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>
<script>
    export default {
        props: {
            sale: {
                type: Object,
            },
        },

        data() {
            return {
                reportDetailDialog: false,
                saleServicesTableHeaders: [
                    { text: 'Cantidad', value: 'pivot.service_quantity', width: '10%' },
                    { text: 'Descripción', value: 'service_name', width: '15%' },
                    { text: 'Costo unitario', value: 'pivot.service_unit_price', width: '15%' },
                    { text: 'IVA', value: 'service_vat', width: '15%' },
                    { text: 'Comisión tarjeta', value: 'service_comision', width: '15%' },
                    { text: 'Importe total', value: 'service_import', width: '15%' },
                ],
                saleProductsTableHeaders: [
                    { text: 'Cantidad', value: 'pivot.product_quantity', width: '10%' },
                    { text: 'Descripción', value: 'product_name', width: '15%' },
                    { text: 'Costo unitario', value: 'pivot.product_unit_price', width: '15%' },
                    { text: 'IVA', value: 'product_vat', width: '15%' },
                    { text: 'Comisión tarjeta', value: 'product_comision', width: '15%' },
                    { text: 'Importe total', value: 'product_import', width: '15%' },
                ],
            }
        },

        computed: {
            saleSubtotalAmount: function() {
                const service_reducer = (accumulator, currentValue) => {
                    return accumulator + +currentValue.pivot.service_unit_price * currentValue.pivot.service_quantity
                }

                const product_reducer = (accumulator, currentValue) => {
                    return accumulator + +currentValue.pivot.product_unit_price * currentValue.pivot.product_quantity
                }

                var subtotal =
                    this.sale.services.reduce(service_reducer, 0) + this.sale.products.reduce(product_reducer, 0)
                return subtotal.toFixed(2)
            },

            saleVatAmount: function() {
                var saleVatAmount = 0
                if (this.sale.sale_invoiced) {
                    return (this.saleSubtotalAmount * 0.16).toFixed(2)
                } else return saleVatAmount.toFixed(2)
            },

            saleCreditCardCharge: function() {
                var saleCreditCardCharge = 0
                if (this.sale.sale_payment_form_id == 2) {
                    return ((+this.saleSubtotalAmount + +this.saleVatAmount) * 0.035).toFixed(2)
                } else return saleCreditCardCharge.toFixed(2)
            },
        },

        methods: {
            getServiceVatAmount: function(service) {
                var vatAmount = 0
                if (this.sale.sale_invoiced) {
                    vatAmount = service.pivot.service_unit_price * 0.16
                }

                return vatAmount.toFixed(2)
            },

            getServiceComision: function(service) {
                var comisionAmount = 0

                if (this.sale.sale_payment_form_id == 2) {
                    if (this.sale.sale_invoiced) {
                        comisionAmount = service.pivot.service_unit_price * 1.16 * 0.035
                    } else {
                        comisionAmount = service.pivot.servie_unit_price * 0.035
                    }
                }

                return comisionAmount.toFixed(2)
            },

            getProductVatAmount: function(product) {
                var vatAmount = 0
                if (this.sale.sale_invoiced) {
                    vatAmount = product.pivot.product_unit_price * 0.16
                }

                return vatAmount.toFixed(2)
            },

            getProductComision: function(product) {
                var comisionAmount = 0

                if (this.sale.sale_payment_form_id == 2) {
                    if (this.sale.sale_invoiced) {
                        comisionAmount = product.pivot.product_unit_price * 1.16 * 0.035
                    } else {
                        comisionAmount = product.pivot.product_unit_price * 0.035
                    }
                }

                return comisionAmount.toFixed(2)
            },
        },
    }
</script>

<style></style>
