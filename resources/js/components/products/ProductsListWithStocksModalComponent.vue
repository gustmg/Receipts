<template>
    <div id="productsListWithStocksModal" class="modal productsListWithStocksModal modal-fixed-footer">
        <div class="modal-content">
            <div class="row">
                <div class="col s12">
                    <product-search-bar-component></product-search-bar-component>
                    <ul class="collection row">
                        <FormulateForm v-model="productsChecklist">
                            <li v-for="product in products" v-bind:key="product.product_id" class="collection-item col s12 row valign-wrapper">
                                <div class="col s2" align="center">
                                    <FormulateInput
                                        type="checkbox"
                                        class="valign-wrapper"
                                        :name="product.product_name"
                                        checked=''
                                        @input="validateForm"
                                    />
                                </div>
                                <div class="col s8">
                                    {{product.product_name}}
                                </div>
                                <div class="col s2" align="center">{{product.product_stock}}</div>
                            </li>
                        </FormulateForm>
                    </ul>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></button>
            <button v-on:click="addProductsToTable" type="submit" class="modal-action btn waves-effect add_products_button disabled">
                <b>Registrar</b>
            </button>
        </div>
    </div>
</template>
<style scoped>
    .productsListWithStocksModal{
        width: 35%;
    }
    .collection-item{
        height: 87px;
    }


</style>
<script>
    import {mapState, mapMutations, mapActions} from "vuex";
    export default {
        mounted() {
            this.fetchProducts();
        },
        
        data() {
            return {
                inventoryEntriesProducts: [],
                productsChecklist: {},
                currentPage: window.location.href
            }
        },

        computed: {
            ...mapState({
                products: function(state) {
                    if(this.currentPage == 'http://localhost:8000/inventory_entries' || this.currentPage == 'http://127.0.0.1:8000/inventory_entries'){
                        return state.products;
                    }
                    else{
                        var filteredProductsByStock = [];
                        state.products.forEach(product => {
                            if(product.product_stock > 0){
                                filteredProductsByStock.push(product);
                            }
                        });
                        return filteredProductsByStock;
                    }
                }
            }),
        },
        methods: {
            ...mapActions('inventoryExits', [
                'setProductsToExit'
            ]),
            ...mapActions(['fetchProducts', 'setProductsToEntry', 'closeModal']),
            addProductsToTable: function() {
                if(this.currentPage == 'http://localhost:8000/inventory_entries' || this.currentPage == 'http://127.0.0.1:8000/inventory_entries'){
                    var products_to_entry=[];
                    this.products.forEach(product => {
                        var name = product.product_name;
                        if(this.productsChecklist[name] == true){
                            products_to_entry.push(product);
                        }
                    });
                    this.setProductsToEntry(products_to_entry);
                }
                else{
                    var productsToExit=[];
                    this.products.forEach(product => {
                        var name = product.product_name;
                        if(this.productsChecklist[name] == true){
                            productsToExit.push(product);
                        }
                    });
                    this.setProductsToExit(productsToExit);
                }
                
                $('#productsListWithStocksModal').modal('close');
            },

            fetchProductExistences: function() {
                axios.get('/inventory_entries_products')
                .then(response => {this.inventoryEntriesProducts = response.data.inventory_entries_products})
                .catch(function(err){
                    console.log(err);
                });
            },

            getProductStock: function(product_id) {
                var product_stock = 0;
                this.inventoryEntriesProducts.forEach(entry => {
                    if(entry.product_id == product_id){
                        product_stock += entry.product_entry_amount;
                    }
                });
                return product_stock;
            },

            validateForm: function() {
                var total_checked=0;
                this.products.forEach(product => {
                    var name = product.product_name;
                    if(this.productsChecklist[name] == true){
                        total_checked+=1;
                    }
                });
                if(total_checked > 0){
                    $('.add_products_button').removeClass('disabled');
                }
                else{
                    $('.add_products_button').addClass('disabled');
                }
            }
        }
    }
</script>