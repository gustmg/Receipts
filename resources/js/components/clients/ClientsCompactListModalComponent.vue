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
			}
		},

	    methods: {
			showClientsList: function () {
				$('#clientsCompactListModal').modal({
					dismissible: false
				});
				$('#clientsCompactListModal').modal('open');
			},

			selectClient: function (index) {
				this.$emit('update:clientId', this.clients[index].client_id);
				this.$emit('update:clientName', this.clients[index].client_name);
				this.$emit('update:clientEmail', this.clients[index].client_email);
				this.$emit('update:clientPhone', this.clients[index].client_phone);
				$('#clientsCompactListModal').modal('close');
			}
	    }
	}
</script>