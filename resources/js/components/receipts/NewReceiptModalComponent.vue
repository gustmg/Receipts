<template>
	<div id="newReceiptModal" class="modal newReceiptModal">
		<div class="modal-content">
			<h5>Nueva recepción</h5><br>
			<div class="row" style="margin-bottom:0 !important;">
				<div class="col m5">
					<div class="row">
						<div class="col m12">
							<span><b>DATOS DE RECEPCIÓN</b></span>
						</div>
						<div class="col s5">
							<span><b>Folio</b></span>
						</div>
						<div class="col s7">
							<span>{{receiptId}}</span>
						</div>
						<div class="col s5">
							<span><b>Fecha</b></span>
						</div>
						<div class="col s7">
							<span>{{date}}</span>
						</div>
						<div class="col s5">
							<span><b>Creada por</b></span>
						</div>
						<div class="col s7">
							<span>{{worker.name}}</span>
						</div>
					</div>
				</div>
				<div class="col m7">
					<div class="row">
						<div class="col m12">
							<span><b>DATOS DEL CLIENTE</b></span>
						</div>
						<div class="col m12">
							<div class="switch">
								<label>
									<b>¿Cliente nuevo?</b>
									<input type="checkbox" v-model="newClientToggle" v-on:click="newClientToggleHandler">
									<span class="lever"></span>
								</label>
								<button v-on:click="showClientsList" class="mdc-button mdc-button--outlined" :disabled="newClientToggle == true">Buscar cliente</button>
							</div><br>
						</div>
						<div class="col m12">
							<form class="row">
								<div class="input-field col s4">
									<input placeholder="" :value="clientId" @input="$emit('update:clientId', $event.target.value)" id="receipt_client_id" type="text" disabled>
									<label for="client_id">No. de cliente</label>
								</div>
								<div class="input-field col s8">
									<input placeholder="" :value="clientName" @input="$emit('update:clientName', $event.target.value)" id="receipt_client_name" type="text" :disabled="newClientToggle == false" v-on:blur="validateReceiptClientName" v-bind:class="{'valid': validClientName, 'invalid': invalidClientName}" data-length="50" maxlength="50" required>
									<label for="client_name">Nombre</label>
								</div>
								<div class="input-field col s8">
									<input placeholder="" :value="clientEmail" @input="$emit('update:clientEmail', $event.target.value)" id="receipt_client_email" type="email" :disabled="newClientToggle == false" v-on:blur="validateReceiptClientEmail" v-bind:class="{'valid': validClientEmail, 'invalid': invalidClientEmail}" data-length="40" maxlength="40">
									<label for="client_email">E-mail</label>
								</div>
								<div class="input-field col s4">
									<input placeholder="" :value="clientPhone" @input="$emit('update:clientPhone', $event.target.value)" id="receipt_client_phone" type="tel" :disabled="newClientToggle == false" v-on:blur="validateReceiptClientPhone" v-bind:class="{'valid': validClientPhone, 'invalid': invalidClientPhone}" data-length="10" minlength="10" maxlength="10">
									<label for="client_phone">Teléfono</label>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col m12">
					<span><b>EQUIPOS</b></span>
					<div class="row">
						<new-device-button-component></new-device-button-component>
						<div class="col s12 m4" v-show="devices.length > 0" v-for="(device, index) in devices">
							<div v-on:click="updateDevice(device, index)" class="card hoverable hoverable-card selectable">
								<div class="card">
									<div class="card-content">
										<span class="card-title"><b>{{device.device_name}}</b></span>
										<span><b>SN:</b> {{device.device_serial_number}}</span><br>
										<span><b>Descripción:</b> {{device.device_trouble_description}}</span><br>
										<span><b>Accesorios:</b></span>
										<ul class="collection" v-show="device.device_accessories.length > 0">
											<li class="collection-item" v-for="(accessory, index_accessory) in device.device_accessories">{{accessory.accessory_name}}</li>
										</ul>
										<!-- <span><b>Proceso:</b></span><br>
										<div class="progress">
											<div class="determinate" style="width: 70%"></div>
										</div>
										<h5 class="center-align">70%</h5>
										<div class="full-width center-align">
											<span>Diagnóstico post-reparación</span>
										</div> -->
									</div>
									<!-- <div class="card-action">
										<a href="#">This is a link</a>
										<a href="#">This is a link</a>
									</div> -->
								</div>
							</div>
						</div>
						<div>
							<h5 v-show="devices.length == 0" class="center grey-text">No hay equipos registrados.</h5>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button v-on:click="resetReceipt" class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></button>
			<button v-on:click="saveReceipt" type="submit" v-bind:class="{'disabled': validateForm}" class="modal-action btn waves-effect submit_button">
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
	.modal-content{
		padding-bottom: 0 !important;
	}
	.newReceiptModal{
		width:75% !important;
	}
</style>
<script>
	import EventBus from '../../event-bus';
	export default {
	    mounted() {
			console.log('New receipt modal mounted.');
		},
		
		props:{
			devices: {
				type: Array
			},

			clientId: {
				type: Number
			},

			clientName: {
				type: String
			},

			clientEmail: {
				type: String
			},

			clientPhone: {
				type: String
			},

			lastClientId: {
				type: Number
			},

			receiptId: {
				type: Number
			},

			worker: {
				type: Object
			}
		},

	    data(){
	    	return {
				csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
				validClientName: false,
				invalidClientName: false,
				validClientPhone: false,
				invalidClientPhone: false,
				validClientEmail: false,
				invalidClientEmail: false,
				newClientToggle: false,
				printReceiptId: 0
	    	}
		},

	    computed: {
	    	validateForm: function(e) {
				if(this.newClientToggle){
					if(this.devices.length==0 || !this.validClientName || this.invalidClientPhone || this.invalidClientEmail){
						return true;
					}
				}
				else{
					if(this.devices.length==0 || this.clientName==null){
						return true;
					}
				}
			},

			date: function() {
				var d = new Date();

				switch (d.getMonth()) {
					case 0:
						return "Enero"+d.getDate()+", "+d.getFullYear();
					case 1:
						return "Febrero"+d.getDate()+", "+d.getFullYear();
					case 2:
						return "Marzo"+d.getDate()+", "+d.getFullYear();
					case 3:
						return "Abril"+d.getDate()+", "+d.getFullYear();
					case 4:
						return "Mayo"+d.getDate()+", "+d.getFullYear();
					case 5:
						return "Junio"+d.getDate()+", "+d.getFullYear();
					case 6:
						return "Julio "+d.getDate()+", "+d.getFullYear();
					case 7:
						return "Agosto"+d.getDate()+", "+d.getFullYear();
					case 8:
						return "Septiembre"+d.getDate()+", "+d.getFullYear();
					case 9:
						return "Octubre"+d.getDate()+", "+d.getFullYear();
					case 10:
						return "Noviembre"+d.getDate()+", "+d.getFullYear();
					case 11:
						return "Diciembre"+d.getDate()+", "+d.getFullYear();
					default:
						break;
				}
			}
	    },

	    methods: {
	    	saveReceipt: function(){
				var newReceipt = {
					receipt_id : 0,
					receipt_date : null,
					receipt_worker_id : 0,
					receipt_client_id : 0

				};

				if(this.newClientToggle){
					this.saveClient();
				}

	    		axios.post('http://localhost:8000/receipts',{
	    			receipt_client_id: this.clientId,
	    		})
	    		.then((res)=>{
					// this.printReceiptId=res.data.receipt_id;
					// newReceipt.receipt_date = res.data.receipt_date;
					// newReceipt.receipt_worker_id = res.data.receipt_worker_id;
					// newReceipt.receipt_client_id = res.data.receipt_client_id;
					this.saveDevices(res.data.receipt_id);
					setTimeout(function(){
						axios.post('http://localhost:8000/print_receipt',{
							receipt_id: res.data.receipt_id,
						})
						.then((res)=>{
							// console.log(res.data.sale);
							// location.reload();
						})
						.catch(function(err){
							console.log(err.response);
						});
					},3000);
				})
	    		.catch(function(err){
	    			console.log(err);
	    		});
	    		// this.$parent.receipts.push(newReceipt);
	    		// this.$parent.forceRerender();
				$('#newReceiptModal').modal('close');
			},

			saveClient: function() {
				axios.post('http://localhost:8000/clients',{
					client_name: this.clientName,
					client_phone: this.clientPhone,
					client_email: this.clientEmail
				})
				.then((res)=>{
					console.log("Cliente registrado");
				})
				.catch(function(err){
					console.log(err);
				});
			},

			saveDevices: function (receipt_id) {
				this.devices.forEach(device => {
					axios.post('http://localhost:8000/devices',{
						device_name: device.device_name,
						device_serial_number: device.device_serial_number,
						device_trouble_description: device.device_trouble_description,
						device_receipt_id: receipt_id
					})
					.then((res)=>{
						// console.log("Equipo registrado");
						this.saveAccessories(res.data.device_id, device.device_accessories);
					})
					.catch(function(err){
						console.log(err);
					});
				});
			},

			saveAccessories: function (device_id, accessories) {
				accessories.forEach(accessory => {
					axios.post('http://localhost:8000/accessories',{
						accessory_name: accessory.accessory_name,
						accessory_serial_number: accessory.accessory_serial_number,
						accessory_device_id: device_id
					})
					.then((res)=>{
						console.log("Accessorios de equipo registrados");
					})
					.catch(function(err){
						console.log(err);
					});
				});
			},

	    	validateReceiptClientName: function(e) {
	    		if(!this.clientName){
	    			this.validClientName = false;
	    			this.invalidClientName = true;
	    			$('.receipt_name_helper').attr('data-error', 'Este campo no puede quedar vacío.');
	    		}
	    		else{
	    			this.validClientName = true;
	    			this.invalidClientName = false;
	    		}
    		},

    		validateReceiptClientPhone: function(e) {
    			const PHONE_REGEXP = /^[0-9]*$/gm;

    			if(this.clientPhone ==null || this.clientPhone.length == 0){
    				this.validClientPhone = false;
	    			this.invalidClientPhone = false;
    			}
    			else if(!PHONE_REGEXP.test(this.clientPhone) || this.clientPhone.length < 10){
    				this.validClientPhone = false;
	    			this.invalidClientPhone = true;
    				$('.receipt_phone_helper').attr('data-error', 'Número telefónico no válido.');
    			}
    			else{
    				this.validClientPhone = true;
	    			this.invalidClientPhone = false;
    			}
    		},

    		validateReceiptClientEmail: function(e) {
    			const MAIL_REGEXP = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    			if(this.clientEmail ==null || this.clientEmail.length == 0){
    				this.validClientEmail = false;
	    			this.invalidClientEmail = false;
    			}
    			else if(!MAIL_REGEXP.test(this.clientEmail)){
    				this.validClientEmail = false;
	    			this.invalidClientEmail = true;
    				$('.receipt_email_helper').attr('data-error', 'Correo electrónico no válido.');
    			}
    			else{
    				this.validClientEmail = true;
	    			this.invalidClientEmail = false;
    			}
    		},

    		resetReceipt: function (e) {
				this.$emit('update:clientId', 0);
				this.$emit('update:clientName', null);
				this.$emit('update:clientEmail', null);
				this.$emit('update:clientPhone', null);

				this.$parent.resetDevices();

    			this.validClientName= false;
    			this.invalidClientName=false;
    			this.validClientPhone=false;
    			this.invalidClientPhone=false;
    			this.validClientEmail=false;
    			this.invalidClientEmail=false;
			},
			
			showClientsList: function () {
				$('#clientsCompactListModal').modal({
					dismissible: false
				});
				$('#clientsCompactListModal').modal('open');
			},

			newClientToggleHandler: function () {
				if(!this.newClientToggle){
					this.$emit('update:clientId', this.lastClientId);
					this.$emit('update:clientName', null);
					this.$emit('update:clientEmail', null);
					this.$emit('update:clientPhone', null);
				}
				else{
					this.$emit('update:clientId', 0);
					this.$emit('update:clientName', null);
					this.$emit('update:clientEmail', null);
					this.$emit('update:clientPhone', null);
				}
				this.validClientName= false;
				this.invalidClientName=false;
				this.validClientPhone=false;
				this.invalidClientPhone=false;
				this.validClientEmail=false;
				this.invalidClientEmail=false;
			},
	    }
	}
</script>