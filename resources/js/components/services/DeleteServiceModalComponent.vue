<template>
	<div id="deleteServiceModal" class="modal">
		<div class="modal-content">
			<h5>¿Eliminar servicio?</h5>
			<p>Las recepciones de equipo a nombre de este servicio se verán afectadas.</p>
		</div>
		<div class="modal-footer">
			<button v-on:click="closeDeleteServiceModal" class="modal-action waves-effect btn-flat"><b>Cancelar</b></button>
			<button v-on:click="deleteService" type="submit" class="modal-action btn waves-effect submit_button" >
				<b>Eliminar</b>
			</button>
		</div>
	</div>
</template>
<style></style>
<script>
	export default {
		mounted(){
			console.log('Delete Service component mounted');
		},

		props: {
			serviceId: String
		},

		methods: {
			closeDeleteServiceModal: function(e) {
				$('#deleteServiceModal').modal('close');
			},

			deleteService: function(e) {
				axios.delete('http://localhost:8000/services/'+this.serviceId)
				.then(function(res){
					// console.log(res);
				})
				.catch(function(err){
					console.log(err.response);
				});
				this.$parent.$parent.services.splice(this.$parent.$parent.serviceIndex,1);
				this.$parent.$parent.$parent.forceRerender();
				$('#updateServiceModal, #deleteServiceModal').modal('close');
			}
		}
	}
</script>