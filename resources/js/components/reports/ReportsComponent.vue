<template>
    <v-container>
        <v-row>
            <v-col cols="2">
                <v-btn color="secondary" v-on:click="downloadReport()">Descargar reporte</v-btn>
            </v-col>
            <v-col cols="12">
                <v-card>
                    <v-card-text>
                        <v-data-table
                            :headers="salesTableHeaders"
                            :items="sales"
                            hide-default-footer
                            calculate-widths
                            disable-pagination
                            :sort-by.sync="sortBy"
                            :sort-desc.sync="sortDesc"
                        >
                            <template v-slot:item.sale_invoiced="{ item }">
                                <v-icon v-if="item.sale_invoiced" color="success">mdi-check-circle</v-icon>
                                <v-icon v-else color="error">mdi-cancel</v-icon>
                            </template>
                            <template v-slot:item.saleOptions="{ item }">
                                <v-btn icon><v-icon>mdi-download</v-icon></v-btn>
                                <report-detail-dialog-component :sale="item"></report-detail-dialog-component>
                            </template>
                        </v-data-table>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
    import { mapGetters, mapActions } from 'vuex'

    export default {
        mounted: function() {
            this.fetchSales()
        },

        methods: {
            ...mapActions('sales', ['fetchSales']),

            formatDate: function(date) {
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

            downloadReport: function() {
                window.open('http://localhost:8000/sales/export/', '_blank')
            },

            setSaleDetailData: function(sale) {
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
                sortBy: 'sale_id',
                sortDesc: true,

                salesTableHeaders: [
                    { text: 'Folio de venta', value: 'sale_id', width: '10%' },
                    { text: 'Fecha', value: 'created_at', width: '10%' },
                    { text: 'Cliente', value: 'client.client_name', width: '10%' },
                    { text: 'Forma de pago', value: 'payment_form.payment_form_name', width: '10%' },
                    { text: 'Venta facturada', value: 'sale_invoiced', width: '10%' },
                    { text: 'Total pagado', value: 'sale_total_amount', width: '10%' },
                    { text: 'Opciones', value: 'saleOptions', width: '10%' },
                ],
            }
        },

        computed: {
            ...mapGetters('sales', {
                sales: 'getSales',
            }),

            sale_detail_subtotal: function() {
                var subtotal = this.sale_detail_total - this.sale_detail_vat - this.sale_detail_credit_card_comision
                return subtotal.toFixed(2)
            },

            sale_detail_vat: function() {
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

            sale_detail_credit_card_comision: function() {
                var credit_card_comision = 0
                if (this.sale_detail_payment_form_id == 2 && this.sale_detail_total > 999) {
                    credit_card_comision = this.sale_detail_total - this.sale_detail_total / 1.025
                }
                return credit_card_comision.toFixed(2)
            },
        },
    }
</script>
