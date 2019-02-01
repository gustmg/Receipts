<template>
	<div id="newClientModal" class="modal newClientModal">
		<div class="modal-content">
			<div class="row">
				<div class="col s12">
					<h5>Nuevo cliente</h5>
				</div>
			</div>
			<div class="row">
				<form id="newClientForm" class="col s12 no-padding" method="POST" action="clients">
					<input type="hidden" name="_token" :value="csrf">
					<div class="row">
						<div class="input-field col s12 m8">
							<input v-model="client_name" v-on:blur="validateClientName" v-bind:class="{'valid': validClientName, 'invalid': invalidClientName}" id="client_name" type="text" data-length="50" maxlength="50" required>
							<label for="client_name">
								<i class="material-icons inline-icon-small">person</i> Nombre*
							</label>
							<span class="helper-text client_name_helper" data-success="Nombre validado."></span>
				        </div>
				        <div class="input-field col s12 m4">
							<input v-model="client_phone" v-on:blur="validateClientPhone" v-bind:class="{'valid': validClientPhone, 'invalid': invalidClientPhone}" id="client_phone" type="tel" data-length="10" minlength="10" maxlength="10">
							<label for="client_phone">
								<i class="material-icons inline-icon-small">phone</i> Teléfono
							</label>
							<span class="helper-text client_phone_helper" data-success="Teléfono validado."></span>
				        </div>
				        <div class="input-field col s12 m6">
							<input v-model="client_email" v-on:blur="validateClientEmail" v-bind:class="{'valid': validClientEmail, 'invalid': invalidClientEmail}" id="client_email" type="email" data-length="40" maxlength="40">
							<label for="client_email">
								<i class="material-icons inline-icon-small">email</i> E-mail
							</label>
							<span class="helper-text client_email_helper" data-success="Correo validado."></span>
				        </div>
			        </div>
				</form>
			</div>
		</div>
		<div class="modal-footer">
			<button v-on:click="resetNewClientInputs" class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></button>
			<button v-on:click="saveClient" type="submit" class="modal-action btn waves-effect submit_button" >
				<b>Registrar</b>
			</button>
		</div>
	</div>
</template>
<style type="text/css">
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
</style>
<script>
	export default {
	    mounted() {
	        console.log('New client modal mounted.');
	        $(document).ready(function(){
	        	$('#client_name,#client_phone,#client_email').characterCounter();
	        });
	    },

	    data(){
	    	return {
	    		csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
	    		client_name: null,
	    		client_phone: null,
	    		client_email: null,
	    		validClientName: false,
	    		invalidClientName: false,
	    		validClientPhone: false,
	    		invalidClientPhone: false,
	    		validClientEmail: false,
	    		invalidClientEmail: false
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
	    	},

	    	validateClientName: function(e) {
	    		if(!this.client_name){
	    			this.validClientName = false;
	    			this.invalidClientName = true;
	    			$('.client_name_helper').attr('data-error', 'Este campo no puede quedar vacío.');
	    		}
	    		else{
	    			this.validClientName = true;
	    			this.invalidClientName = false;
	    		}
    		},

    		validateClientPhone: function(e) {
    			const phone_regexp = /^[0-9]*$/gm;

    			if(this.client_phone ==null || this.client_phone.length == 0){
    				this.validClientPhone = false;
	    			this.invalidClientPhone = false;
    			}
    			else if(!phone_regexp.test(this.client_phone) || this.client_phone.length < 10){
    				this.validClientPhone = false;
	    			this.invalidClientPhone = true;
    				$('.client_phone_helper').attr('data-error', 'Número telefónico no válido.');
    			}
    			else{
    				this.validClientPhone = true;
	    			this.invalidClientPhone = false;
    			}
    		},

    		validateClientEmail: function(e) {
    			const mail_regexp = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    			if(this.client_email ==null || this.client_email.length == 0){
    				this.validClientEmail = false;
	    			this.invalidClientEmail = false;
    			}
    			else if(!mail_regexp.test(this.client_email)){
    				this.validClientEmail = false;
	    			this.invalidClientEmail = true;
    				$('.client_email_helper').attr('data-error', 'Correo electrónico no válido.');
    			}
    			else{
    				this.validClientEmail = true;
	    			this.invalidClientEmail = false;
    			}
    		},

    		resetNewClientInputs: function (e) {
    			this.client_name=null;
    			this.client_phone=null;
    			this.client_email=null;
    			this.validClientName= false;
    			this.invalidClientName=false;
    			this.validClientPhone=false;
    			this.invalidClientPhone=false;
    			this.validClientEmail=false;
    			this.invalidClientEmail=false;
    		}
	    }
	}
</script>