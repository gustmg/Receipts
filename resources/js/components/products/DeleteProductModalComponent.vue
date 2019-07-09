<template>
	<div id="deleteProductModal" class="modal">
		<div class="modal-content">
			<h5>¿Eliminar producto?</h5>
		</div>
		<div class="modal-footer">
			<button v-on:click="closeDeleteProductModal" class="modal-action waves-effect btn-flat"><b>Cancelar</b></button>
			<button v-on:click="deleteProduct" type="submit" class="modal-action btn waves-effect submit_button" >
				<b>Eliminar</b>
			</button>
		</div>
	</div>
</template>
<style></style>
<script>
	export default {
		mounted(){
			console.log('Delete Product component mounted');
		},

		props: {
			productId: String
		},

		methods: {
			closeDeleteProductModal: function(e) {
				$('#deleteProductModal').modal('close');
			},

			deleteProduct: function(e) {
				axios.delete('http://localhost:8000/products/'+this.productId)
				.then(function(res){
					// console.log(res);
				})
				.catch(function(err){
					console.log(err.response);
				});
				this.$parent.$parent.products.splice(this.$parent.$parent.productIndex,1);
				this.$parent.$parent.$parent.forceRerender();
				$('#updateProductModal, #deleteProductModal').modal('close');
			}
		}
	}
</script>