<template>
    <v-dialog v-model="inventoryEntryDetailModal">
        <template v-slot:activator="{ on, attrs }">
            <v-btn color="primary" block v-bind="attrs" v-on="on">
                Ver detalles
            </v-btn>
        </template>
        <v-card>
            <v-container>
                <v-row>
                    <v-col cols="12" algin="center">
                        <v-row>
                            <v-col cols="3">
                                <div class="text-subtitle-2">Fecha de entrada</div>
                                <div class="body-1">{{ inventoryEntry.inventory_entry_created_at }}</div>
                            </v-col>
                            <v-col cols="3">
                                <div class="text-subtitle-2">Almacén destino</div>
                                <div class="body-1">{{ inventoryEntry.warehouse.warehouse_name }}</div>
                            </v-col>
                            <v-col cols="3">
                                <div class="text-subtitle-2">Costo total</div>
                                <div class="body-1">${{ inventoryEntry.inventory_entry_total_cost }}</div>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" align="center">
                        <v-data-table
                            :headers="entryProductsTableHeaders"
                            :items="inventoryEntry.products"
                            item-key="product_id"
                            hide-default-footer
                            calculate-widths
                        >
                            <template v-slot:item.product_import="{ item }">
                                ${{ item.pivot.product_unit_cost * item.pivot.product_entry_amount }}
                            </template>
                        </v-data-table>
                    </v-col>
                </v-row>
                <v-row>
                    <v-spacer></v-spacer>
                    <v-col cols="2">
                        <v-btn color="primary" block v-on:click="inventoryEntryDetailModal = false">Cerrar</v-btn>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
    </v-dialog>
    <!-- <div id="inventoryEntryDetailModal" class="modal inventoryEntryDetailModal modal-fixed-footer">
        <div class="modal-content" v-if="this.inventoryEntryDetail">
            <div class="row">
                <div class="col m12">
                    <div class="row valign-wrapper inventory-entry">
                        <div class="col s3">
                            <span>{{this.inventoryEntryDetail.inventory_entry_created_at}}</span><br>
                            <h5>Entrada # {{this.inventoryEntryDetail.inventory_entry_id}}</h5>
                        </div>
                        <div class="col s2 offset-s3" align="center"><h6><i class="material-icons">store</i></h6><h6>{{this.inventoryEntryDetail.warehouse.warehouse_name}}</h6></div>
                        <div class="col s2" align="center"><h6><b>{{getProductsAmount(this.inventoryEntryDetail.products)}}</b></h6><h6>Productos ingresados</h6></div>
                        <div class="col s2" align="center"><h6><b>{{formatNumberToCurrency(this.inventoryEntryDetail.inventory_entry_total_cost)}}</b></h6><h6>Costo Total</h6></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col m12 row">
                    <product-search-bar-component class="col m6 offset-m3"></product-search-bar-component>
                    <table class="centered">
                        <thead>
                            <tr>
                                <th class="product-code-header">Codigo</th>
                                <th class="product-name-header">Nombre</th>
                                <th class="product-description-header">Descripcion</th>
                                <th class="product-measurement-header">Unidad de medida</th>
                                <th class="product-amount-header">Cantidad</th>
                                <th class="product-unit-cost-header">Costo unitario</th>
                                <th class="product-import-header">Importe total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(product,index) in this.inventoryEntryDetail.products" v-bind:key="product.product_id">
                                <td>{{product.product_code}}</td>
                                <td>{{product.product_name}}</td>
                                <td>{{product.product_description}}</td>
                                <td>PIEZA</td>
                                <td>{{product.pivot.product_entry_amount}}</td>
                                <td>{{formatNumberToCurrency(product.pivot.product_unit_cost)}}</td>
                                <td>{{formatNumberToCurrency(product.pivot.product_entry_amount * product.pivot.product_unit_cost)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="modal-action modal-close waves-effect btn-flat"><b>Cerrar</b></button>
        </div>
    </div> -->
</template>
<script>
    import { mapState, mapMutations, mapActions } from 'vuex'
    import { parseCurrency } from 'vue-currency-input'
    export default {
        data() {
            return {
                inventoryEntryDetailModal: false,
                entryProductsTableHeaders: [
                    { text: 'Código', value: 'product_code', width: '10%' },
                    { text: 'Producto', value: 'product_name', width: '15%' },
                    { text: 'Descripción', value: 'product_description', width: '20%' },
                    { text: 'Cantidad', value: 'pivot.product_entry_amount', width: '15%' },
                    { text: 'Costo unitario', value: 'pivot.product_unit_cost', width: '15%' },
                    { text: 'Importe total', value: 'product_import', width: '15%' },
                ],
            }
        },

        props: {
            inventoryEntry: {
                type: Object,
            },
        },

        computed: {
            ...mapState(['current_username', 'products_to_entry', 'products', 'products_entry_detail']),

            totalCost: function() {
                var total = 0
                this.products_entry_detail.forEach(product => {
                    var product_import = this.getImport(product.product_amount, product.product_unit_cost)
                    total = total + product_import
                })
                return total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
            },

            validateForm: function() {
                if (this.products_entry_detail.length > 0) {
                    var empty_inputs_counter = 0
                    this.products_entry_detail.forEach(product => {
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
                'addInventoryEntry',
            ]),
            saveInventoryEntry: function() {
                this.addInventoryEntry(this.totalCost)
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
                product_entries.forEach(product_entry => {
                    total_products_amount += product_entry.pivot.product_entry_amount
                })
                return total_products_amount
            },
        },
    }
</script>
