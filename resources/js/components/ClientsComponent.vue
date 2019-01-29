<template>
	<div class="row">
		<div class="col s12 m3" v-show="clients.length > 0" v-for="client in clients">
			<div class="card">
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
</style>
<script >
	export default {
		props: {
			clients: {
				type: Array
			}
		},

	    mounted() {
	        console.log('Clients component mounted');
	    },
	}
</script>