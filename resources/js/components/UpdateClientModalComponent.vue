<template>
	<div id="updateClientModal" class="modal updateClientModal">
		<div class="modal-content">
			<h5>Editar cliente</h5>
			<div class="row">
				<form id="updateClientForm" class="col s12 no-padding" method="POST" action="clients">
					<input type="hidden" name="_token" :value="csrf">
					<div class="row">
						<div class="input-field col s12 m12 no-vertical-margin">
							<i class="material-icons prefix">person</i>
							<input v-model="updateClientName" @input="emitClientName" v-on:blur="validateClientName" v-bind:class="{'valid': validClientName, 'invalid': invalidClientName}" id="update_client_name" type="text" data-length="50" maxlength="50" placeholder="Nombre *" required>
							<span class="helper-text client_name_helper" data-success="Nombre validado."></span>
				        </div>
				        <div class="input-field col s12 m6 no-vertical-margin">
				        	<i class="material-icons prefix">phone</i>
							<input v-model="updateClientPhone" v-on:blur="validateClientPhone" v-bind:class="{'valid': validClientPhone, 'invalid': invalidClientPhone}" id="update_client_phone" type="tel" data-length="10" minlength="10" maxlength="10" placeholder="Teléfono">
							<span class="helper-text client_phone_helper" data-success="Teléfono validado."></span>
				        </div>
				        <div class="input-field col s12 m8 no-vertical-margin">
				        	<i class="material-icons prefix">email</i>
							<input v-model="updateClientEmail" v-on:blur="validateClientEmail" v-bind:class="{'valid': validClientEmail, 'invalid': invalidClientEmail}" id="update_client_email" type="email" data-length="40" maxlength="40" placeholder="E-mail">
							<span class="helper-text client_email_helper" data-success="Correo validado."></span>
				        </div>
			        </div>
				</form>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#" class="left delete-button"><i class="material-icons black-text">delete</i></a>
			<button v-on:click="resetUpdateClientInputs" class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></button>
			<button v-on:click="updateClient" type="submit" class="modal-action btn waves-effect submit_button" >
				<b>Guardar</b>
			</button>
		</div>
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
			clientId: String,
			clientName: String,
			clientPhone: String,
			clientEmail: String
		},

	    mounted() {
	        console.log('Update Client Modal Component Mounted');
	    },

	    data(){
	    	return {
	    		csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
	    		updateClientName:'',
	    		updateClientPhone:'',
	    		updateClientEmail:'',
	    		validClientName: false,
	    		invalidClientName: false,
	    		activeClientName: false,
	    		validClientPhone: false,
	    		invalidClientPhone: false,
	    		validClientEmail: false,
	    		invalidClientEmail: false
	    	}
	    },

	    watch: {
            clientName(newVal) {
                this.updateClientName = newVal;
            },
            clientPhone(newVal) {
                this.updateClientPhone = newVal;
            },
            clientEmail(newVal) {
                this.updateClientEmail = newVal;
            }
        },


	    methods:{
	    	emitClientName(newInputValue) {
	            this.$emit('client-name', newInputValue);
	        },

	        emitClientPhone(newInputValue) {
	            this.$emit('client-phone', newInputValue);
	        },

	        emitClientEmail(newInputValue) {
	            this.$emit('client-email', newInputValue);
	        },

	    	updateClient: function(){
	    		axios.put('http://localhost:8000/clients/'+this.clientId,{
	    			client_name: this.updateClientName,
	    			client_phone: this.updateClientPhone,
	    			client_email: this.updateClientEmail
	    		})
	    		.then(function(res){
	    			console.log(res);
	    			$('#updateClientModal').modal('close');
	    		})
	    		.catch(function(err){
	    			console.log(err.response);
	    		});
	    	},

	    	validateClientName: function(e) {
	    		if(!this.updateClientName){
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

    			if(!phone_regexp.test(this.updateClientPhone) || this.updateClientPhone.length < 10){
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

    			if(!mail_regexp.test(this.updateClientEmail)){
    				this.validClientEmail = false;
	    			this.invalidClientEmail = true;
    				$('.client_email_helper').attr('data-error', 'Correo electrónico no válido.');
    			}
    			else{
    				this.validClientEmail = true;
	    			this.invalidClientEmail = false;
    			}
    		},

    		resetUpdateClientInputs: function (e) {
    			this.validClientName= false;
    			this.invalidClientName=false;
    			this.validClientPhone=false;
    			this.invalidClientPhone=false;
    			this.validClientEmail=false;
    			this.invalidClientEmail=false;
    		}
	    },
	}
</script>