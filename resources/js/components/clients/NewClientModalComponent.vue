<template>
	<div id="newClientModal" class="modal newClientModal">
		<div class="modal-content">
			<h5>Nuevo cliente</h5>
			<div class="row">
				<form id="newClientForm" class="col s12 no-padding" method="POST" action="clients">
					<input type="hidden" name="_token" :value="csrf">
					<div class="row">
						<div class="input-field col s12 m12 no-vertical-margin">
							<i class="material-icons prefix">person</i>
							<input v-model="newClientName" v-on:blur="validateClientName" v-bind:class="{'valid': validClientName, 'invalid': invalidClientName}" id="client_name" type="text" data-length="50" maxlength="50" placeholder="Nombre *" required>
							<span class="helper-text client_name_helper" data-success="Nombre validado."></span>
				        </div>
				        <div class="input-field col s12 m6 no-vertical-margin">
				        	<i class="material-icons prefix">phone</i>
							<input v-model="newClientPhone" v-on:blur="validateClientPhone" v-bind:class="{'valid': validClientPhone, 'invalid': invalidClientPhone}" id="client_phone" type="tel" data-length="10" minlength="10" maxlength="10" placeholder="Teléfono">
							<span class="helper-text client_phone_helper" data-success="Teléfono validado."></span>
				        </div>
				        <div class="input-field col s12 m8 no-vertical-margin">
				        	<i class="material-icons prefix">email</i>
							<input v-model="newClientEmail" v-on:blur="validateClientEmail" v-bind:class="{'valid': validClientEmail, 'invalid': invalidClientEmail}" id="client_email" type="email" data-length="40" maxlength="40" placeholder="E-mail">
							<span class="helper-text client_email_helper" data-success="Correo validado."></span>
				        </div>
			        </div>
				</form>
			</div>
		</div>
		<div class="modal-footer">
			<button v-on:click="resetNewClientInputs" class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></button>
			<button v-on:click="saveClient" type="submit" v-bind:class="{'disabled': validateForm}" class="modal-action btn waves-effect submit_button">
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
	.no-vertical-margin{
		margin-top: 0;
		margin-bottom: 0;
	}

</style>
<script>
	export default {
	    mounted() {
	        console.log('New client modal mounted.');
	    },

	    data(){
	    	return {
	    		csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
	    		newClientName: null,
	    		newClientPhone: null,
	    		newClientEmail: null,
	    		validClientName: false,
	    		invalidClientName: false,
	    		validClientPhone: false,
	    		invalidClientPhone: false,
	    		validClientEmail: false,
	    		invalidClientEmail: false
	    	}
	    },

	    computed: {
	    	validateForm: function(e) {
	    		if(!this.validClientName || this.invalidClientPhone || this.invalidClientEmail){
	    			return true;
	    		}
	    	}
	    },

	    methods:{
	    	saveClient: function(){
	    		var newClient = {
		    		client_id: '',
		    		client_name: this.newClientName,
		    		client_phone: this.newClientPhone,
		    		client_email: this.newClientEmail
		    	};

	    		axios.post('http://localhost:8000/clients',{
	    			client_name: this.newClientName,
	    			client_phone: this.newClientPhone,
	    			client_email: this.newClientEmail
	    		})
	    		.then((res)=>{newClient.client_id = res.data.client_id})
	    		.catch(function(err){
	    			console.log(err);
	    		});

	    		this.$parent.clients.push(newClient);
	    		this.$parent.forceRerender();
	    		$('#newClientModal').modal('close');
	    	},

	    	validateClientName: function(e) {
	    		if(!this.newClientName){
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
    			const PHONE_REGEXP = /^[0-9]*$/gm;

    			if(this.newClientPhone ==null || this.newClientPhone.length == 0){
    				this.validClientPhone = false;
	    			this.invalidClientPhone = false;
    			}
    			else if(!PHONE_REGEXP.test(this.newClientPhone) || this.newClientPhone.length < 10){
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
    			const MAIL_REGEXP = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    			if(this.newClientEmail ==null || this.newClientEmail.length == 0){
    				this.validClientEmail = false;
	    			this.invalidClientEmail = false;
    			}
    			else if(!MAIL_REGEXP.test(this.newClientEmail)){
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
    			this.newClientName=null;
    			this.newClientPhone=null;
    			this.newClientEmail=null;
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