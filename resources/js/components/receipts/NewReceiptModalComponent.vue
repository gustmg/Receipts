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
							<span>0001</span>
						</div>
						<div class="col s5">
							<span><b>Fecha</b></span>
						</div>
						<div class="col s7">
							<span>Junio 13, 2019</span>
						</div>
						<div class="col s5">
							<span><b>Creada por</b></span>
						</div>
						<div class="col s7">
							<span>Gustavo</span>
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
								<button v-on:click="showClientsList" class="btn waves-effect waves-light" :disabled="newClientToggle == true">Buscar cliente</button>
							</div><br>
						</div>
						<div class="col m12">
							<form class="row">
								<div class="input-field col s4">
									<input placeholder="" v-model="newReceiptClientId" id="receipt_client_id" type="text" disabled>
									<label for="client_id">No. de cliente</label>
								</div>
								<div class="input-field col s8">
									<input placeholder="" v-model="newReceiptClientName" id="receipt_client_name" type="text" :disabled="newClientToggle == false" v-on:blur="validateReceiptClientName" v-bind:class="{'valid': validNewReceiptClientName, 'invalid': invalidNewReceiptClientName}" data-length="50" maxlength="50" required>
									<label for="client_name">Nombre</label>
								</div>
								<div class="input-field col s8">
									<input placeholder="" v-model="newReceiptClientEmail" id="receipt_client_email" type="email" :disabled="newClientToggle == false" v-on:blur="validateReceiptClientEmail" v-bind:class="{'valid': validNewReceiptClientEmail, 'invalid': invalidNewReceiptClientEmail}" data-length="40" maxlength="40">
									<label for="client_email">E-mail</label>
								</div>
								<div class="input-field col s4">
									<input placeholder="" v-model="newReceiptClientPhone" id="receipt_client_phone" type="tel" :disabled="newClientToggle == false" v-on:blur="validateReceiptClientPhone" v-bind:class="{'valid': validNewReceiptClientPhone, 'invalid': invalidNewReceiptClientPhone}" data-length="10" minlength="10" maxlength="10">
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
			<button v-on:click="resetNewReceiptInputs" class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></button>
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
	export default {
	    mounted() {
	        console.log('New receipt modal mounted.');
		},
		
		props:{
			devices: {
				type: Array
			},

			receiptClientId: {
				type: Number
			},

			receiptClientName: {
				type: String
			},

			receiptClientEmail: {
				type: String
			},

			receiptClientPhone: {
				type: String
			},

			lastClientId: {
				type: Number
			}
		},

	    data(){
	    	return {
				csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
				newReceiptClientId:0,
				newReceiptClientName:null,
				newReceiptClientEmail:null,
				newReceiptClientPhone:null,

				validNewReceiptClientName: false,
				invalidNewReceiptClientName: false,
				validNewReceiptClientPhone: false,
				invalidNewReceiptClientPhone: false,
				validNewReceiptClientEmail: false,
				invalidNewReceiptClientEmail: false,
				newClientToggle: false
	    	}
		},
		
		watch: {
			receiptClientId: function() {
				this.newReceiptClientId=this.receiptClientId;
			},

			receiptClientName: function() {
				this.newReceiptClientName=this.receiptClientName;
			},

			receiptClientEmail: function() {
				this.newReceiptClientEmail=this.receiptClientEmail;
			},

			receiptClientPhone: function() {
				this.newReceiptClientPhone=this.receiptClientPhone;
			}
		},

	    computed: {
	    	validateForm: function(e) {
	    		if(this.devices.length==0 || !this.validNewReceiptClientName || this.invalidNewReceiptClientPhone || this.invalidNewReceiptClientEmail){
	    			return true;
				}
			}
	    },

	    methods: {
	    	saveReceipt: function(){
				
	    		// var newReceipt = {
		    	// 	receipt_id: '',
		    	// 	receipt_name: this.newReceiptName,
		    	// 	receipt_phone: this.receiptClientPhone,
		    	// 	receipt_email: this.receiptClientEmail
		    	// };

	    		// axios.post('http://localhost:8000/receipts',{
	    		// 	receipt_name: this.newReceiptName,
	    		// 	receipt_phone: this.receiptClientPhone,
	    		// 	receipt_email: this.receiptClientEmail
	    		// })
	    		// .then((res)=>{newReceipt.receipt_id = res.data.receipt_id})
	    		// .catch(function(err){
	    		// 	console.log(err);
	    		// });

	    		// this.$parent.receipts.push(newReceipt);
	    		// this.$parent.forceRerender();
	    		// $('#newReceiptModal').modal('close');
	    	},

	    	validateReceiptClientName: function(e) {
	    		if(!this.newReceiptClientName){
	    			this.validNewReceiptClientName = false;
	    			this.invalidNewReceiptClientName = true;
	    			$('.receipt_name_helper').attr('data-error', 'Este campo no puede quedar vacío.');
	    		}
	    		else{
	    			this.validNewReceiptClientName = true;
	    			this.invalidNewReceiptClientName = false;
	    		}
    		},

    		validateReceiptClientPhone: function(e) {
    			const PHONE_REGEXP = /^[0-9]*$/gm;

    			if(this.newReceiptClientPhone ==null || this.newReceiptClientPhone.length == 0){
    				this.validNewReceiptClientPhone = false;
	    			this.invalidNewReceiptClientPhone = false;
    			}
    			else if(!PHONE_REGEXP.test(this.newReceiptClientPhone) || this.newReceiptClientPhone.length < 10){
    				this.validNewReceiptClientPhone = false;
	    			this.invalidNewReceiptClientPhone = true;
    				$('.receipt_phone_helper').attr('data-error', 'Número telefónico no válido.');
    			}
    			else{
    				this.validNewReceiptClientPhone = true;
	    			this.invalidNewReceiptClientPhone = false;
    			}
    		},

    		validateReceiptClientEmail: function(e) {
    			const MAIL_REGEXP = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    			if(this.newReceiptClientEmail ==null || this.newReceiptClientEmail.length == 0){
    				this.validNewReceiptClientEmail = false;
	    			this.invalidNewReceiptClientEmail = false;
    			}
    			else if(!MAIL_REGEXP.test(this.newReceiptClientEmail)){
    				this.validNewReceiptClientEmail = false;
	    			this.invalidNewReceiptClientEmail = true;
    				$('.receipt_email_helper').attr('data-error', 'Correo electrónico no válido.');
    			}
    			else{
    				this.validNewReceiptClientEmail = true;
	    			this.invalidNewReceiptClientEmail = false;
    			}
    		},

    		resetNewReceiptInputs: function (e) {
    			this.validNewReceiptClientName= false;
    			this.invalidNewReceiptClientName=false;
    			this.validNewReceiptClientPhone=false;
    			this.invalidNewReceiptClientPhone=false;
    			this.validNewReceiptClientEmail=false;
    			this.invalidNewReceiptClientEmail=false;
			},
			
			showClientsList: function () {
				$('#clientsCompactListModal').modal({
					dismissible: false
				});
				$('#clientsCompactListModal').modal('open');
			},

			newClientToggleHandler: function () {
				if(!this.newClientToggle){
					this.newReceiptClientId=this.lastClientId;
					this.newReceiptClientName= null;
					this.newReceiptClientEmail= null;
					this.newReceiptClientPhone= null;
				}
				else{
					this.newReceiptClientId=0;
					this.newReceiptClientName= null;
					this.newReceiptClientEmail= null;
					this.newReceiptClientPhone= null;
				}
				this.validNewReceiptClientName= false;
				this.invalidNewReceiptClientName=false;
				this.validNewReceiptClientPhone=false;
				this.invalidNewReceiptClientPhone=false;
				this.validNewReceiptClientEmail=false;
				this.invalidNewReceiptClientEmail=false;
			},
	    }
	}
</script>