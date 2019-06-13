<template>
	<div id="updateServiceModal" class="modal updateServiceModal">
		<div class="modal-content">
			<h5>Editar servicio</h5><br>
			<div class="row">
				<form id="updateServiceForm" class="col s12 no-padding" method="POST" action="services">
					<input type="hidden" name="_token" :value="csrf">
					<div class="row">
						<div class="input-field col s12 m12 no-vertical-margin">
							<input placeholder="" v-model="updateServiceName" @input="emitServiceName" v-on:blur="validateServiceName" v-bind:class="{'valid': validServiceName, 'invalid': invalidServiceName}" id="update_service_name" type="text" data-length="50" maxlength="50" required>
							<label for="update_service_name" class="valign-wrapper"><i class="material-icons">layers</i>&nbsp;&nbsp;Servicio *</label>
							<span class="helper-text service_name_helper" data-success="Nombre validado."></span>
				        </div>
				        <div class="input-field col s12 m6 no-vertical-margin">
							<input placeholder="" v-model="updateServiceDescription" @input="emitServiceDescription" v-on:blur="validateServiceDescription" v-bind:class="{'valid': validServiceDescription, 'invalid': invalidServiceDescription}" id="update_service_description" type="text" data-length="50" maxlength="50" required>
							<label for="update_service_description" class="valign-wrapper"><i class="material-icons">settings</i>&nbsp;&nbsp;Descripción *</label>
							<span class="helper-text service_description_helper" data-success="Descripción del servicio validada."></span>
				        </div>
			        </div>
				</form>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#" class="left delete-button" v-on:click="openDeleteServiceModal"><i class="material-icons black-text">delete</i></a>
			<button v-on:click="resetUpdateServiceInputs" class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></button>
			<button v-on:click="updateService" type="submit" class="modal-action btn waves-effect submit_button" >
				<b>Guardar</b>
			</button>
		</div>
		<delete-service-modal-component :service-id="serviceId.toString()"></delete-service-modal-component>
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
			serviceId: String,
			serviceName: String,
			serviceDescription: String
		},

	    mounted() {
	        console.log('Update Service Modal Component Mounted');
	    },

	    data(){
	    	return {
	    		csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
	    		updateServiceName:'',
	    		updateServiceDescription:'',
	    		validServiceName: false,
	    		invalidServiceName: false,
	    		activeServiceName: false,
	    		validServiceDescription: false,
	    		invalidServiceDescription: false
	    	}
	    },

	    watch: {
            serviceName(newVal) {
                this.updateServiceName = newVal;
            },
            serviceDescription(newVal) {
                this.updateServiceDescription = newVal;
            }
        },


	    methods: {
	    	emitServiceName(newInputValue) {
	            this.$emit('service-name', newInputValue);
	        },

	        emitServiceDescription(newInputValue) {
	            this.$emit('service-description', newInputValue);
	        },

	    	updateService: function(){
	    		axios.put('http://localhost:8000/services/'+this.serviceId,{
	    			service_name: this.updateServiceName,
	    			service_description: this.updateServiceDescription
	    		})
	    		.then(function(res){
	    			console.log(res);
	    		})
	    		.catch(function(err){
	    			console.log(err.response);
	    		});
	    		this.$parent.services[this.$parent.serviceIndex].service_name=this.updateServiceName;
	    		this.$parent.services[this.$parent.serviceIndex].service_description=this.updateServiceDescription;
	    		this.$parent.$parent.forceRerender();
	    		$('#updateServiceModal').modal('close');
	    	},

	    	validateServiceName: function(e) {
	    		if(!this.updateServiceName){
	    			this.validServiceName = false;
	    			this.invalidServiceName = true;
	    			$('.service_name_helper').attr('data-error', 'Este campo no puede quedar vacío.');
	    		}
	    		else{
	    			this.validServiceName = true;
	    			this.invalidServiceName = false;
	    		}
    		},

    		validateServiceDescription: function(e) {
	    		if(!this.updateServiceDescription){
	    			this.validServiceDescription = false;
	    			this.invalidServiceDescription = true;
	    			$('.service_description_helper').attr('data-error', 'Este campo no puede quedar vacío.');
	    		}
	    		else{
	    			this.validServiceDescription = true;
	    			this.invalidServiceDescription = false;
	    		}
    		},

    		resetUpdateServiceInputs: function(e) {
    			this.validServiceName= false;
    			this.invalidServiceName=false;
    			this.validServiceDescription=false;
    			this.invalidServiceDescription=false;
    		},

    		openDeleteServiceModal: function(e) {
    			$('#deleteServiceModal').modal({
    				dismissible: false
    			});
    			$('#deleteServiceModal').modal('open');
    		}
	    },
	}
</script>