<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <div class="text-h6 font-weight-bold">Hoy</div>
            </v-col>
            <v-col cols="12" md="4" xl="3">
                <v-card>
                    <v-card-title class="justify-center">Ventas por tipo</v-card-title>
                    <v-card-text>
                        <apexchart
                            width="100%"
                            type="donut"
                            :options="options3"
                            :series="salesByTypeSeries"
                        ></apexchart>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" md="4" xl="6">
                <v-card height="100%">
                    <v-card-title class="font-weight-bold justify-center">Bitácora de movimientos del día</v-card-title>
                    <v-card-text>
                        <apexchart
                            height="150%"
                            type="bar"
                            ref="chart"
                            :options="options"
                            :series="todayMovementsSeries"
                        ></apexchart>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" md="4" xl="3">
                <v-card height="100%">
                    <v-card-title class="justify-center">Ventas por forma de pago</v-card-title>
                    <v-card-text>
                        <apexchart
                            width="100%"
                            type="donut"
                            :options="salesByPaymentFormOptions"
                            :series="salesByPaymentFormSeries"
                        ></apexchart>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" md="4" xl="3">
                <v-row>
                    <v-col cols="12">
                        <div class="text-subtitle-2">Operaciones realizadas</div>
                    </v-col>
                    <v-col cols="6">
                        <v-card color="secondary lighten-2">
                            <v-card-title class="justify-center font-weight-bold primary--text">
                                {{ todayReceipts.length }}
                            </v-card-title>
                            <v-card-text align="center" class="primary--text"> Recepciones </v-card-text>
                        </v-card>
                    </v-col>
                    <v-col cols="6">
                        <v-card color="secondary lighten-2">
                            <v-card-title class="justify-center font-weight-bold primary--text">
                                {{ sales.length }}
                            </v-card-title>
                            <v-card-text align="center" class="primary--text"> Ventas </v-card-text>
                        </v-card>
                    </v-col>
                    <v-col cols="6">
                        <v-card color="secondary lighten-2">
                            <v-card-title class="justify-center font-weight-bold primary--text">
                                {{ inventoryEntries.length }}
                            </v-card-title>
                            <v-card-text align="center" class="primary--text"> Entradas de inventario </v-card-text>
                        </v-card>
                    </v-col>
                    <v-col cols="6">
                        <v-card color="secondary lighten-2">
                            <v-card-title class="justify-center font-weight-bold primary--text">
                                {{ inventoryExits.length }}
                            </v-card-title>
                            <v-card-text align="center" class="primary--text"> Salidas de inventario </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12" md="4" xl="3">
                <v-card>
                    <v-card-title class="justify-center">Status general de equipos</v-card-title>
                    <v-card-text>
                        <apexchart
                            width="100%"
                            type="donut"
                            ref="deviceStatusChart"
                            :options="deviceStatusChartOptions"
                            :series="deviceStatusChartSeries"
                        ></apexchart>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" md="4" xl="6">
                <v-card height="100%">
                    <v-card-title>Equipos pendientes de entrega</v-card-title>
                    <v-card-text>
                        <v-list three-line outlined v-for="device in pendingDevices" :key="device.device_id">
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-subtitle
                                        >Recepcion #{{ device.device_receipt_id }}</v-list-item-subtitle
                                    >
                                    <v-list-item-title>{{ device.device_name }}</v-list-item-title>
                                    <v-list-item-subtitle>{{ device.device_trouble_description }}</v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12">
                <v-btn class="accent secondary--text" v-on:click="createBackup()"
                    >Respaldar DB <v-icon size="24">mdi-database</v-icon></v-btn
                >
                <v-snackbar v-model="backupSnackbar">
                    {{ backupMessage }}
                </v-snackbar>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
    import { mapGetters, mapActions } from 'vuex'
    import moment from 'moment'

    export default {
        async mounted() {
            await this.fetchTodaySales()
            await this.fetchTodayReceipts()
            await this.fetchTodayInventoryEntries()
            await this.fetchTodayInventoryExits()
            await this.fetchReceipts()
            await this.fetchDevices()
            this.setSalesByPaymentFormSeries()
            this.setSalesByTypeSeries()
            this.$refs.chart.updateSeries([
                { data: this.setTodayMovementsReceiptsSeries() },
                { data: this.setTodayMovementsSalesSeries() },
            ])
            this.$refs.deviceStatusChart.updateSeries([
                this.setDeviceSeriesByServiceStatus(1),
                this.setDeviceSeriesByServiceStatus(2),
                this.setDeviceSeriesByServiceStatus(3),
                this.setDeviceSeriesByServiceStatus(4),
                this.setDeviceSeriesByServiceStatus(5),
                this.setDeviceSeriesByServiceStatus(6),
            ])
        },

        data() {
            return {
                backupSnackbar: false,
                backupMessage: '',
                options: {
                    chart: {
                        id: 'Bitácora del día',
                    },
                    xaxis: {
                        categories: ['10am', '11am', '12pm', '1pm', '2pm', '3pm', '4pm', '5pm', '6pm', '7pm', '8pm'],
                    },
                    theme: {
                        mode: 'light',

                        monochrome: {
                            enabled: true,
                            color: '#00003c',
                            shadeTo: 'light',
                            shadeIntensity: 0.65,
                        },
                    },
                },

                todayMovementsSeries: [
                    {
                        name: 'Recepciones',
                        data: [],
                    },
                    {
                        name: 'Ventas',
                        data: [],
                    },
                ],

                options3: {
                    chart: {
                        type: 'donut',
                    },
                    labels: ['Productos', 'Servicios'],
                    stroke: {
                        lineCap: 'round',
                    },

                    theme: {
                        mode: 'light',

                        monochrome: {
                            enabled: true,
                            color: '#00003c',
                            shadeTo: 'light',
                            shadeIntensity: 0.65,
                        },
                    },
                },

                salesByTypeSeries: [0, 0],

                salesByPaymentFormOptions: {
                    chart: {
                        type: 'donut',
                    },
                    labels: ['Efectivo', 'Tarjeta crédito/débito', 'Transferencia'],
                    stroke: {
                        lineCap: 'round',
                    },

                    theme: {
                        mode: 'light',

                        monochrome: {
                            enabled: true,
                            color: '#00003c',
                            shadeTo: 'light',
                            shadeIntensity: 0.65,
                        },
                    },
                },

                salesByPaymentFormSeries: [0, 0, 0],

                deviceStatusChartOptions: {
                    chart: {
                        type: 'donut',
                    },
                    labels: [
                        'Sin diagnosticar',
                        'En diagnóstico',
                        'Diagnosticados',
                        'En reparación',
                        'En almacén',
                        'Entregados',
                    ],
                    stroke: {
                        lineCap: 'round',
                    },

                    colors: ['#CFD8DC', '#FFD600', '#0091EA', '#FF6E40', '#EF5350', '#00E676'],
                },

                deviceStatusChartSeries: [0, 0, 0, 0, 0, 0],
            }
        },

        computed: {
            ...mapGetters('sales', {
                sales: 'getTodaySales',
            }),

            ...mapGetters('devices', {
                devices: 'getDevices',
            }),

            ...mapGetters('receipts', {
                todayReceipts: 'getTodayReceipts',
                receipts: 'getReceipts',
            }),

            ...mapGetters('inventoryEntries', {
                inventoryEntries: 'getTodayInventoryEntries',
            }),

            ...mapGetters('inventoryExits', {
                inventoryExits: 'getTodayInventoryExits',
            }),

            pendingDevices: function() {
                return this.devices.filter(device => {
                    return device.service_status[device.service_status.length - 1].service_status_id == 5
                })
            },
        },

        methods: {
            ...mapActions('sales', ['fetchTodaySales']),

            ...mapActions('devices', ['fetchDevices']),

            ...mapActions('receipts', ['fetchReceipts', 'fetchTodayReceipts']),

            ...mapActions('inventoryEntries', ['fetchTodayInventoryEntries']),

            ...mapActions('inventoryExits', ['fetchTodayInventoryExits']),

            createBackup: function() {
                axios
                    .post('createBackup')
                    .then(response => {
                        if (response.data == 1) {
                            this.backupMessage = 'La base de datos fue respaldada con éxito.'
                            this.backupSnackbar = true
                        }
                    })
                    .catch(error => console.log(error))
            },

            setSalesByPaymentFormSeries: function() {
                var salesByPaymentFormSeries = []

                salesByPaymentFormSeries[0] = this.sales.filter(sale => {
                    return sale.sale_payment_form_id == 1
                }).length

                salesByPaymentFormSeries[1] = this.sales.filter(sale => {
                    return sale.sale_payment_form_id == 2
                }).length

                salesByPaymentFormSeries[2] = this.sales.filter(sale => {
                    return sale.sale_payment_form_id == 3
                }).length

                this.salesByPaymentFormSeries = salesByPaymentFormSeries
            },

            setSalesByTypeSeries: function() {
                var salesByTypeSeries = []

                salesByTypeSeries[0] = this.sales.reduce(
                    function(accumulator, current) {
                        accumulator.amount += current.products.length
                        return accumulator
                    },
                    { amount: 0 }
                )

                salesByTypeSeries[1] = this.sales.reduce(
                    function(accumulator, current) {
                        accumulator.amount += current.services.length
                        return accumulator
                    },
                    { amount: 0 }
                )

                salesByTypeSeries[0] = salesByTypeSeries[0].amount
                salesByTypeSeries[1] = salesByTypeSeries[1].amount

                this.salesByTypeSeries = salesByTypeSeries
            },

            setTodayMovementsReceiptsSeries: function() {
                var receiptsSeries = []
                for (var x = 10; x < 20; x++) {
                    var receiptsByHour = this.todayReceipts.filter(receipt => {
                        return moment(receipt.created_at).hours() == x
                    })

                    receiptsSeries.push(receiptsByHour.length)
                }
                return receiptsSeries
            },

            setTodayMovementsSalesSeries: function() {
                var salesSeries = []
                for (var x = 10; x < 20; x++) {
                    var salesByHour = this.sales.filter(sale => {
                        return moment(sale.created_at).hours() == x
                    })

                    salesSeries.push(salesByHour.length)
                }
                return salesSeries
            },

            setDeviceSeriesByServiceStatus: function(service_status_id) {
                var devicesAmount = 0
                this.receipts.forEach(receipt => {
                    var devices = receipt.devices.filter(device => {
                        return (
                            device.service_status[device.service_status.length - 1].service_status_id ==
                            service_status_id
                        )
                    })

                    devicesAmount += devices.length
                })

                return devicesAmount
            },
        },
    }
</script>
