<template>
    <div id="inventoryExitDetailModal" class="modal inventoryExitDetailModal modal-fixed-footer">
        <div class="modal-content" v-if="this.inventoryExitDetail">
            <div class="row">
                <div class="col m12">
                    <div class="row valign-wrapper inventory-exit">
                        <div class="col s3">
                            <span>{{this.inventoryExitDetail.inventory_exit_created_at}}</span><br>
                            <h5>Salida # {{this.inventoryExitDetail.inventory_exit_id}}</h5>
                        </div>
                        <div class="col s3 offset-s3" align="center"><h6><i class="material-icons">store</i></h6><h6>{{this.inventoryExitDetail.warehouse.warehouse_name}}</h6></div>
                        <div class="col s3" align="center"><h6><b>{{getProductsAmount(this.inventoryExitDetail.products)}}</b></h6><h6>Productos retirados</h6></div>
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
                                <th class="product-amount-header">Cantidad de salida</th>
                                <th class="product-unit-cost-header">Causa de salida</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(product,index) in this.inventoryExitDetail.products" v-bind:key="product.product_id">
                                <td>{{product.product_code}}</td>
                                <td>{{product.product_name}}</td>
                                <td>{{product.product_description}}</td>
                                <td>PIEZA</td>
                                <td>{{product.pivot.product_exit_amount}}</td>
                                <td>{{product.pivot.product_exit_justification}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="modal-action modal-close waves-effect btn-flat"><b>Cerrar</b></button>
        </div>
    </div>
</template>
<style scoped>
    .product-checkbox-header{
        width: 5%;
    }
    .product-name-header{
        width: 20%;
    }
    .product-description-header{
        width: 25%;
    }
    .product-code-header,
    .product-measurement-header,
    .product-amount-header,
    .product-unit-cost-header,
    .product-import-header{
        width: 10%;
    }
    .inventoryExitDetailModal{
        width: 95%;
        max-height: 80%;
    }
</style>
<script>
    import {mapState, mapMutations, mapActions} from "vuex";
    import { parseCurrency } from 'vue-currency-input'
    export default {
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                invalidProductName: true
            }
        },

        props: {
            inventoryExitDetail: {
                type: Object
            }
        },

        computed: {
            ...mapState(['current_username','products_to_exit', 'products', 'products_exit_detail']),

            totalCost: function() {
                var total=0;
                this.products_exit_detail.forEach(product => {
                    var product_import = this.getImport(product.product_amount, product.product_unit_cost);
                    total = total + product_import;
                });
                return total.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            },

            validateForm: function () {
                if(this.products_exit_detail.length > 0){
                    var empty_inputs_counter=0;
                    this.products_exit_detail.forEach(product => {
                        if(!product.product_amount || product.product_amount == '' || !product.product_unit_cost || product.product_unit_cost == '' || parseFloat(product.product_amount)==0 || parseFloat(product.product_unit_cost.replace(/[^\d.]/g, ''))==0){
                            empty_inputs_counter ++;
                        }
                    });

                    if(empty_inputs_counter == 0){
                        return false;
                    }
                    else{
                        return true;
                    }
                }
                else{
                    return true;
                }
            },

            date: function() {
                var d = new Date();

                switch (d.getMonth()) {
                    case 0:
                        return "Enero "+d.getDate()+", "+d.getFullYear();
                    case 1:
                        return "Febrero "+d.getDate()+", "+d.getFullYear();
                    case 2:
                        return "Marzo "+d.getDate()+", "+d.getFullYear();
                    case 3:
                        return "Abril "+d.getDate()+", "+d.getFullYear();
                    case 4:
                        return "Mayo "+d.getDate()+", "+d.getFullYear();
                    case 5:
                        return "Junio "+d.getDate()+", "+d.getFullYear();
                    case 6:
                        return "Julio "+d.getDate()+", "+d.getFullYear();
                    case 7:
                        return "Agosto "+d.getDate()+", "+d.getFullYear();
                    case 8:
                        return "Septiembre "+d.getDate()+", "+d.getFullYear();
                    case 9:
                        return "Octubre "+d.getDate()+", "+d.getFullYear();
                    case 10:
                        return "Noviembre "+d.getDate()+", "+d.getFullYear();
                    case 11:
                        return "Diciembre "+d.getDate()+", "+d.getFullYear();
                    default:
                        break;
                }
            }
        },

        methods: {
            ...mapActions(['addProduct', 'closeModal', 'openModal', 'updateProductAmount', 'updateProductUnitCost', 'addInventoryExit']),
            saveInventoryExit: function(){
                this.addInventoryExit(this.totalCost);
                this.closeModal();
            },

            openProductsListDialog: function() {
                this.openModal($('#productsListWithStocksModal'));
            },

            updateAmount: function(product_index, newValue) {
                this.updateProductAmount({product_index, newValue});
            },

            updateUnitCost: function(product_index, new_unit_cost) {
                this.updateProductUnitCost({product_index, new_unit_cost});
            },

            getImport: function(amount, unit_cost) {
                if(amount && unit_cost){
                    var parsed_amount = parseFloat(amount);
                    var parsed_unit_cost = unit_cost.replace(/[^\d.]/g, '');
                    return (parsed_amount*parsed_unit_cost);
                }
                else{
                    return 0;
                }
            },

            getProductsAmount: function(product_exits) {
                var total_products_amount = 0;
                product_exits.forEach(product_exit => {
                    total_products_amount += product_exit.pivot.product_exit_amount;
                });
                return total_products_amount;
            },
        }
    }
</script>