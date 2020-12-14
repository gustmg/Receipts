<template>
    <v-row>
        <v-col cols="12" v-if="inventoryEntries.length == 0">
            <div class="text-h4">No hay entradas registradas</div>
        </v-col>
        <v-col cols="12" v-else>
            <v-row>
                <v-col
                    cols="12"
                    v-for="inventory_entry in inventoryEntries"
                    v-bind:key="inventory_entry.inventory_entry_id"
                >
                    <v-card>
                        <v-container>
                            <v-row>
                                <v-col cols="4">
                                    <div class="text-caption">{{ inventory_entry.inventory_entry_created_at }}</div>
                                    <div class="text-h5">Entrada #{{ inventory_entry.inventory_entry_id }}</div>
                                </v-col>
                                <v-col cols="2" align="center">
                                    <v-icon>mdi-warehouse</v-icon>
                                    <div class="text-subtitle-1">Almacén principal</div>
                                </v-col>
                                <v-col cols="2" align="center">
                                    <div class="text-h6">{{ getProductsAmount(inventory_entry.products) }}</div>
                                    <div class="text-subtitle-1">Productos ingresados</div>
                                </v-col>
                                <v-col cols="2" align="center">
                                    <div class="text-h6">
                                        {{ formatNumberToCurrency(inventory_entry.inventory_entry_total_cost) }}
                                    </div>
                                    <div class="text-subtitle-1">Costo Total</div>
                                </v-col>
                                <v-col cols="2" align="center">
                                    <inventory-entry-detail-modal-component
                                        :inventory-entry="inventory_entry"
                                    ></inventory-entry-detail-modal-component>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card>
                </v-col>
            </v-row>
        </v-col>
    </v-row>
</template>
<script>
    import { mapGetters, mapMutations, mapActions, mapState } from 'vuex'
    export default {
        computed: {
            ...mapGetters('inventoryEntries', {
                inventoryEntries: 'getInventoryEntries',
            }),
        },

        methods: {
            ...mapActions(['openModal', 'setCurrentInventoryEntryDetail', 'fetchInventoryEntries']),

            getProductsAmount: function(product_entries) {
                var total_products_amount = 0
                product_entries.forEach(product_entry => {
                    total_products_amount += product_entry.pivot.product_entry_amount
                })
                return total_products_amount
            },

            openEntryDetailModal: function(inventory_entry_id) {
                this.setCurrentInventoryEntryDetail(inventory_entry_id)
                this.openModal($('#inventoryEntryDetailModal'))
            },
        },
    }
</script>
