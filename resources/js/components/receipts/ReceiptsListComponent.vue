<template>
    <v-row>
        <v-col
            cols="12"
            v-show="receipts.length > 0"
            v-for="(receiptGroup, index) in groupedReceipts"
            v-bind:key="index"
        >
            <v-row>
                <v-col cols="12">
                    <h6 class="text-overline">{{ formatDate(receiptGroup[0].receipt_date) }}</h6>
                </v-col>
                <v-col cols="3" v-for="receipt in receiptGroup" v-bind:key="receipt.receipt_id">
                    <v-card>
                        <v-card-title>
                            <div class="text-h6">Recepción #{{ receipt.receipt_id }}</div>
                            <v-spacer></v-spacer>
                            <v-btn v-on:click="reprintReceipt(receipt.receipt_id)" icon class="primary--text">
                                <v-icon>mdi-printer</v-icon>
                            </v-btn>
                        </v-card-title>
                        <v-card-subtitle>
                            <div class="text-subtitle-1">
                                {{ receipt.client.client_name }}<br />
                                <v-icon small>mdi-phone</v-icon> {{ receipt.client.client_phone }}
                            </div>
                        </v-card-subtitle>
                        <v-card-text>
                            <div class="text-caption pb-2">Equipos ({{ receipt.devices.length }}):</div>
                            <devices-list-component :devices="receipt.devices"></devices-list-component>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-col>
    </v-row>
</template>
<script>
    import { mapGetters } from 'vuex'
    export default {
        data() {
            return {
                receiptIndex: null,
            }
        },

        methods: {
            reprintReceipt: function(receipt_id) {
                axios
                    .post('http://localhost:8000/print_receipt', {
                        receipt_id: receipt_id,
                        reprint: 1,
                    })
                    .then(res => {
                        // console.log(res.data.sale);
                        // location.reload();
                    })
                    .catch(function(err) {
                        // console.log(err.response);
                    })
            },

            formatDate: function(date) {
                var formated_date = new Date(date)
                var day = formated_date.getDay()
                var date = formated_date.getDate()
                var month = formated_date.getMonth()
                var year = formated_date.getFullYear()
                var month_name
                var day_name

                switch (month) {
                    case 0:
                        month_name = 'Enero'
                        break
                    case 1:
                        month_name = 'Febrero'
                        break
                    case 2:
                        month_name = 'Marzo'
                        break
                    case 3:
                        month_name = 'Abril'
                        break
                    case 4:
                        month_name = 'Mayo'
                        break
                    case 5:
                        month_name = 'Junio'
                        break
                    case 6:
                        month_name = 'Julio'
                        break
                    case 7:
                        month_name = 'Agosto'
                        break
                    case 8:
                        month_name = 'Septiembre'
                        break
                    case 9:
                        month_name = 'Octubre'
                        break
                    case 10:
                        month_name = 'Noviembre'
                        break
                    case 11:
                        month_name = 'Diciembre'
                        break
                }

                switch (day) {
                    case 0:
                        day_name = 'Domingo'
                        break
                    case 1:
                        day_name = 'Lunes'
                        break
                    case 2:
                        day_name = 'Martes'
                        break
                    case 3:
                        day_name = 'Miércoles'
                        break
                    case 4:
                        day_name = 'Jueves'
                        break
                    case 5:
                        day_name = 'Viernes'
                        break
                    case 6:
                        day_name = 'Sábado'
                        break
                }

                return day_name + ', ' + date + ' de ' + month_name + ' de ' + year
            },
        },

        computed: {
            ...mapGetters('receipts', {
                receipts: 'getReceipts',
                newReceiptId: 'getNewReceiptId',
                searchReceiptValue: 'getSearchReceiptValue',
            }),

            filteredReceipts: function() {
                return this.receipts.filter(receipt => {
                    return receipt.client.client_name.toLowerCase().indexOf(this.searchReceiptValue.toLowerCase()) >= 0
                })
            },

            groupedReceipts: function() {
                return _.groupBy(this.filteredReceipts, function(receipt) {
                    var date = new Date(receipt.created_at)
                    return date.getFullYear() + ' ' + (date.getMonth() + 1) + ' ' + date.getDate()
                })
            },
        },
    }
</script>
