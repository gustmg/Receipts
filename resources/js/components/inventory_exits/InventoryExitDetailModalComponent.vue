<template>
    <v-dialog v-model="inventoryExitDetailModal">
        <template v-slot:activator="{ on, attrs }">
            <v-btn color="secondary" block v-bind="attrs" v-on="on">
                Ver detalles
            </v-btn>
        </template>
        <v-card>
            <v-container>
                <v-row>
                    <v-col cols="12" algin="center">
                        <v-row>
                            <v-col cols="3">
                                <div class="text-subtitle-2">Fecha de salida</div>
                                <div class="body-1">{{ inventoryExit.inventory_exit_created_at }}</div>
                            </v-col>
                            <v-col cols="3">
                                <div class="text-subtitle-2">Almacén origen</div>
                                <div class="body-1">{{ inventoryExit.warehouse.warehouse_name }}</div>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" align="center">
                        <v-data-table
                            :headers="exitProductsTableHeaders"
                            :items="inventoryExit.products"
                            item-key="product_id"
                            hide-default-footer
                            calculate-widths
                        >
                        </v-data-table>
                    </v-col>
                </v-row>
                <v-row>
                    <v-spacer></v-spacer>
                    <v-col cols="2">
                        <v-btn color="secondary" block v-on:click="inventoryExitDetailModal = false">Cerrar</v-btn>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
    </v-dialog>
</template>
<script>
    import { mapState, mapMutations, mapActions } from 'vuex'
    import { parseCurrency } from 'vue-currency-input'
    export default {
        data() {
            return {
                inventoryExitDetailModal: false,
                exitProductsTableHeaders: [
                    { text: 'Código', value: 'product_code', width: '10%' },
                    { text: 'Producto', value: 'product_name', width: '15%' },
                    { text: 'Descripción', value: 'product_description', width: '20%' },
                    { text: 'Cantidad', value: 'pivot.product_exit_amount', width: '15%' },
                    { text: 'Justificación', value: 'pivot.product_exit_justification', width: '15%' },
                ],
            }
        },

        props: {
            inventoryExit: {
                type: Object,
            },
        },

        computed: {
            ...mapState(['current_username', 'products_to_exit', 'products', 'products_exit_detail']),

            totalCost: function() {
                var total = 0
                this.products_exit_detail.forEach(product => {
                    var product_import = this.getImport(product.product_amount, product.product_unit_cost)
                    total = total + product_import
                })
                return total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
            },

            validateForm: function() {
                if (this.products_exit_detail.length > 0) {
                    var empty_inputs_counter = 0
                    this.products_exit_detail.forEach(product => {
                        if (
                            !product.product_amount ||
                            product.product_amount == '' ||
                            !product.product_unit_cost ||
                            product.product_unit_cost == '' ||
                            parseFloat(product.product_amount) == 0 ||
                            parseFloat(product.product_unit_cost.replace(/[^\d.]/g, '')) == 0
                        ) {
                            empty_inputs_counter++
                        }
                    })

                    if (empty_inputs_counter == 0) {
                        return false
                    } else {
                        return true
                    }
                } else {
                    return true
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
        },

        methods: {
            ...mapActions([
                'addProduct',
                'closeModal',
                'openModal',
                'updateProductAmount',
                'updateProductUnitCost',
                'addInventoryExit',
            ]),
            saveInventoryExit: function() {
                this.addInventoryExit(this.totalCost)
                this.closeModal()
            },

            openProductsListDialog: function() {
                this.openModal($('#productsListWithStocksModal'))
            },

            updateAmount: function(product_index, newValue) {
                this.updateProductAmount({ product_index, newValue })
            },

            updateUnitCost: function(product_index, new_unit_cost) {
                this.updateProductUnitCost({ product_index, new_unit_cost })
            },

            getImport: function(amount, unit_cost) {
                if (amount && unit_cost) {
                    var parsed_amount = parseFloat(amount)
                    var parsed_unit_cost = unit_cost.replace(/[^\d.]/g, '')
                    return parsed_amount * parsed_unit_cost
                } else {
                    return 0
                }
            },

            getProductsAmount: function(product_entries) {
                var total_products_amount = 0
                product_entries.forEach(product_exit => {
                    total_products_amount += product_exit.pivot.product_exit_amount
                })
                return total_products_amount
            },
        },
    }
</script>
