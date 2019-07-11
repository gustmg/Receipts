<template>
    <div class="col s12 center-align">
        <button v-on:click="newAccessory" class="btn-floating btn-large waves-effect waves-light"><i class="material-icons">add</i></button>
    </div>
</template>
<script>
	export default {
		mounted() {
	        console.log('New accessory button component mounted');
	    },

	    methods: {
	    	newAccessory: function() {
	    		$('#accessory_name,#accessory_serial_number,#accessory_trouble_description').characterCounter();
	    		$('#newAccessoryModal').modal({
	    			dismissible: false
	    		});
	    		$('#newAccessoryModal').modal('open');
	    	},
	    }
	}
</script>