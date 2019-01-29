<template>
	<div id="newClientModal" class="modal newClientModal modal-fixed-footer">
		<div class="modal-content">
			<div class="col s12">
				<h5>Nuevo cliente</h5>
			</div>
			<div class="row">
				<form @submit.prevent="saveClient" id="newClientForm" class="col s12 no-padding" method="POST" action="clients">
					<!-- {{ csrf_field() }} -->
					<div class="row" style="margin-bottom: 10px;">
						<div class="col s12 grey-text text-darken-2"><b>Información general</b></div>
						<div class="input-field col s12 m6">
				          <input v-model="client_name" id="client_name" name="client_name" type="text" class="validate client_name"  required>
				          <label for="client_name" data-error="Verifique este campo" data-success="Campo validado">Nombre*</label>
				        </div>
				        <div class="input-field col s12 m6">
				          <input v-model="client_phone" id="client_phone" name="client_phone" type="tel" class="validate client_phone" >
				          <label for="client_phone" data-error="Verifique este campo" data-success="Campo validado">Teléfono</label>
				        </div>
				        <div class="input-field col s12 m12">
				          <input v-model="client_email" id="client_email" name="client_email" type="email" class="client_email validate" >
				          <label for="client_accounting_account">E-mail</label>
				        </div>
			        </div>
			        <button type="submit" id="submit_button" class="modal-action btn waves-effect submit_button" ><b>Registrar</b></button>
				</form>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></a>
			
			<button type="submit" id="submit_button" class="modal-action btn waves-effect submit_button" ><b>Registrar</b></button>
		</div>
	</div>
</template>
<script>
	export default {
	    mounted() {
	        console.log('Component mounted.')
	    },

	    data(){
	    	return {
	    		client_name: null,
	    		client_phone: null,
	    		client_email: null
	    	}
	    },

	    methods:{
	    	saveClient: function(){
	    		axios.post('http://127.0.0.1:8000/clients',{
	    			client_name: this.client_name,
	    			client_phone: this.client_phone,
	    			client_email: this.client_email
	    		})
	    		.then(function(res){
	    			console.log(res);
	    		})
	    		.catch(function(err){
	    			console.log(err);
	    		});
	    		// SHOW IN CONSOLE DATA INPUTS
	    		// console.log(this.client_name);
	    		// console.log(this.client_phone);
	    		// console.log(this.client_email);
	    	}
	    }
	}
</script>