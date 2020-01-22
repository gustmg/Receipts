<template>
	<div class="row">
		<div class="col s12 m3" v-show="receipts.length > 0" v-for="(receipt, index) in filteredReceipts">
			<div v-on:click="updateReceipt(receipt, index)" class="card hoverable hoverable-card selectable receipt-card">
		        <div class="card-content">
					<span><b>Recepción #{{receipt.receipt_id}}</b></span>
					<span class="card-title">
						<b v-if="receipt.client.client_name">{{receipt.client.client_name}}</b>
					</span>
					<p>
						<span v-if="receipt.client.client_phone"><i class="material-icons inline-icon-small">phone</i> {{receipt.client.client_phone}}</span>
						<span v-else class="grey-text">Teléfono no registrado</span>
					</p>
					<span><b>Equipos:</b></span>
					<devices-list-component :devices="receipt.devices"></devices-list-component>
					<span><b>Registrada por:</b> {{receipt.user.name}}</span>
		        </div>
		    </div>
		</div>
		<!-- <div>
			<h5 
				v-show="filteredReceipts.length == 0 && this.$parent.searchReceipt != '' " 
				class="center grey-text">
				Búsqueda sin resultados.
			</h5>
			<h5 v-show="receipts.length == 0 && this.$parent.searchReceipt == ''" class="center grey-text">No hay receiptes registrados.</h5>
		</div> -->
		<!-- <update-receipt-modal-component :receipt-id="receiptId.toString()" :receipt-name="receiptName" :receipt-phone="receiptPhone" :receipt-email="receiptEmail"></update-receipt-modal-component> -->
	</div>
</template>
<style>
	.inline-icon-large {
	   vertical-align: bottom;
	   font-size: 48px !important;
	}
	.inline-icon-small {
	   vertical-align: bottom;
	   font-size: 20px !important;
	}
	.inline-icon-medium {
			vertical-align: bottom;
			font-size: 32px !important;
	}
	.device-desc{
		margin-left:24px !important;
	}
	.hoverable-card:hover{
		background-color: #eeeeee;
		transition: .1s;
	}

	.selectable{
		cursor: pointer;
	}

	.receipt-card{
		height: 425px !important;
	}
</style>
<script>
	export default {
		mounted(){
			console.log("Receipts list component mounted");
		},

		props:{
			receipts: {
				type: Array
			},
		},

		data() {
			return {
				receiptIndex: null,
				receiptId: '',
				receiptName: '',
				receiptPhone: '',
				receiptEmail: ''
			}
		},

		// methods: {
		// 	updateReceipt: function(receipt, index) {
		// 		this.receiptIndex = index;
		// 		this.receiptId=receipt.receipt_id;
		// 		this.receiptName=receipt.receipt_name;
		// 		this.receiptPhone=receipt.receipt_phone;
		// 		this.receiptEmail=receipt.receipt_email;
		// 		$('#update_receipt_name,#update_receipt_phone,#update_receipt_email').characterCounter();
		// 		$('#updateReceiptModal').modal({
		// 			dismissible: false,
		// 			onOpenStart: function() {
		// 				$('.label_update_receipt_name').addClass('active');
		// 				if(receipt.receipt_phone != null){
		// 					$('.label_update_receipt_phone').addClass('active');
		// 				}
		// 				if(receipt.receipt_email != null){
		// 					$('.label_update_receipt_email').addClass('active');
		// 				}
		// 			},
		// 			onCloseEnd: function() {
		// 				//TO-DO: Rmeove al validations and clear the form
		// 			}
		// 		});
		// 		$('#updateReceiptModal').modal('open');
		// 	}
		// },

		computed: {
			filteredReceipts: function() {
				return this.receipts.filter((receipt)=>{
					return receipt.client.client_name.toLowerCase().indexOf(this.$parent.searchReceipt.toLowerCase()) >= 0;
					// || receipt.receipt_id.indexOf(this.searchReceipt) >= 0;
				});   		
			}
		}
	}
</script>