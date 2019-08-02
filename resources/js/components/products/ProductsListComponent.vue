<template>
	<div class="row">
		<div class="col s12 m3" v-show="products.length > 0" v-for="(product, index) in filteredProducts">
			<div v-on:click="updateProduct(product, index)" class="card product-card hoverable hoverable-card selectable">
		        <div class="card-content center-align">
					<span class="card-title product-title truncate">
						<i class="material-icons inline-icon-large">layers</i><br>
						<b v-if="product.product_name">{{product.product_name}}</b>
					</span>
					<p class="truncate"><i class="material-icons inline-icon-small">settings</i>
						<span v-if="product.product_description">{{product.product_description}}</span>
						<span v-else class="grey-text">Servicio sin descripción</span>
					</p>
		        </div>
		    </div>
		</div>
		<div>
			<h5 
				v-show="filteredProducts.length == 0 && this.$parent.searchProduct != '' " 
				class="center grey-text">
				Búsqueda sin resultados.
			</h5>
			<h5 v-show="products.length == 0 && this.$parent.searchProduct == ''" class="center grey-text">No hay productos registrados.</h5>
		</div>
		<update-product-modal-component :product-id="productId.toString()" :product-name="productName" :product-code="productCode" :product-description="productDescription"></update-product-modal-component>
	</div>
</template>
<style>
	.product-title{
		padding-top:8px !important;
	}
	.product-card{
		height:150px !important;	
	}
	.inline-icon-large {
	   vertical-align: bottom;
	   font-size: 48px !important;
	}
	.inline-icon-small {
	   vertical-align: bottom;
	   font-size: 20px !important;
	}

	.hoverable-card:hover{
		background-color: #eeeeee;
		transition: .1s;
	}

	.selectable{
		cursor: pointer;
	}
</style>
<script>
	export default {
		mounted(){
			
		},

		props:{
			products: {
				type: Array
			},
		},

		data() {
			return {
				productIndex: null,
				productId: '',
				productName: '',
				productCode: '',
				productDescription: ''
			}
		},

		methods: {
			updateProduct: function(product, index) {
				this.productIndex = index;
				this.productId=product.product_id;
				this.productName=product.product_name;
				this.productCode=product.product_code;
				this.productDescription=product.product_description;
				$('#update_product_name,#update_product_code,#update_product_description').characterCounter();
				$('#updateProductModal').modal({
					dismissible: false,
					onOpenStart: function() {
						$('.label_update_product_name').addClass('active');
						if(product.product_description != null){
							$('.label_update_product_description').addClass('active');
						}
					},
					onCloseEnd: function() {
						//TO-DO: Rmeove al validations and clear the form
					}
				});
				$('#updateProductModal').modal('open');
			}
		},

		computed: {
			filteredProducts: function() {
				return this.products.filter((product)=>{
					return product.product_name.toLowerCase().indexOf(this.$parent.searchProduct.toLowerCase()) >= 0;
					// || product.product_phone.indexOf(this.searchProduct) >= 0
				});   		
			}
		}
	}
</script>