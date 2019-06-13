<template>
	<button v-on:click="newReceipt" style="position:fixed;bottom: 24px;right: 24px;" class="btn-floating btn-large waves-effect waves-light">
		<i class="material-icons">add</i>
	</button>
</template>
<style></style>
<script>
	export default {
		mounted() {
	        console.log('New receipt button component mounted');
	    },

	    methods: {
	    	newReceipt: function() {
	    		$('#receipt_name,#receipt_phone,#receipt_email').characterCounter();
	    		$('#newReceiptModal').modal({
	    			dismissible: false
	    		});
	    		$('#newReceiptModal').modal('open');
	    	},
	    }
	}
</script>