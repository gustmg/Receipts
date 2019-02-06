<template>
	<div class="row">
		<client-search-bar-component :search-value.sync="searchClient"></client-search-bar-component>
		<clients-list-component :clients="clients" :key="componentKey"></clients-list-component>
		<new-client-button-component></new-client-button-component>
		<new-client-modal-component></new-client-modal-component>
	</div>
</template>
<script >
	export default {
		props: {
			clients: {
				type: Array
			},
			searchValue:String,
		},

		data() {
			return {
				searchClient: '',
				componentKey: 0
			}
		},

	    mounted() {
	        console.log('Clients component mounted');
	    },

	    methods: {
	    	forceRerender() {
				this.componentKey += 1;  
			}
	    }
	}
</script>