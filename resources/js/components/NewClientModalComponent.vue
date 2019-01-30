<template>
	<div id="newClientModal" class="modal newClientModal ">
		<div class="modal-content">
			<div class="col s12">
				<h5>Nuevo cliente</h5>
			</div>
			<div class="row">
				<form id="newClientForm" class="col s12 no-padding" method="POST" action="clients">
					<input type="hidden" name="_token" :value="csrf">
					<div class="row" style="margin-bottom: 10px;">
						<div class="input-field col s12 m6">
							<input v-model="client_name" id="client_name" type="text" class="validate" data-length="50" maxlength="50" required>
							<label for="client_name" data-error="Verifique este campo" data-success="Campo validado">Nombre*</label>
				        </div>
				        <div class="input-field col s12 m6">
							<input v-model="client_phone" id="client_phone" type="tel" data-length="10" maxlength="10">
							<label for="client_phone" data-error="Verifique este campo" data-success="Campo validado">Teléfono</label>
				        </div>
				        <div class="input-field col s12 m12" data-length="40">
							<input v-model="client_email" id="client_email" type="email">
							<label for="client_accounting_account">E-mail</label>
				        </div>
			        </div>
				</form>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></a>
			<button v-on:click="saveClient" type="submit" id="submit_button" class="modal-action btn waves-effect submit_button" ><b>Registrar</b></button>
		</div>
	</div>
</template>
<script>
	export default {
	    mounted() {
	        console.log('Component mounted.');
	        $(document).ready(function(){
	        	$('#client_name').characterCounter();
	        	$('#client_phone').characterCounter();
	        });
	    },

	    data(){
	    	return {
	    		csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
	    		client_name: null,
	    		client_phone: null,
	    		client_email: null
	    	}
	    },

	    methods:{
	    	saveClient: function(){
	    		axios.post('http://localhost:8000/clients',{
	    			client_name: this.client_name,
	    			client_phone: this.client_phone,
	    			client_email: this.client_email
	    		})
	    		.then(function(res){
	    			console.log(res);
	    			$('#newClientModal').modal('close');
	    		})
	    		.catch(function(err){
	    			console.log(err);
	    		});
	    	}
	    }
	}
</script>