<template>
    <div id="newProductModal" class="modal newProductModal modal-fixed-footer">
        <div class="modal-content">
            <div class="row">
                <div class="col m12"><h6><b>Nuevo Producto</b></h6></div>
            </div>
            <FormulateForm class="row" name="newProductForm" v-model="newProductForm">
                <input type="hidden" name="_token" :value="csrf">
                <FormulateInput
                    @validation="invalidProductName = $event.hasErrors"
                    type="text"
                    name="product_name"
                    label="Nombre *"
                    validation="bail|required|min:5"
                    class="col m8"
                />
                <FormulateInput
                    type="text"
                    name="product_code"
                    label="Código interno"
                    class="col m4"
                />
                <FormulateInput
                    type="text"
                    name="product_description"
                    label="Descripción"
                    class="col m12"
                />
            </FormulateForm>
        </div>
        <div class="modal-footer">
            <button v-on:click="resetNewProductForm" class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></button>
            <button v-on:click="saveProduct" type="submit" v-bind:class="{'disabled': validateForm}" class="modal-action btn waves-effect submit_button">
                <b>Registrar</b>
            </button>
        </div>
    </div>
</template>
<style scoped>
    .newProductModal{
        width: 37%;
        max-height: 80%;
        height: 55%;
    }
    .money{
        height:84px;
    }
    .no-margin-bottom{
        margin-bottom: 0;
    }
</style>
<script>
    import {mapState, mapMutations, mapActions} from "vuex";
    export default {
        mounted() {
            console.log('New product modal component mounted');
        },

        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                newProductForm: null,
                invalidProductName: true,
                invalidProductCost: false,
            }
        },

        computed: {
            validateForm: function (e) {
                if(this.invalidProductName){
                    return true;
                }
                else{
                    return false;
                }
            }
        },

        methods: {
            ...mapActions(['addProduct', 'closeModal']),
            saveProduct: function(){
                this.addProduct(this.newProductForm);
                this.closeModal();
                this.$formulate.reset('newProductForm');
            },

            resetNewProductForm: function (e) {
                this.$formulate.reset('newProductForm');
            }
        }
    }
</script>