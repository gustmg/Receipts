<template>
    <div class="row">
        <div v-if="inventory_entries.length == 0" class="col m12">
            <h1>No hay entradas de inventario registradas</h1>
        </div>
        <div v-else class="row col s12">
            <div v-for="inventory_entry in inventory_entries" v-bind:key="inventory_entry.inventory_entry_id" class="card col s12">
                <div class="row valign-wrapper inventory-entry">
                    <div class="col s3">
                        <span>{{inventory_entry.inventory_entry_created_at}}</span><br>
                        <h5>Entrada # {{inventory_entry.inventory_entry_id}}</h5>
                    </div>
                    <div class="col s2 offset-s3" align="center"><h6><i class="material-icons">store</i></h6><h6>Almacén principal</h6></div>
                    <div class="col s1" align="center"><h6><b>{{getProductsAmount(inventory_entry.products)}}</b></h6><h6>Productos ingresados</h6></div>
                    <div class="col s2" align="center"><h6><b>{{formatNumberToCurrency(inventory_entry.inventory_entry_total_cost)}}</b></h6><h6>Costo Total</h6></div>
                    <div class="col s1" align="center"><button v-on:click="openEntryDetailModal(inventory_entry.inventory_entry_id)" class="waves-effect btn-flat blue-text">Ver detalles</button></div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
    .inventory-entry{
        margin-top: 16px;
        margin-bottom: 16px;
        margin-left: 4px;
        margin-right: 4px;
    }
</style>
<script>
    import {mapMutations, mapActions, mapState} from "vuex";
    export default {
        mounted () {            
            this.fetchInventoryEntries();
        },

        computed: {
            ...mapState(['inventory_entries'])
        },

        methods: {
            ...mapActions(['openModal', 'setCurrentInventoryEntryDetail', 'fetchInventoryEntries']),
            getProductsAmount: function(product_entries) {
                var total_products_amount = 0;
                product_entries.forEach(product_entry => {
                    total_products_amount += product_entry.pivot.product_entry_amount;
                });
                return total_products_amount;
            },

            openEntryDetailModal: function(inventory_entry_id) {
                this.setCurrentInventoryEntryDetail(inventory_entry_id);
                this.openModal($('#inventoryEntryDetailModal'));
            },
        }
    }
</script>