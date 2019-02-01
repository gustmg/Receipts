<template>
	<button v-on:click="newClient" style="position:fixed;bottom: 24px;right: 24px;" class="btn-floating btn-large waves-effect waves-light">
		<i class="material-icons">add</i>
	</button>
</template>
<style></style>
<script>
	export default {
		mounted() {
	        console.log('New client button component mounted');
	    },

	    methods: {
	    	newClient: function() {
	    		$('#newClientModal').modal({
	    			dismissible: false
	    		});
	    		$('#newClientModal').modal('open');
	    	},
	    }
	}
</script>