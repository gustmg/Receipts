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
									<input placeholder=""  id="receipt_client_id" type="text" disabled>
									<label for="client_id">No. de cliente</label>
								</div>
								<div class="input-field col s8">
									<input placeholder="" v-model="receiptClientName" id="receipt_client_name" type="text" :disabled="newClientToggle == false">
									<label for="client_name">Nombre</label>
								</div>
								<div class="input-field col s8">
									<input placeholder="" id="receipt_client_email" type="email" :disabled="newClientToggle == false">
									<label for="client_email">E-mail</label>
								</div>
								<div class="input-field col s4">
									<input placeholder="" id="receipt_client_phone" type="tel" :disabled="newClientToggle == false">
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

			receiptClientName: {
				type: String
			},

			lastClientId: {
				type: Number
			}
		},

	    data(){
	    	return {
				csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
				newClientToggle: false
	    	}
	    },

		watch: {
			receiptClientName: function() {
				console.log(this.receiptClientName);
			}
		},

	    computed: {
	    	validateForm: function(e) {
	    		if(this.devices.length==0){
	    			return true;
				}
	    	}
	    },

	    methods: {
	    	saveReceipt: function(){
				
	    		// var newReceipt = {
		    	// 	receipt_id: '',
		    	// 	receipt_name: this.newReceiptName,
		    	// 	receipt_phone: this.newReceiptPhone,
		    	// 	receipt_email: this.newReceiptEmail
		    	// };

	    		// axios.post('http://localhost:8000/receipts',{
	    		// 	receipt_name: this.newReceiptName,
	    		// 	receipt_phone: this.newReceiptPhone,
	    		// 	receipt_email: this.newReceiptEmail
	    		// })
	    		// .then((res)=>{newReceipt.receipt_id = res.data.receipt_id})
	    		// .catch(function(err){
	    		// 	console.log(err);
	    		// });

	    		// this.$parent.receipts.push(newReceipt);
	    		// this.$parent.forceRerender();
	    		// $('#newReceiptModal').modal('close');
	    	},

	    	validateReceiptName: function(e) {
	    		if(!this.newReceiptName){
	    			this.validReceiptName = false;
	    			this.invalidReceiptName = true;
	    			$('.receipt_name_helper').attr('data-error', 'Este campo no puede quedar vacío.');
	    		}
	    		else{
	    			this.validReceiptName = true;
	    			this.invalidReceiptName = false;
	    		}
    		},

    		validateReceiptPhone: function(e) {
    			const PHONE_REGEXP = /^[0-9]*$/gm;

    			if(this.newReceiptPhone ==null || this.newReceiptPhone.length == 0){
    				this.validReceiptPhone = false;
	    			this.invalidReceiptPhone = false;
    			}
    			else if(!PHONE_REGEXP.test(this.newReceiptPhone) || this.newReceiptPhone.length < 10){
    				this.validReceiptPhone = false;
	    			this.invalidReceiptPhone = true;
    				$('.receipt_phone_helper').attr('data-error', 'Número telefónico no válido.');
    			}
    			else{
    				this.validReceiptPhone = true;
	    			this.invalidReceiptPhone = false;
    			}
    		},

    		validateReceiptEmail: function(e) {
    			const MAIL_REGEXP = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    			if(this.newReceiptEmail ==null || this.newReceiptEmail.length == 0){
    				this.validReceiptEmail = false;
	    			this.invalidReceiptEmail = false;
    			}
    			else if(!MAIL_REGEXP.test(this.newReceiptEmail)){
    				this.validReceiptEmail = false;
	    			this.invalidReceiptEmail = true;
    				$('.receipt_email_helper').attr('data-error', 'Correo electrónico no válido.');
    			}
    			else{
    				this.validReceiptEmail = true;
	    			this.invalidReceiptEmail = false;
    			}
    		},

    		resetNewReceiptInputs: function (e) {
    			this.newReceiptName=null;
    			this.newReceiptPhone=null;
    			this.newReceiptEmail=null;
    			this.validReceiptName= false;
    			this.invalidReceiptName=false;
    			this.validReceiptPhone=false;
    			this.invalidReceiptPhone=false;
    			this.validReceiptEmail=false;
    			this.invalidReceiptEmail=false;
			},
			
			showClientsList: function () {
				$('#clientsCompactListModal').modal({
					dismissible: false
				});
				$('#clientsCompactListModal').modal('open');
			},

			newClientToggleHandler: function () {
				if(!this.newClientToggle){
					this.$parent.receiptClient={
						client_id:this.lastClientId,
						client_name: null,
						client_email: null,
						client_phone: null
					};
				}
				else{
					
				}
			},
	    }
	}
</script>