<template>
	<div id="clientsCompactListModal" class="modal modal-fixed-footer clientsCompactListModal">
		<div class="modal-content">
            <client-search-bar-component :search-value-client.sync="searchClient"></client-search-bar-component>
            <ul class="collection with-header">
                <a class="collection-item selectable client-element" v-on:click="selectClient(client)" v-for="(client, index) in filteredClients" v-bind:key="client.client_id">{{client.client_name}}</a>
            </ul>
		</div>
		<div class="modal-footer">
			<button class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></button>
		</div>
	</div>
</template>
<style type="text/css">
	.modal-content{
		padding-bottom: 0 !important;
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

			searchValueClient:String
		},

		data() {
			return {
				searchClient: ''
			}
		},

	    methods: {
			showClientsList: function () {
				$('#clientsCompactListModal').modal({
					dismissible: false
				});
				$('#clientsCompactListModal').modal('open');
			},

			selectClient: function (client) {
				this.$emit('update:clientId', client.client_id);
				this.$emit('update:clientName', client.client_name);
				this.$emit('update:clientEmail', client.client_email);
				this.$emit('update:clientPhone', client.client_phone);
				$('#clientsCompactListModal').modal('close');
			}
		},
		
		computed: {
			filteredClients: function() {
				return this.clients.filter((client)=>{
					return client.client_name.toLowerCase().indexOf(this.searchClient.toLowerCase()) >= 0;
					// || product.product_phone.indexOf(this.searchProduct) >= 0
				});   		
			},
		}
	}
</script>