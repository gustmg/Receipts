<template>
	<div id="clientsCompactListModal" class="modal clientsCompactListModal">
		<div class="modal-content">
            <!-- <client-search-bar-component></client-search-bar-component> -->
            <ul class="collection with-header">
                <a class="collection-item selectable client-element" v-on:click="selectClient(index)" v-for="(client, index) in clients">{{client.client_name}}</a>
            </ul>
		</div>
		<div class="modal-footer">
			<button class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></button>
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
    .client-element{
        color:#039be5 !important;
    }
</style>
<script>
	export default {
	    mounted() {
	        console.log('Clients compact list modal mounted.');
		},
		
		props:{
			clients: {
				type: Array
			},
		},

	    data(){
	    	return {
	    		csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
	    		newReceiptName: null,
	    		newReceiptPhone: null,
	    		newReceiptEmail: null,
	    		validReceiptName: false,
	    		invalidReceiptName: false,
	    		validReceiptPhone: false,
	    		invalidReceiptPhone: false,
	    		validReceiptEmail: false,
				invalidReceiptEmail: false,
				newClientToggle: false
	    	}
	    },

	    computed: {
	    	validateForm: function(e) {
	    		if(!this.validReceiptName || this.invalidReceiptPhone || this.invalidReceiptEmail){
	    			return true;
	    		}
	    	}
	    },

	    methods: {
	    	saveReceipt: function(){
	    		var newReceipt = {
		    		receipt_id: '',
		    		receipt_name: this.newReceiptName,
		    		receipt_phone: this.newReceiptPhone,
		    		receipt_email: this.newReceiptEmail
		    	};

	    		axios.post('http://localhost:8000/receipts',{
	    			receipt_name: this.newReceiptName,
	    			receipt_phone: this.newReceiptPhone,
	    			receipt_email: this.newReceiptEmail
	    		})
	    		.then((res)=>{newReceipt.receipt_id = res.data.receipt_id})
	    		.catch(function(err){
	    			console.log(err);
	    		});

	    		this.$parent.receipts.push(newReceipt);
	    		this.$parent.forceRerender();
	    		$('#newReceiptModal').modal('close');
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
            
            selectClient: function (index) {
                // alert(this.clients[index].client_name);
				this.$parent.receiptClient=this.clients[index];
                $('#clientsCompactListModal').modal('close');
            }
	    }
	}
</script>