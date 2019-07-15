<template>
	<div id="updateProductModal" class="modal updateProductModal">
		<div class="modal-content">
			<h5>Editar producto</h5><br>
			<div class="row">
				<form id="updateProductForm" class="col s12 no-padding" method="POST" action="products">
					<input type="hidden" name="_token" :value="csrf">
					<div class="row">
						<div class="input-field col s8 m8 no-vertical-margin">
							<input placeholder="" v-model="updateProductName" @input="emitProductName" v-on:blur="validateProductName" v-bind:class="{'valid': validProductName, 'invalid': invalidProductName}" id="update_product_name" type="text" data-length="50" maxlength="50" required>
							<label for="update_product_name" class="valign-wrapper"><i class="material-icons">layers</i>&nbsp;&nbsp;Producto *</label>
							<span class="helper-text product_name_helper" data-success="Nombre validado."></span>
				        </div>
						<div class="input-field col s4 m4 no-vertical-margin">
							<input placeholder="" v-model="updateProductCode" @input="emitProductCode" id="update_product_code" type="text" data-length="50" maxlength="50" required>
							<label for="update_product_code" class="valign-wrapper"><i class="material-icons">layers</i>&nbsp;&nbsp;Código de producto *</label>
							<span class="helper-text product_code_helper" data-success="Nombre validado."></span>
				        </div>
				        <div class="input-field col s12 m6 no-vertical-margin">
							<input placeholder="" v-model="updateProductDescription" @input="emitProductDescription" v-on:blur="validateProductDescription" v-bind:class="{'valid': validProductDescription, 'invalid': invalidProductDescription}" id="update_product_description" type="text" data-length="50" maxlength="50" required>
							<label for="update_product_description" class="valign-wrapper"><i class="material-icons">settings</i>&nbsp;&nbsp;Descripción *</label>
							<span class="helper-text product_description_helper" data-success="Descripción del producto validada."></span>
				        </div>
			        </div>
				</form>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#" class="left delete-button" v-on:click="openDeleteProductModal"><i class="material-icons black-text">delete</i></a>
			<button v-on:click="resetUpdateProductInputs" class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></button>
			<button v-on:click="updateProduct" type="submit" class="modal-action btn waves-effect submit_button" >
				<b>Guardar</b>
			</button>
		</div>
		<delete-product-modal-component :product-id="productId.toString()"></delete-product-modal-component>
	</div>
</template>
<style type="text/css">
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
</style>
<script>
	export default {
		props: {
			productId: String,
			productName: String,
			productCode: String,
			productDescription: String
		},

	    mounted() {
	        console.log('Update Product Modal Component Mounted');
	    },

	    data(){
	    	return {
	    		csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
				updateProductName:'',
				updateProductCode:'',
	    		updateProductDescription:'',
	    		validProductName: false,
	    		invalidProductName: false,
	    		activeProductName: false,
	    		validProductDescription: false,
	    		invalidProductDescription: false
	    	}
	    },

	    watch: {
            productName(newVal) {
                this.updateProductName = newVal;
			},
			productCode(newVal) {
                this.updateProductCode = newVal;
            },
            productDescription(newVal) {
                this.updateProductDescription = newVal;
            }
        },


	    methods: {
	    	emitProductName(newInputValue) {
	            this.$emit('product-name', newInputValue);
			},
			
			emitProductCode(newInputValue) {
	            this.$emit('product-code', newInputValue);
	        },

	        emitProductDescription(newInputValue) {
	            this.$emit('product-description', newInputValue);
	        },

	    	updateProduct: function(){
	    		axios.put('http://localhost:8000/products/'+this.productId,{
					product_name: this.updateProductName,
					product_code: this.updateProductCode,
	    			product_description: this.updateProductDescription
	    		})
	    		.then(function(res){
	    			console.log(res);
	    		})
	    		.catch(function(err){
	    			console.log(err.response);
	    		});
				this.$parent.products[this.$parent.productIndex].product_name=this.updateProductName;
				this.$parent.products[this.$parent.productIndex].product_code=this.updateProductCode;
	    		this.$parent.products[this.$parent.productIndex].product_description=this.updateProductDescription;
	    		this.$parent.$parent.forceRerender();
	    		$('#updateProductModal').modal('close');
	    	},

	    	validateProductName: function(e) {
	    		if(!this.updateProductName){
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
	    		if(!this.updateProductDescription){
	    			this.validProductDescription = false;
	    			this.invalidProductDescription = true;
	    			$('.product_description_helper').attr('data-error', 'Este campo no puede quedar vacío.');
	    		}
	    		else{
	    			this.validProductDescription = true;
	    			this.invalidProductDescription = false;
	    		}
    		},

    		resetUpdateProductInputs: function(e) {
    			this.validProductName= false;
    			this.invalidProductName=false;
    			this.validProductDescription=false;
    			this.invalidProductDescription=false;
    		},

    		openDeleteProductModal: function(e) {
    			$('#deleteProductModal').modal({
    				dismissible: false
    			});
    			$('#deleteProductModal').modal('open');
    		}
	    },
	}
</script>