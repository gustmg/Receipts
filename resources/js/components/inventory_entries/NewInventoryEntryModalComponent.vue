<template>
    <div id="newInventoryEntryModal" class="modal newInventoryEntryModal modal-fixed-footer">
        <div class="modal-content">
            <div class="row">
                <div class="col m10 offset-m1">
                    <div class="row">
                        <div class="col m3" align="center">
                            <span><b>FECHA DE ENTRADA</b></span><br>
                            <span>{{date}}</span>
                        </div>
                        <div class="col m3" align="center">
                            <span><b>REGISTRADA POR</b></span><br>
                            <span>{{this.current_username}}</span>
                        </div>
                        <div class="col m3" align="center">
                            <span><b>ALMACEN DESTINO</b></span><br>
                            <span>Almacén Principal</span>
                        </div>
                        <div class="col m3" align="center">
                            <span><b>COSTO TOTAL</b></span><br>
                            <span>$ {{totalCost}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div v-if="this.products_to_entry.length == 0" class="col m12" align="center">
                    <h4>Lista de productos vacía</h4>
                    <span>Haz click en el botón de abajo para agregar productos a la entrada de inventario.</span><br><br>
                    <button v-on:click="openProductsListDialog" class="btn-floating btn-large">
                        <i class="material-icons">add</i>
                    </button>
                </div>
                <div v-else class="col m12 row">
                    <product-search-bar-component class="col m6 offset-m3"></product-search-bar-component>
                    <table class="centered">
                        <thead>
                            <tr>
                                <th class="product-checkbox-header">
                                    <FormulateInput
                                        type="checkbox"
                                        class="valign-wrapper"
                                    />
                                </th>
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
                            <tr v-for="(product,index) in products_to_entry" v-bind:key="product.product_id">
                                <td>
                                    <FormulateInput
                                        type="checkbox"
                                        class="valign-wrapper"
                                        name="check"
                                        v-model="products_entry_detail[index].checked"
                                    />
                                </td>
                                <td>{{product.product_code}}</td>
                                <td>{{product.product_name}}</td>
                                <td>{{product.product_description}}</td>
                                <td>PIEZA</td>
                                <td>
                                    <FormulateInput
                                        type="text"
                                        name="amount"
                                        validation="number|min:0.01"
                                        :value="products_entry_detail[index].product_amount"
                                        @input="updateAmount(index, $event)"
                                    />
                                </td>
                                <td>
                                    <FormulateInput
                                        type="text"
                                        name="unit_cost"
                                        :value="products_entry_detail[index].product_unit_cost"
                                        @input="updateUnitCost(index, $event)"
                                        v-currency
                                    />
                                </td>
                                <td>
                                    $ {{getImport(products_entry_detail[index].product_amount, products_entry_detail[index].product_unit_cost).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></button>
            <button v-on:click="saveInventoryEntry" type="submit" v-bind:class="{'disabled': validateForm}" class="modal-action btn waves-effect submit_button">
                <b>Registrar</b>
            </button>
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
    .newInventoryEntryModal{
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

        computed: {
            ...mapState(['current_username', 'products_to_entry', 'products', 'products_entry_detail']),

            totalCost: function() {
                var total=0;
                this.products_entry_detail.forEach(product => {
                    var product_import = this.getImport(product.product_amount, product.product_unit_cost);
                    total = total + product_import;
                });
                return total.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            },

            validateForm: function () {
                if(this.products_entry_detail.length > 0){
                    var empty_inputs_counter=0;
                    this.products_entry_detail.forEach(product => {
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
            ...mapActions(['addProduct', 'closeModal', 'openModal', 'updateProductAmount', 'updateProductUnitCost', 'addInventoryEntry']),
            saveInventoryEntry: function(){
                this.addInventoryEntry(this.totalCost);
                 $('#newInventoryEntryModal').modal('close');
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
            }
        }
    }
</script>