<template>
    <div class="col s12 center-align">
        <button v-on:click="newDevice" class="btn-floating btn-large waves-effect waves-light"><i class="material-icons">add</i></button>
    </div>
</template>
<style></style>
<script>
	export default {
		mounted() {
	        console.log('New device button component mounted');
	    },

	    methods: {
	    	newDevice: function() {
	    		$('#device_name,#device_serial_number,#device_trouble_description').characterCounter();
	    		$('#newDeviceModal').modal({
	    			dismissible: false
	    		});
	    		$('#newDeviceModal').modal('open');
	    	},
	    }
	}
</script>