<template>
	<div>
		<ul class="collection">
			<li class="collection-item" v-for="(device, index) in devices">
				<span class="title"><b>{{device.device_name}}</b></span>
				<p style="font-size:13px;">
					{{device.device_trouble_description}}<br>
				</p>
				<p style="font-size:13px;" v-for="(accessory, index) in device.accessories">
					<i class="material-icons inline-icon-small">keyboard</i> {{accessory.accessory_name}}&nbsp;({{getAccessorySerialNumber(accessory.accessory_serial_number)}})
				</p>
			</li>
		</ul>
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

	.hoverable-card:hover{
		background-color: #eeeeee;
		transition: .1s;
	}

	.selectable{
		cursor: pointer;
	}
</style>
<script>
	export default {
		mounted(){
            console.log("Devices list component mounted succesfully");
		},

		props:{
			devices: {
				type: Array
			},
		},

		methods: {
			getAccessorySerialNumber: function(accessory_serial_number) {
				if(accessory_serial_number){
					return accessory_serial_number;
				}
				else{
					return "S/N";
				}
			}
		},

		computed: {
			filteredDevices: function() {
				return this.devices.filter((device)=>{
					return device.device_name.toLowerCase().indexOf(this.$parent.searchDevice.toLowerCase()) >= 0;
					// || device.device_serial_number.indexOf(this.searchDevice) >= 0
					// || device.device_trouble_description.indexOf(this.searchDevice) >= 0;
				});   		
			}
		}
	}
</script>