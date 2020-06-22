<template>
    <div id="newInventoryExitModal" class="modal newInventoryExitModal modal-fixed-footer">
        <div class="modal-content">
            <div class="row">
                <div class="col m10 offset-m1">
                    <div class="row">
                        <div class="col m4" align="center">
                            <span><b>FECHA DE SALIDA</b></span><br>
                            <span>{{date}}</span>
                        </div>
                        <div class="col m4" align="center">
                            <span><b>REGISTRADA POR</b></span><br>
                            <span>{{this.current_username}}</span>
                        </div>
                        <div class="col m4" align="center">
                            <span><b>ALMACEN DESTINO</b></span><br>
                            <span>Almacén Principal</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div v-if="this.productsToExit.length == 0" class="col m12" align="center">
                    <h4>Lista de productos vacía</h4>
                    <span>Haz click en el botón de abajo para agregar productos a la salida de inventario.</span><br><br>
                    <button v-on:click="openProductsListDialog" class="btn-floating btn-large">
                        <i class="material-icons">add</i>
                    </button>
                </div>
                <div v-else class="col m12 row" align="center">
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
                                <th class="product-amount-header">Cantidad de salida</th>
                                <th class="product-unit-cost-header">Causa de salida</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(product,index) in productsToExit" v-bind:key="product.product_id">
                                <td>
                                    <FormulateInput
                                        type="checkbox"
                                        class="valign-wrapper"
                                        name="check"
                                        v-model="productsExitDetail[index].checked"
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
                                        :validation="[
                                            ['number'],
                                            ['min', 0.01],
                                            ['max', product.product_stock]
                                        ]"
                                        :value="productsExitDetail[index].product_exit_amount"
                                        @input="updateAmount(index, $event)"
                                    />
                                    de {{product.product_stock}} actuales
                                </td>
                                <td>
                                    <FormulateInput
                                        type="text"
                                        name="exit_justification"
                                        :value="productsExitDetail[index].product_exit_justification"
                                        @input="updateExitJustification(index, $event)"
                                    />
                                </td>
                            </tr>
                        </tbody>
                    </table><br><br>
                    <button v-on:click="openProductsListDialog" class="btn-floating btn-large">
                        <i class="material-icons">add</i>
                    </button>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></button>
            <button v-on:click="saveInventoryExit" type="submit" v-bind:class="{'disabled': validateForm}" class="modal-action btn waves-effect submit_button">
                <b>Registrar</b>
            </button>
        </div>
    </div>
</template>
<style scoped>
    .product-checkbox-header{
        width: 5%
    }
    .product-code-header,
    .product-measurement-header,
    .product-amount-header{
        width: 10%;
    }
    .product-name-header{
        width: 20%;
    }
    .product-description-header{
        width: 25%;
    }
    .product-exit-cause-header{
        width: 20%;
    }
    .newInventoryExitModal{
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
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },

        computed: {
            ...mapState('inventoryExits', {
                productsToExit : state => state.productsToExit,
                productsExitDetail: state => state.productsExitDetail
            }),
            ...mapState(['current_username', 'products']),

            validateForm: function () {
                if(this.productsExitDetail.length > 0){
                    var empty_inputs_counter=0;
                    this.productsExitDetail.forEach(product => {
                        if(!product.product_exit_amount || product.product_exit_amount == '' || parseFloat(product.product_exit_amount)==0 || !product.product_exit_justification || product.product_exit_justification == ''){
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
            ...mapActions('inventoryExits', [
                'updateProductExitJustification',
                'updateProductAmount',
                'addInventoryExit'
            ]),
            ...mapActions(['fetchProducts', 'addProduct']),
            saveInventoryExit: function(){
                this.addInventoryExit();
                 $('#newInventoryExitModal').modal('close');
            },

            openProductsListDialog: function() {
                this.fetchProducts();
                $('#productsListWithStocksModal').modal('open');
            },

            updateAmount: function(product_index, newValue) {
                this.updateProductAmount({product_index, newValue});
            },

            updateExitJustification: function(product_index, new_exit_justification) {
                this.updateProductExitJustification({product_index, new_exit_justification});
            }
        }
    }
</script>