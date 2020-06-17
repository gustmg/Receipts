<template>
	<div id="updateProductModal" class="modal updateProductModal modal-fixed-footer">
		<div class="modal-content">
            <div class="row no-margin-bottom">
                <div class="col m12"><h6><b>Editar Producto</b></h6></div>
            </div>
            <FormulateForm class="row" name="updateProductForm" v-model="updateProductForm">
                <input type="hidden" name="_token" :value="csrf">
                <FormulateInput
                    type="hidden"
                    name="product_id"
                    v-model="product_to_update.product_id"
                />
                <blockquote class="col s12"><b>Información principal</b></blockquote>                 
                <FormulateInput
                    @validation="invalidProductName = $event.hasErrors"
                    type="text"
                    name="product_name"
                    label="Nombre *"
                    validation="bail|required|min:5"
                    class="col m12"
                    v-model="product_to_update.product_name"
                />
                <FormulateInput
                    type="text"
                    name="product_description"
                    label="Descripción"
                    class="col m12"
                    v-model="product_to_update.product_description"
                />
                <FormulateInput
                    type="text"
                    name="product_code"
                    label="Código interno"
                    class="col m6"
                    v-model="product_to_update.product_code"
                />
                <FormulateInput
                    @validation="invalidProductCost = $event.hasErrors"
                    type="text"
                    name="product_cost"
                    label="Costo ($)"
                    class="col m6"
                    validation="bail|min:0, value"
                    v-model="product_to_update.product_cost"
                    v-on:blur="validateSalePrice(product_to_update.product_cost, product_to_update_prev_cost)"
                    v-currency
                />
                <blockquote class="col s12"><b>Porcentajes de ganancia por tipo de venta</b></blockquote>
                <FormulateInput
                    @validation="invalidProductBasePricePercentage = $event.hasErrors"
                    type="number"
                    name="product_base_price_percentage"
                    label="Público en general"
                    class="col m4"
                    help="Precio de venta estimado: $1230.00"
                    validation="min:0, value"
                    min="0"
                    v-model="product_to_update.product_base_price_percentage"
                />
                <FormulateInput
                    @validation="invalidProductRetailPricePercentage = $event.hasErrors"
                    type="number"
                    name="product_retail_price_percentage"
                    label="Menudeo"
                    class="col m4"
                    help="Precio de venta estimado: $1230.00"
                    validation="min:0, value"
                    min="0"
                    v-model="product_to_update.product_retail_price_percentage"
                />
                <FormulateInput
                    @validation="invalidProductWholesalePricePercentage = $event.hasErrors"
                    type="number"
                    name="product_wholesale_price_percentage"
                    label="Mayoreo"
                    class="col m4"
                    help="Precio de venta estimado: $1230.00"
                    validation="min:0, value"
                    min="0"
                    v-model="product_to_update.product_wholesale_price_percentage"
                />
            </FormulateForm>
        </div>
        <div class="modal-footer">
            <button v-on:click="resetUpdateProductForm" class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></button>
            <button v-on:click="saveProduct" type="submit" v-bind:class="{'disabled': validateForm}" class="modal-action btn waves-effect submit_button">
                <b>Editar</b>
            </button>
        </div>
	</div>
</template>
<style type="text/css">
    .updateProductModal{
        width: 37%;
        max-height: 80%;
        height: 80%;
    }
	.delete-button{
		margin-left: 10px;
		margin-top: 10px;
	}
	.inline-icon-large {
	   vertical-align: bottom;
	   font-size: 48px !important;
	}
	.inline-icon-small {
	   vertical-align: bottom;
	   font-size: 20px !important;
	}
	.no-vertical-margin{
		margin-top: 0;
		margin-bottom: 0;
	}
	.helper-text{
		min-height: 0 !important;
    }
    .no-margin-bottom{
        margin-bottom:0;
    }
</style>
<script>
    import {mapState, mapMutations, mapActions} from "vuex";

	export default {
	    mounted() {
	        console.log('Update Product Modal Component Mounted');
	    },

	    data(){
	    	return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                updateProductForm: null,
                invalidProductName: true,
                invalidProductCost: false,
                invalidProductBasePricePercentage: false,
                invalidProductRetailPricePercentage: false,
                invalidProductWholesalePricePercentage: false
	    	}
        },
        
        computed:{
            ...mapState(['product_to_update', 'product_to_update_prev_cost']),

            validateForm: function (e) {
                if(this.invalidProductName || this.invalidProductCost || this.invalidProductBasePricePercentage || this.invalidProductRetailPricePercentage || this.invalidProductWholesalePricePercentage){
                    return true;
                }
                else{
                    return false;
                }
            },

            productCost: function(e) {
                return this.$parseCurrency(this.updateProductForm.product_cost)
            }
        },

	    methods: {
            ...mapActions(['updateProduct', 'closeModal']),
	    	saveProduct: function(){
                this.updateProductForm.product_cost=this.productCost;
                this.updateProduct(this.updateProductForm);
                this.$formulate.reset('updateProductForm');
                this.closeModal();
	    	},

    		resetUpdateProductForm: function(e) {
    			this.$formulate.reset('updateProductForm');
            },

            validateSalePrice: function (salePrice, cost) {
                if(salePrice < cost && salePrice != ''){
                    $('#warningProductCostModal').modal('open');
                }
            }
	    },
	}
</script>