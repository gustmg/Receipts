<template>
    <div class="row" style="margin-bottom: 0px">
        <div class="col s12" align="center">
            <div class="row">
                <div class="col s12">
                    <h5>Hola</h5>
                    <button v-on:click="downloadReport()">Descargar</button>
                </div>
            </div>
            <table class="centered highlight">
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Forma de pago</th>
                        <th>Monto total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="sale in sales" v-bind:key="sale.sale_id">
                        <td>{{ sale.sale_id }}</td>
                        <td>{{ formatDate(sale.created_at) }}</td>
                        <td>{{ sale.client.client_name }}</td>
                        <td>{{ sale.payment_form.payment_form_name }}</td>
                        <td>${{ sale.sale_total_amount }}</td>
                        <td>
                            <a class="modal-trigger" href="#sale-detail-modal" v-on:click="setSaleDetailData(sale)"
                                ><i class="material-icons">open_in_new</i></a
                            >
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="sale-detail-modal" class="modal">
            <div class="modal-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col s1" align="center">
                            Folio<br />
                            <b>{{ sale_detail_id }}</b>
                        </div>
                        <div class="col m3" align="center">
                            Fecha<br />
                            <b>{{ formatDate(sale_detail_date) }}</b>
                        </div>
                        <div class="col m3" align="center">
                            Cliente<br />
                            <b>{{ sale_detail_client_name }}</b>
                        </div>
                        <div class="col m3" align="center">
                            Forma de pago<br />
                            <b>{{ sale_detail_payment_form }}</b>
                        </div>
                        <div class="col m2" align="center">
                            Venta facturada<br />
                            <i v-if="sale_detail_invoiced" class="material-icons green-icon">check_circle</i>
                            <i v-else class="material-icons red-icon">cancel</i>
                        </div>
                        <div class="col m12">
                            <table class="card centered">
                                <thead>
                                    <tr>
                                        <th>Cantidad</th>
                                        <th>Descripción</th>
                                        <th>Precio unitario</th>
                                        <th>Importe</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="service in sale_detail_services" v-bind:key="service.service_id">
                                        <td>{{ service.pivot.service_quantity }}</td>
                                        <td>{{ service.service_name }}</td>
                                        <td>${{ service.pivot.service_unit_price }}</td>
                                        <td class="right-align">
                                            ${{
                                                (
                                                    service.pivot.service_quantity * service.pivot.service_unit_price
                                                ).toFixed(2)
                                            }}
                                        </td>
                                    </tr>
                                    <tr v-for="product in sale_detail_products" v-bind:key="product.product_id">
                                        <td>{{ product.pivot.product_quantity }}</td>
                                        <td>{{ product.product_name }}</td>
                                        <td>${{ product.pivot.product_unit_price }}</td>
                                        <td class="right-align">
                                            ${{
                                                (
                                                    product.pivot.product_quantity * product.pivot.product_unit_price
                                                ).toFixed(2)
                                            }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="container-fluid">
                                <div class="row no-margin">
                                    <div class="col m2 offset-m8" align="right">
                                        <span>Subtotal</span><br />
                                        <span>Iva</span><br />
                                        <span>Comisión tarjeta</span><br />
                                        <span>Total</span><br />
                                    </div>
                                    <div class="col m2" align="right">
                                        <span class="padding-r-20"
                                            ><b>${{ sale_detail_subtotal }}</b></span
                                        ><br />
                                        <span class="padding-r-20"
                                            ><b>${{ sale_detail_vat }}</b></span
                                        ><br />
                                        <span class="padding-r-20"
                                            ><b>${{ sale_detail_credit_card_comision }}</b></span
                                        ><br />
                                        <span class="padding-r-20"
                                            ><b>${{ sale_detail_total }}</b></span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="modal-close waves-effect waves-green btn-flat">Agree</button>
            </div>
        </div>
    </div>
</template>
<style>
    #sale-detail-modal {
        width: 1094px;
    }
    .green-icon {
        color: green;
    }
    .red-icon {
        color: red;
    }
    .right-align {
        text-align: right !important;
        padding-right: 24px;
    }
    .padding-r-24 {
        padding-right: 24px;
    }
    .padding-r-20 {
        padding-right: 20px;
    }
    .no-margin {
        margin: 0;
    }
</style>
<script>
    export default {
        mounted: function () {
            console.log(this.sales)
        },

        props: {
            sales: {
                type: Array,
            },
        },

        methods: {
            formatDate: function (date) {
                var newDate = new Date(date)
                return (
                    newDate.getDate() +
                    '/' +
                    (newDate.getMonth() + 1) +
                    '/' +
                    newDate.getFullYear() +
                    ' a las ' +
                    newDate.getHours() +
                    ':' +
                    newDate.getMinutes() +
                    ' Hrs'
                )
            },

            downloadReport: function () {
                axios
                    .get('http://localhost:8000/sales/export/')
                    .then((res) => {
                        // console.log(res);
                    })
                    .catch(function (err) {
                        console.log(err)
                    })
            },

            setSaleDetailData: function (sale) {
                this.sale_detail_id = sale.sale_id
                this.sale_detail_date = sale.created_at
                this.sale_detail_client_name = sale.client.client_name
                this.sale_detail_payment_form = sale.payment_form.payment_form_name
                this.sale_detail_payment_form_id = sale.payment_form.payment_form_id
                this.sale_detail_invoiced = sale.sale_invoiced
                this.sale_detail_services = sale.services
                this.sale_detail_products = sale.products
                this.sale_detail_total = sale.sale_total_amount
            },
        },

        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                sale_detail_id: '',
                sale_detail_date: '',
                sale_detail_client_name: '',
                sale_detail_payment_form: '',
                sale_detail_payment_form_id: 0,
                sale_detail_invoiced: 0,
                sale_detail_services: [],
                sale_detail_products: [],
                sale_detail_total: 0,
            }
        },

        computed: {
            sale_detail_subtotal: function () {
                var subtotal = this.sale_detail_total - this.sale_detail_vat - this.sale_detail_credit_card_comision
                return subtotal.toFixed(2)
            },

            sale_detail_vat: function () {
                var vat = 0
                if (this.sale_detail_invoiced) {
                    if (this.sale_detail_payment_form_id == 2 && this.sale_detail_total > 999) {
                        vat =
                            this.sale_detail_total -
                            this.sale_detail_credit_card_comision -
                            (this.sale_detail_total - this.sale_detail_credit_card_comision) / 1.16
                    } else {
                        vat = this.sale_detail_total - this.sale_detail_total / 1.16
                    }
                }
                return vat.toFixed(2)
            },

            sale_detail_credit_card_comision: function () {
                var credit_card_comision = 0
                if (this.sale_detail_payment_form_id == 2 && this.sale_detail_total > 999) {
                    credit_card_comision = this.sale_detail_total - this.sale_detail_total / 1.035
                }
                return credit_card_comision.toFixed(2)
            },
        },
    }
</script>
