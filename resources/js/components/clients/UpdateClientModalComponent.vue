<template>
	<div id="updateClientModal" class="modal updateClientModal">
		<div class="modal-content">
			<h5>Editar cliente</h5><br>
			<div class="row">
				<form id="updateClientForm" class="col s12 no-padding" method="POST" action="clients">
					<input type="hidden" name="_token" :value="csrf">
					<div class="row">
						<div class="input-field col s12 m12 no-vertical-margin">
							<input placeholder="" id="update_client_name" type="text" @input="emitClientName" v-model="updateClientName" v-on:blur="validateClientName" v-bind:class="{'valid': validClientName, 'invalid': invalidClientName}" data-length="50" maxlength="50" required>
							<label for="update_client_name" class="valign-wrapper"><i class="material-icons">person</i>&nbsp;&nbsp;Nombre *</label>
							<span class="helper-text client_name_helper" data-success="Nombre validado."></span><br>
				        </div>
				        <div class="input-field col s12 m4 no-vertical-margin">
							<input placeholder="" id="update_client_phone" type="tel" v-model="updateClientPhone" v-on:blur="validateClientPhone" v-bind:class="{'valid': validClientPhone, 'invalid': invalidClientPhone}" data-length="10" minlength="10" maxlength="10">
							<label for="update_client_phone" class="valign-wrapper"><i class="material-icons">phone</i>&nbsp;&nbsp;Teléfono</label>
							<span class="helper-text client_phone_helper" data-success="Teléfono validado."></span>
				        </div>
				        <div class="input-field col s12 m8 no-vertical-margin">
							<input placeholder="" id="update_client_email" type="email" v-model="updateClientEmail" v-on:blur="validateClientEmail" v-bind:class="{'valid': validClientEmail, 'invalid': invalidClientEmail}" data-length="40" maxlength="40">
							<label for="update_client_email" class="valign-wrapper"><i class="material-icons">email</i>&nbsp;&nbsp;Correo electrónico</label>
							<span class="helper-text client_email_helper" data-success="Correo validado."></span>
				        </div>
			        </div>
				</form>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#" class="left delete-button" v-on:click="openDeleteClientModal"><i class="material-icons black-text">delete</i></a>
			<button v-on:click="resetUpdateClientInputs" class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></button>
			<button v-on:click="updateClient" type="submit" class="modal-action btn waves-effect submit_button" >
				<b>Guardar</b>
			</button>
		</div>
		<delete-client-modal-component :client-id="clientId.toString()"></delete-client-modal-component>
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


	    methods: {
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
	    		})
	    		.catch(function(err){
	    			console.log(err.response);
	    		});
	    		this.$parent.clients[this.$parent.clientIndex].client_name=this.updateClientName;
	    		this.$parent.clients[this.$parent.clientIndex].client_phone=this.updateClientPhone;
	    		this.$parent.clients[this.$parent.clientIndex].client_email=this.updateClientEmail;
	    		this.$parent.$parent.forceRerender();
	    		$('#updateClientModal').modal('close');
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
    			const PHONE_REGEXP = /^[0-9]*$/gm;

    			if(this.updateClientPhone ==null || this.updateClientPhone.length == 0){
    				this.validClientPhone = false;
	    			this.invalidClientPhone = false;
    			}
    			else if(!PHONE_REGEXP.test(this.updateClientPhone) || this.updateClientPhone.length < 10){
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

    			if(this.updateClientEmail ==null || this.updateClientEmail.length == 0){
    				this.validClientEmail = false;
	    			this.invalidClientEmail = false;
    			}
    			else if(!MAIL_REGEXP.test(this.updateClientEmail)){
    				this.validClientEmail = false;
	    			this.invalidClientEmail = true;
    				$('.client_email_helper').attr('data-error', 'Correo electrónico no válido.');
    			}
    			else{
    				this.validClientEmail = true;
	    			this.invalidClientEmail = false;
    			}
    		},

    		resetUpdateClientInputs: function(e) {
    			this.validClientName= false;
    			this.invalidClientName=false;
    			this.validClientPhone=false;
    			this.invalidClientPhone=false;
    			this.validClientEmail=false;
    			this.invalidClientEmail=false;
    		},

    		openDeleteClientModal: function(e) {
    			$('#deleteClientModal').modal({
    				dismissible: false
    			});
    			$('#deleteClientModal').modal('open');
    		}
	    },
	}
</script>