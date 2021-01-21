<template>
    <v-row>
        <v-col cols="12" v-if="inventoryExits.length == 0">
            <div class="text-h4">No hay salidas registradas</div>
        </v-col>
        <v-col cols="12" v-else>
            <v-row>
                <v-col cols="12" v-for="inventory_exit in inventoryExits" v-bind:key="inventory_exit.inventory_exit_id">
                    <v-card>
                        <v-container>
                            <v-row>
                                <v-col cols="4">
                                    <div class="text-caption">{{ inventory_exit.inventory_exit_created_at }}</div>
                                    <div class="text-h5">Salida #{{ inventory_exit.inventory_exit_id }}</div>
                                </v-col>
                                <v-col cols="2" align="center">
                                    <v-icon>mdi-warehouse</v-icon>
                                    <div class="text-subtitle-1">Almacén principal</div>
                                </v-col>
                                <v-col cols="2" align="center">
                                    <div class="text-h6">{{ getProductsAmount(inventory_exit.products) }}</div>
                                    <div class="text-subtitle-1">Productos retirados</div>
                                </v-col>
                                <v-col cols="2" offset-md="2" align="center">
                                    <inventory-exit-detail-modal-component
                                        :inventory-exit="inventory_exit"
                                    ></inventory-exit-detail-modal-component>
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
            ...mapGetters('inventoryExits', {
                inventoryExits: 'getInventoryExits',
            }),
        },

        methods: {
            ...mapActions(['openModal', 'setCurrentInventoryExitDetail', 'fetchInventoryExits']),

            getProductsAmount: function(product_exits) {
                var total_products_amount = 0
                product_exits.forEach(product_exit => {
                    total_products_amount += product_exit.pivot.product_exit_amount
                })
                return total_products_amount
            },

            openExitDetailModal: function(inventory_exit_id) {
                this.setCurrentInventoryExitDetail(inventory_exit_id)
                this.openModal($('#inventoryExitDetailModal'))
            },
        },
    }
</script>
