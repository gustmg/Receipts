<template>
    <div class="row">
        <div v-if="inventoryExits.length == 0" class="col m12">
            <h1>No hay salidas de inventario registradas</h1>
        </div>
        <div v-else class="row col s12">
            <div v-for="inventory_exit in inventoryExits" v-bind:key="inventory_exit.inventory_exit_id" class="card col s12">
                <div class="row valign-wrapper inventory-exit">
                    <div class="col s3">
                        <span>{{inventory_exit.inventory_exit_created_at}}</span><br>
                        <h5>Salida # {{inventory_exit.inventory_exit_id}}</h5>
                    </div>
                    <div class="col s2 offset-s3" align="center"><h6><i class="material-icons">store</i></h6><h6>Almacén principal</h6></div>
                    <div class="col s2" align="center"><h6><b>{{getProductsAmount(inventory_exit.products)}}</b></h6><h6>Productos retirados</h6></div>
                    <div class="col s2" align="center"><button v-on:click="openExitDetailModal(inventory_exit.inventory_exit_id)" class="waves-effect btn-flat blue-text">Ver detalles</button></div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
    .inventory-exit{
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
            this.fetchInventoryExits();
        },

        computed: {
            ...mapState('inventoryExits', {
                inventoryExits: state => state.inventoryExits
            })
        },

        methods: {
            ...mapActions('inventoryExits',[
                'setCurrentInventoryExitDetail',
                'fetchInventoryExits'
            ]),

            getProductsAmount: function(product_exits) {
                var total_products_amount = 0;
                product_exits.forEach(product_exit => {
                    total_products_amount += product_exit.pivot.product_exit_amount;
                });
                return total_products_amount;
            },

            openExitDetailModal: function(inventory_exit_id) {
                this.setCurrentInventoryExitDetail(inventory_exit_id);
                $('#inventoryExitDetailModal').modal('open');
            }
        }
    }
</script>