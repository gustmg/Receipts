<template>
	<div id="newDeviceModal" class="modal newDeviceModal">
		<div class="modal-content">
			<h5>Nuevo equipo</h5><br>
			<div class="row">
				<form id="newDeviceForm" class="col s12 no-padding" method="POST" action="devices">
					<input type="hidden" name="_token" :value="csrf">
					<div class="row">
						<div class="input-field col s12 m8 no-vertical-margin">
							<input placeholder="" id="device_name" type="text" v-model="newDeviceName" v-on:blur="validateDeviceName" v-bind:class="{'valid': validDeviceName, 'invalid': invalidDeviceName}" data-length="50" maxlength="50" required>
							<label for="device_name" class="valign-wrapper"><i class="material-icons">computer</i>&nbsp;&nbsp;Nombre del equipo*</label>
							<span class="helper-text device_name_helper" data-success="Nombre validado."></span><br>
				        </div>
				        <div class="input-field col s12 m4 no-vertical-margin">
				        	<input placeholder="" id="device_serial_number" type="tel" v-model="newDeviceSerialNumber" v-bind:class="{'valid': validDeviceSerialNumber, 'invalid': invalidDeviceSerialNumber}" data-length="4" minlength="4" maxlength="4">
							<label for="device_serial_number" class="valign-wrapper"><i class="material-icons">local_offer</i>&nbsp;&nbsp;Número de serie</label>
							<span class="helper-text device_serial_number_helper" data-success="Número de serie validado."></span>
				        </div>
				        <div class="input-field col s12 no-vertical-margin">
							<input placeholder="" id="device_trouble_description" type="email" v-model="newDeviceTroubleDescription" v-on:blur="validateDeviceTroubleDescription" v-bind:class="{'valid': validDeviceTroubleDescription, 'invalid': invalidDeviceTroubleDescription}" data-length="40" maxlength="40">
							<label for="device_trouble_description" class="valign-wrapper"><i class="material-icons">description</i>&nbsp;&nbsp;Descripción del problema</label>
							<span class="helper-text device_trouble_description_helper" data-success="Descripción de problema validado."></span>
				        </div>
			        </div>
				</form>
				<div class="col-m12">
					<span><b>ACCESORIOS</b></span>
					<div class="row">
						<new-accessory-button-component></new-accessory-button-component>
						<div class="col s12 m4" v-show="accessories.length > 0" v-for="(accessory, index) in accessories">
							<div class="card">
								<div class="card-content">
									<span class="card-title"><b>{{accessory.accessory_name}}</b></span>
									<span><b>SN:</b> {{accessory.accessory_serial_number}}</span><br>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button v-on:click="resetNewDeviceInputs" class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></button>
			<button v-on:click="addDevice" type="submit" v-bind:class="{'disabled': validateForm}" class="modal-action btn waves-effect submit_button">
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
	        console.log('New device modal mounted.');
		},

		props:{
			accessories: {
				type: Array
			},
		},

	    data(){
	    	return {
				csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
				newDevice:null,
	    		newDeviceName: null,
	    		newDeviceSerialNumber: null,
	    		newDeviceTroubleDescription: null,
	    		validDeviceName: false,
	    		invalidDeviceName: false,
	    		validDeviceSerialNumber: false,
	    		invalidDeviceSerialNumber: false,
	    		validDeviceTroubleDescription: false,
				invalidDeviceTroubleDescription: false
	    	}
	    },

	    computed: {
	    	validateForm: function(e) {
	    		if(!this.validDeviceName || !this.validDeviceTroubleDescription){
	    			return true;
	    		}
	    	}
	    },

	    methods: {
			addDevice: function() {
				this.newDevice = {
					device_id: '',
					device_name: this.newDeviceName,
					device_serial_number: this.newDeviceSerialNumber,
					device_trouble_description: this.newDeviceTroubleDescription,
					device_accessories: this.accessories
				};

				this.$parent.devices.push(this.newDevice);
				this.$parent.forceRerender();
				this.resetNewDeviceInputs();
				$('#newDeviceModal').modal('close');
			},

	    	saveDevice: function(){
	    		var newDevice = {
		    		device_id: '',
		    		device_name: this.newDeviceName,
		    		device_serial_number: this.newDeviceSerialNumber,
					device_trouble_description: this.newDeviceTroubleDescription,
		    	};

	    		axios.post('http://localhost:8000/devices',{
	    			device_name: this.newDeviceName,
	    			device_serial_number: this.newDeviceSerialNumber,
	    			device_trouble_description: this.newDeviceTroubleDescription
	    		})
	    		.then((res)=>{newDevice.device_id = res.data.device_id})
	    		.catch(function(err){
	    			console.log(err);
	    		});

	    		this.$parent.devices.push(newDevice);
	    		this.$parent.forceRerender();
	    		$('#newDeviceModal').modal('close');
	    	},

	    	validateDeviceName: function(e) {
	    		if(!this.newDeviceName){
	    			this.validDeviceName = false;
	    			this.invalidDeviceName = true;
	    			$('.device_name_helper').attr('data-error', 'Este campo no puede quedar vacío.');
	    		}
	    		else{
	    			this.validDeviceName = true;
	    			this.invalidDeviceName = false;
	    		}
    		},

    		validateDeviceTroubleDescription: function(e) {
    			if(!this.newDeviceTroubleDescription){
    				this.validDeviceTroubleDescription = false;
					this.invalidDeviceTroubleDescription = true;
					$('.device_trouble_description_helper').attr('data-error', 'Este campo no puede quedar vacío.');
    			}
    			else{
    				this.validDeviceTroubleDescription = true;
	    			this.invalidDeviceTroubleDescription = false;
    			}
    		},

    		resetNewDeviceInputs: function (e) {
    			this.newDeviceName=null;
    			this.newDeviceSerialNumber=null;
    			this.newDeviceTroubleDescription=null;
    			this.validDeviceName= false;
    			this.invalidDeviceName=false;
    			this.validDeviceSerialNumber=false;
    			this.invalidDeviceSerialNumber=false;
    			this.validDeviceTroubleDescription=false;
				this.invalidDeviceTroubleDescription=false;
				
				this.$parent.accessories=[];
    		}
	    }
	}
</script>