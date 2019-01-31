<template>
	<div class="row">
		<div class="container">
			<div class="row" style="margin-bottom: 0;">
				<div class="card hoverable col s12 m12" style="float: none;">
					<div class="input-field valign-wrapper" >
						<i class="material-icons prefix">search</i>
						<input v-model="search_client" placeholder="Buscar cliente" type="text" style="border-bottom: none!important;box-shadow: none!important;margin-bottom: 0;">
					</div>
				</div>
			</div>
		</div>
		<div class="col s12 m3" v-show="clients.length > 0" v-for="client in filteredClients">
			<div v-on:click="updateClient" class="card hoverable hoverable-card selectable">
		        <div class="card-content center-align">
					<span class="card-title"><i class="material-icons inline-icon-large">person</i><br><b>{{client.client_name}}</b></span>
					<p><i class="material-icons inline-icon-small">phone</i>&nbsp;&nbsp;{{client.client_phone}}</p>
					<p><i class="material-icons inline-icon-small">email</i>&nbsp;&nbsp;{{client.client_email}}</p>
		        </div>
		    </div>
		</div>
		<div v-show="clients.length == 0">
			<h5 class="center grey-text">No hay clientes registrados.</h5>
		</div>
		<div v-if="filteredClients.length == 0">
			<h5 class="center grey-text">Búsqueda sin resultados.</h5>
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

	.hoverable-card:hover{
		background-color: #eeeeee;
		transition: .1s;
	}

	.selectable{
		cursor: pointer;
	}
</style>
<script >
	export default {
		props: {
			clients: {
				type: Array
			},
		},

		data() {
			return {
				search_client: '',
			}
		},

	    mounted() {
	        console.log('Clients component mounted');
	    },

	    methods: {
	    	updateClient: function(){
	    		$('#updateClientModal').modal('open');
	    	}
	    },

	    computed: {
	    	filteredClients: function() {
	    		return this.clients.filter((client)=>{
	    			return client.client_name.toLowerCase().indexOf(this.search_client.toLowerCase()) >= 0
	    			|| client.client_phone.indexOf(this.search_client) >= 0
	    			|| client.client_email.indexOf(this.search_client) >= 0;
	    		});   		
	    	}
	    }
	}
</script>