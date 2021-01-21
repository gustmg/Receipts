<template>
    <v-dialog v-model="newInventoryExitModal">
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
                                <div class="text-subtitle-2">Fecha de salida</div>
                                <div class="body-1">{{ date }}</div>
                            </v-col>
                            <v-col cols="3">
                                <div class="text-subtitle-2">Registrada por</div>
                                <div class="body-1">{{ this.current_username }}</div>
                            </v-col>
                            <v-col cols="3">
                                <div class="text-subtitle-2">Almacén origen</div>
                                <div class="body-1">Almacén principal</div>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" align="center">
                        <v-data-table
                            :headers="exitProductsTableHeaders"
                            :items="productsExitDetail"
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
                            <template v-slot:item.product_justification="{ item }">
                                <v-text-field
                                    class="pt-6"
                                    color="secondary"
                                    solo
                                    type="text"
                                    v-model="item.product_justification"
                                ></v-text-field>
                            </template>
                        </v-data-table>
                        <products-list-dialog-component :route="2"></products-list-dialog-component>
                    </v-col>
                </v-row>
                <v-row>
                    <v-spacer></v-spacer>
                    <v-col cols="2">
                        <v-btn text block v-on:click="confirmationModal = true">Cancelar</v-btn>
                    </v-col>
                    <v-col cols="2">
                        <v-btn color="secondary" block :disabled="!isValidExitForm" v-on:click="saveInventoryExit()"
                            >Registrar salida</v-btn
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
                newInventoryExitModal: false,
                confirmationModal: false,
                exitProductsTableHeaders: [
                    { text: 'Código', value: 'product_code', width: '10%' },
                    { text: 'Producto', value: 'product_name', width: '15%' },
                    { text: 'Descripción', value: 'product_description', width: '20%' },
                    { text: 'Cantidad', value: 'product_amount', width: '15%' },
                    { text: 'Justificación de salida', value: 'product_justification', width: '15%' },
                ],
            }
        },

        computed: {
            ...mapState(['current_username', 'products', 'products_exit_detail']),
            ...mapGetters('inventoryExits', {
                productsToExit: 'getProductsToExit',
                productsExitDetail: 'getProductsExitDetail',
            }),

            isValidExitForm: function() {
                if (this.productsExitDetail.length > 0) {
                    var productsWithNoAmount = 0
                    var productsWithNoJustification = 0
                    this.productsExitDetail.forEach(productToExit => {
                        if (productToExit.product_amount == 0) {
                            productsWithNoAmount++
                        }
                        if (productToExit.product_justification.length == 0) {
                            productsWithNoJustification++
                        }
                    })

                    if (productsWithNoAmount > 0 || productsWithNoJustification > 0) {
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

            ...mapMutations('inventoryExits', ['RESET_PRODUCTS_TO_EXIT', 'RESET_PRODUCTS_TO_EXIT_DETAIL']),

            ...mapActions('inventoryExits', ['addInventoryExit']),

            saveInventoryExit: function() {
                this.addInventoryExit()
                this.newInventoryExitModal = false
            },

            closeModal: function() {
                this.$store.commit('inventoryExits/RESET_PRODUCTS_TO_EXIT')
                this.$store.commit('inventoryExits/RESET_PRODUCTS_TO_EXIT_DETAIL')
                this.newInventoryExitModal = false
            },
        },
    }
</script>
