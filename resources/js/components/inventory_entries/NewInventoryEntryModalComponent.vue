<template>
    <v-dialog v-model="newInventoryEntryModal">
        <template v-slot:activator="{ on, attrs }">
            <v-speed-dial fixed bottom right>
                <template v-slot:activator>
                    <v-btn class="secondary primary--text" v-bind="attrs" v-on="on" fab>
                        <v-icon>mdi-plus</v-icon>
                    </v-btn>
                </template>
            </v-speed-dial>
        </template>
        <v-card>
            <v-container>
                <v-row>
                    <v-col cols="12" algin="center">
                        <v-row>
                            <v-col cols="3">
                                <div class="text-subtitle-2">Fecha de entrada</div>
                                <div class="body-1">{{ date }}</div>
                            </v-col>
                            <v-col cols="3">
                                <div class="text-subtitle-2">Registrada por</div>
                                <div class="body-1">{{ this.current_username }}</div>
                            </v-col>
                            <v-col cols="3">
                                <div class="text-subtitle-2">Almacén destino</div>
                                <div class="body-1">Almacén principal</div>
                            </v-col>
                            <v-col cols="3">
                                <div class="text-subtitle-2">Costo total</div>
                                <div class="body-1">${{ totalCost }}</div>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" align="center">
                        <v-data-table
                            :headers="entryProductsTableHeaders"
                            :items="productsEntryDetail"
                            item-key="product_id"
                            hide-default-footer
                            calculate-widths
                        >
                            <template v-slot:item.product_amount="{ item }">
                                <v-text-field
                                    class="pt-6"
                                    color="secondary"
                                    solo
                                    min="1"
                                    type="number"
                                    v-model="item.product_amount"
                                    suffix="pzas"
                                ></v-text-field>
                            </template>
                            <template v-slot:item.product_unit_cost="{ item }">
                                <v-text-field
                                    class="pt-6"
                                    color="secondary"
                                    solo
                                    min="1"
                                    type="number"
                                    v-model="item.product_unit_cost"
                                    prefix="$"
                                ></v-text-field>
                            </template>
                            <template v-slot:item.product_import="{ item }">
                                <v-text-field
                                    readonly
                                    class="pt-6"
                                    color="secondary"
                                    solo
                                    type="number"
                                    :value="item.product_unit_cost * item.product_amount"
                                    prefix="$"
                                ></v-text-field>
                            </template>
                        </v-data-table>
                        <products-list-dialog-component :route="1"></products-list-dialog-component>
                    </v-col>
                </v-row>
                <v-row>
                    <v-spacer></v-spacer>
                    <v-col cols="2">
                        <v-btn color="secondary" text block v-on:click="confirmationModal = true">Cancelar</v-btn>
                    </v-col>
                    <v-col cols="2">
                        <v-btn color="secondary" block :disabled="!isValidEntryForm" v-on:click="saveInventoryEntry()"
                            >Registrar entrada</v-btn
                        >
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
        <v-dialog v-model="confirmationModal" width="480">
            <v-card>
                <v-card-title>¿Cerrar registro de entrada?</v-card-title>
                <v-card-text
                    >Si sale de esta ventana sin generar la entrada, perderá la información ingresada.</v-card-text
                >
                <v-card-actions>
                    <v-btn text v-on:click="confirmationModal = false">Cancelar</v-btn>
                    <v-btn color="error" v-on:click="closeModal()">Salir</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-dialog>
</template>
<script>
    import { mapGetters, mapState, mapMutations, mapActions } from 'vuex'

    export default {
        data() {
            return {
                newInventoryEntryModal: false,
                confirmationModal: false,
                entryProductsTableHeaders: [
                    { text: 'Código', value: 'product_code', width: '10%' },
                    { text: 'Producto', value: 'product_name', width: '15%' },
                    { text: 'Descripción', value: 'product_description', width: '20%' },
                    { text: 'Cantidad', value: 'product_amount', width: '15%' },
                    { text: 'Costo unitario', value: 'product_unit_cost', width: '15%' },
                    { text: 'Importe total', value: 'product_import', width: '15%' },
                ],
            }
        },

        computed: {
            ...mapState(['current_username', 'products', 'products_entry_detail']),
            ...mapGetters('inventoryEntries', {
                productsToEntry: 'getProductsToEntry',
                productsEntryDetail: 'getProductsEntryDetail',
            }),

            totalCost: function() {
                if (this.productsEntryDetail.length == 0) {
                    return 0
                } else {
                    var total = 0
                    this.productsEntryDetail.forEach(product => {
                        total += product.product_amount * product.product_unit_cost
                    })
                    return total
                }
            },

            isValidEntryForm: function() {
                if (this.productsEntryDetail.length > 0) {
                    var productsWithNoAmount = 0
                    this.productsEntryDetail.forEach(productToEntry => {
                        if (productToEntry.product_amount == 0) {
                            productsWithNoAmount++
                        }
                    })

                    if (productsWithNoAmount > 0) {
                        return false
                    } else {
                        return true
                    }
                } else {
                    return false
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
            ...mapActions(['fetchProducts', 'addProduct', 'updateProductAmount', 'updateProductUnitCost']),

            ...mapMutations('inventoryEntries', ['RESET_PRODUCTS_TO_ENTRY', 'RESET_PRODUCTS_TO_ENTRY_DETAIL']),

            ...mapActions('inventoryEntries', ['addInventoryEntry']),

            saveInventoryEntry: function() {
                this.addInventoryEntry(this.totalCost)
                this.newInventoryEntryModal = false
            },

            closeModal: function() {
                this.$store.commit('inventoryEntries/RESET_PRODUCTS_TO_ENTRY')
                this.$store.commit('inventoryEntries/RESET_PRODUCTS_TO_ENTRY_DETAIL')
                this.newInventoryEntryModal = false
            },
        },
    }
</script>
