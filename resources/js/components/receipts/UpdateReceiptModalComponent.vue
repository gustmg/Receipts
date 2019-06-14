<template>
	<div id="updateReceiptModal" class="modal updateReceiptModal">
		<div class="modal-content">
			<h5>Editar receipte</h5><br>
			<div class="row">
				<form id="updateReceiptForm" class="col s12 no-padding" method="POST" action="receipts">
					<input type="hidden" name="_token" :value="csrf">
					<div class="row">
						<div class="input-field col s12 m12 no-vertical-margin">
							<input placeholder="" id="update_receipt_name" type="text" @input="emitReceiptName" v-model="updateReceiptName" v-on:blur="validateReceiptName" v-bind:class="{'valid': validReceiptName, 'invalid': invalidReceiptName}" data-length="50" maxlength="50" required>
							<label for="update_receipt_name" class="valign-wrapper"><i class="material-icons">person</i>&nbsp;&nbsp;Nombre *</label>
							<span class="helper-text receipt_name_helper" data-success="Nombre validado."></span><br>
				        </div>
				        <div class="input-field col s12 m4 no-vertical-margin">
							<input placeholder="" id="update_receipt_phone" type="tel" v-model="updateReceiptPhone" v-on:blur="validateReceiptPhone" v-bind:class="{'valid': validReceiptPhone, 'invalid': invalidReceiptPhone}" data-length="10" minlength="10" maxlength="10">
							<label for="update_receipt_phone" class="valign-wrapper"><i class="material-icons">phone</i>&nbsp;&nbsp;Teléfono</label>
							<span class="helper-text receipt_phone_helper" data-success="Teléfono validado."></span>
				        </div>
				        <div class="input-field col s12 m8 no-vertical-margin">
							<input placeholder="" id="update_receipt_email" type="email" v-model="updateReceiptEmail" v-on:blur="validateReceiptEmail" v-bind:class="{'valid': validReceiptEmail, 'invalid': invalidReceiptEmail}" data-length="40" maxlength="40">
							<label for="update_receipt_email" class="valign-wrapper"><i class="material-icons">email</i>&nbsp;&nbsp;Correo electrónico</label>
							<span class="helper-text receipt_email_helper" data-success="Correo validado."></span>
				        </div>
			        </div>
				</form>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#" class="left delete-button" v-on:click="openDeleteReceiptModal"><i class="material-icons black-text">delete</i></a>
			<button v-on:click="resetUpdateReceiptInputs" class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></button>
			<button v-on:click="updateReceipt" type="submit" class="modal-action btn waves-effect submit_button" >
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
			receiptId: String,
			receiptName: String,
			receiptPhone: String,
			receiptEmail: String
		},

	    mounted() {
	        console.log('Update Receipt Modal Component Mounted');
	    },

	    data(){
	    	return {
	    		csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
	    		updateReceiptName:'',
	    		updateReceiptPhone:'',
	    		updateReceiptEmail:'',
	    		validReceiptName: false,
	    		invalidReceiptName: false,
	    		activeReceiptName: false,
	    		validReceiptPhone: false,
	    		invalidReceiptPhone: false,
	    		validReceiptEmail: false,
	    		invalidReceiptEmail: false
	    	}
	    },

	    watch: {
            receiptName(newVal) {
                this.updateReceiptName = newVal;
            },
            receiptPhone(newVal) {
                this.updateReceiptPhone = newVal;
            },
            receiptEmail(newVal) {
                this.updateReceiptEmail = newVal;
            }
        },


	    methods: {
	    	emitReceiptName(newInputValue) {
	            this.$emit('receipt-name', newInputValue);
	        },

	        emitReceiptPhone(newInputValue) {
	            this.$emit('receipt-phone', newInputValue);
	        },

	        emitReceiptEmail(newInputValue) {
	            this.$emit('receipt-email', newInputValue);
	        },

	    	updateReceipt: function(){
	    		axios.put('http://localhost:8000/receipts/'+this.receiptId,{
	    			receipt_name: this.updateReceiptName,
	    			receipt_phone: this.updateReceiptPhone,
	    			receipt_email: this.updateReceiptEmail
	    		})
	    		.then(function(res){
	    			console.log(res);
	    		})
	    		.catch(function(err){
	    			console.log(err.response);
	    		});
	    		this.$parent.receipts[this.$parent.receiptIndex].receipt_name=this.updateReceiptName;
	    		this.$parent.receipts[this.$parent.receiptIndex].receipt_phone=this.updateReceiptPhone;
	    		this.$parent.receipts[this.$parent.receiptIndex].receipt_email=this.updateReceiptEmail;
	    		this.$parent.$parent.forceRerender();
	    		$('#updateReceiptModal').modal('close');
	    	},

	    	validateReceiptName: function(e) {
	    		if(!this.updateReceiptName){
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

    			if(this.updateReceiptPhone ==null || this.updateReceiptPhone.length == 0){
    				this.validReceiptPhone = false;
	    			this.invalidReceiptPhone = false;
    			}
    			else if(!PHONE_REGEXP.test(this.updateReceiptPhone) || this.updateReceiptPhone.length < 10){
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

    			if(this.updateReceiptEmail ==null || this.updateReceiptEmail.length == 0){
    				this.validReceiptEmail = false;
	    			this.invalidReceiptEmail = false;
    			}
    			else if(!MAIL_REGEXP.test(this.updateReceiptEmail)){
    				this.validReceiptEmail = false;
	    			this.invalidReceiptEmail = true;
    				$('.receipt_email_helper').attr('data-error', 'Correo electrónico no válido.');
    			}
    			else{
    				this.validReceiptEmail = true;
	    			this.invalidReceiptEmail = false;
    			}
    		},

    		resetUpdateReceiptInputs: function(e) {
    			this.validReceiptName= false;
    			this.invalidReceiptName=false;
    			this.validReceiptPhone=false;
    			this.invalidReceiptPhone=false;
    			this.validReceiptEmail=false;
    			this.invalidReceiptEmail=false;
    		},

    		openDeleteReceiptModal: function(e) {
    			$('#deleteReceiptModal').modal({
    				dismissible: false
    			});
    			$('#deleteReceiptModal').modal('open');
    		}
	    },
	}
</script>