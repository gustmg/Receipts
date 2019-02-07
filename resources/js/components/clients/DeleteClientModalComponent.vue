<template>
	<div id="deleteClientModal" class="modal">
		<div class="modal-content">
			<h5>¿Eliminar cliente?</h5>
			<p>Las recepciones de equipo a nombre de este cliente se verán afectadas.</p>
		</div>
		<div class="modal-footer">
			<button v-on:click="closeDeleteClientModal" class="modal-action waves-effect btn-flat"><b>Cancelar</b></button>
			<button v-on:click="deleteClient" type="submit" class="modal-action btn waves-effect submit_button" >
				<b>Eliminar</b>
			</button>
		</div>
	</div>
</template>
<style></style>
<script>
	export default {
		mounted(){
			console.log('Delete Client component mounted');
		},

		props: {
			clientId: String
		},

		methods: {
			closeDeleteClientModal: function(e) {
				$('#deleteClientModal').modal('close');
			},

			deleteClient: function(e) {
				axios.delete('http://localhost:8000/clients/'+this.clientId)
				.then(function(res){
					// console.log(res);
				})
				.catch(function(err){
					console.log(err.response);
				});
				this.$parent.$parent.clients.splice(this.$parent.$parent.clientIndex,1);
				this.$parent.$parent.$parent.forceRerender();
				$('#updateClientModal, #deleteClientModal').modal('close');
			}
		}
	}
</script>