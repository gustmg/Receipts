<template>
    <div class="row">
        <div
            class="col s12"
            v-show="receipts.length > 0"
            v-for="(receiptGroup, index) in groupedReceipts"
            v-bind:key="index"
        >
            <div class="row">
                <h6 class="col s12 date-header">
                    <b>{{ formatDate(receiptGroup[0].receipt_date) }}</b>
                </h6>
                <div class="col m3" v-for="receipt in receiptGroup" v-bind:key="receipt.receipt_id">
                    <div class="card hoverable hoverable-card selectable receipt-card">
                        <div class="card-content">
                            <span
                                ><b>Recepción #{{ receipt.receipt_id }}</b></span
                            >
                            <span class="card-title">
                                <b v-if="receipt.client.client_name">{{ receipt.client.client_name }}</b>
                            </span>
                            <p>
                                <span v-if="receipt.client.client_phone"
                                    ><i class="material-icons inline-icon-small">phone</i>
                                    {{ receipt.client.client_phone }}</span
                                >
                                <span v-else class="grey-text">Teléfono no registrado</span>
                            </p>
                            <span><b>Equipos:</b></span>
                            <devices-list-component :devices="receipt.devices"></devices-list-component>
                            <span><b>Registrada por:</b> {{ receipt.user.name }}</span>
                            <a class="waves-effect waves-light btn blue" v-on:click="reprintReceipt(receipt.receipt_id)"
                                >Reimprimir ticket</a
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div>
			<h5 
				v-show="filteredReceipts.length == 0 && this.$parent.searchReceipt != '' " 
				class="center grey-text">
				Búsqueda sin resultados.
			</h5>
			<h5 v-show="receipts.length == 0 && this.$parent.searchReceipt == ''" class="center grey-text">No hay receiptes registrados.</h5>
		</div> -->
        <!-- <update-receipt-modal-component :receipt-id="receiptId.toString()" :receipt-name="receiptName" :receipt-phone="receiptPhone" :receipt-email="receiptEmail"></update-receipt-modal-component> -->
    </div>
</template>
<style>
    .date-header {
        padding-bottom: 12px !important;
        border-bottom: 2px solid #1565c0;
    }
    .inline-icon-large {
        vertical-align: bottom;
        font-size: 48px !important;
    }
    .inline-icon-small {
        vertical-align: bottom;
        font-size: 20px !important;
    }
    .inline-icon-medium {
        vertical-align: bottom;
        font-size: 32px !important;
    }
    .device-desc {
        margin-left: 24px !important;
    }
    .hoverable-card:hover {
        background-color: #eeeeee;
        transition: 0.1s;
    }
    .selectable {
        cursor: pointer;
    }
    .receipt-card {
        height: 500px !important;
        border: 1px solid #cfd8dc;
    }
</style>
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
