<template>
    <div id="newProductModal" class="modal newProductModal">
        <div class="modal-content">
            <h5>Nuevo producto</h5><br>
            <div class="row">
                <form id="newProductForm" class="col s12 no-padding" method="POST" action="products">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="row">
                        <div class="input-field col s12 m12 no-vertical-margin">
                            <input placeholder="" id="product_name" type="text" v-model="newProductName" v-on:blur="validateProductName" v-bind:class="{'valid': validProductName, 'invalid': invalidProductName}" data-length="50" maxlength="50" required>
                            <label for="product_name" class="valign-wrapper"><i class="material-icons">layers</i>&nbsp;&nbsp;Producto *</label>
                            <span class="helper-text product_name_helper" data-success="Servicio validado."></span><br>
                        </div>
                        <div class="input-field col s12 m12 no-vertical-margin">
                            <input placeholder="" id="product_description" type="text" v-model="newProductDescription" v-on:blur="validateProductDescription" v-bind:class="{'valid': validProductDescription, 'invalid': invalidProductDescription}" data-length="50" maxlength="50" required>
                            <label for="product_description" class="valign-wrapper"><i class="material-icons">settings</i>&nbsp;&nbsp;Descripción *</label>
                            <span class="helper-text product_description_helper" data-success="Descripción del producto validada."></span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button v-on:click="resetNewProductInputs" class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></button>
            <button v-on:click="saveProduct" type="submit" v-bind:class="{'disabled': validateForm}" class="modal-action btn waves-effect submit_button">
                <b>Registrar</b>
            </button>
        </div>
    </div>
</template>
<style>
    .inline-icon-large {
    vertical-align: bottom;
    font-size: 48px !important;
    }
    .inline-icon-small {
    vertical-align: bottom;
    font-size: 20px !important;
    }
    .helper-text{
        min-height: 0 !important;
    }
    .no-vertical-margin{
        margin-top: 0;
        margin-bottom: 0;
    }
</style>
<script>
    export default {
        mounted() {
            console.log('New product modal component mounted');
        },

        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                newProductName: null,
                newProductDescription: null,
                validProductName: false,
                invalidProductName: false,
                validProductDescription: false,
                invalidProductDescription: false
            }
        },

        computed: {
            validateForm: function (e) {
                if(!this.validProductName){
                    return true;
                }
            }
        },

        methods: {
            saveProduct: function(){
                var newProduct = {
                    product_id: '',
                    product_name: this.newProductName,
                    product_description: this.newProductDescription
                };

                axios.post('http://localhost:8000/products',{
                    product_name: this.newProductName,
                    product_description: this.newProductDescription
                })
                .then((res)=>{newProduct.product_id = res.data.product_id})
                .catch(function(err){
                    console.log(err);
                });

                this.$parent.products.push(newProduct);
                this.$parent.forceRerender();
                $('#newProductModal').modal('close');
            },

            validateProductName: function(e) {
                if(!this.newProductName){
                    this.validProductName = false;
                    this.invalidProductName = true;
                    $('.product_name_helper').attr('data-error', 'Este campo no puede quedar vacío.');
                }
                else{
                    this.validProductName = true;
                    this.invalidProductName = false;
                }
            },

            validateProductDescription: function(e) {
                if(!this.newProductDescription){
                    this.validProductDescription = false;
                    this.invalidProductDescription = true;
                    $('.product_description_helper').attr('data-error', 'Este campo no puede quedar vacío.');
                }
                else{
                    this.validProductDescription = true;
                    this.invalidProductDescription = false;
                }
            },

            resetNewProductInputs: function (e) {
                this.newProductName= null;
                this.newProductDescription= null;
                this.validProductName= false;
                this.invalidProductName= false;
                this.validProductDescription= false;
                this.invalidProductDescription= false;
            }
        }
    }
</script>