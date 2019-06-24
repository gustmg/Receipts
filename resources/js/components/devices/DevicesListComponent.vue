<template>
	<div class="row">
		<div class="col s12 m4" v-show="devices.length > 0" v-for="(device, index) in filteredDevices">
			<div v-on:click="updateDevice(device, index)" class="card hoverable hoverable-card selectable">
		        <div class="card">
                    <div class="card-content">
                        <span class="card-title"><b>{{device.device_name}}</b></span>
                        <!-- <span><b>SN:</b> 1234</span><br>
                        <span><b>Descripción:</b> Formateo con respaldo, teclado no responde con algunas teclas y se apaga despues de encenderlo</span><br>
                        <span><b>Accesorios:</b></span>
                        <ul class="collection">
                            <li class="collection-item">Batería</li>
                            <li class="collection-item">Cargador</li>
                        </ul> -->
                        <!-- <span><b>Proceso:</b></span><br>
                        <div class="progress">
                            <div class="determinate" style="width: 70%"></div>
                        </div>
                        <h5 class="center-align">70%</h5>
                        <div class="full-width center-align">
                            <span>Diagnóstico post-reparación</span>
                        </div> -->
                    </div>
                    <!-- <div class="card-action">
                        <a href="#">This is a link</a>
                        <a href="#">This is a link</a>
                    </div> -->
                </div>
		    </div>
		</div>
		<div>
			<h5 
				v-show="filteredDevices.length == 0 && this.$parent.searchDevice != '' " 
				class="center grey-text">
				Búsqueda sin resultados.
			</h5>
			<h5 v-show="devices.length == 0 && this.$parent.searchDevice == ''" class="center grey-text">No hay devicees registrados.</h5>
		</div>
		<update-device-modal-component :device-id="deviceId.toString()" :device-name="deviceName" :device-phone="deviceSerialNumber" :device-email="deviceTroubleDescription"></update-device-modal-component>
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

		data() {
			return {
				deviceIndex: null,
				deviceId: '',
				deviceName: '',
				deviceSerialNumber: '',
				deviceTroubleDescription: ''
			}
		},

		methods: {
			updateDevice: function(device, index) {
				this.deviceIndex = index;
				this.deviceId=device.device_id;
				this.deviceName=device.device_name;
				this.deviceSerialNumber=device.device_serial_number;
				this.deviceTroubleDescription=device.device_trouble_description;
				$('#update_device_name,#update_device_serial_number,#update_device_trouble_description').characterCounter();
				$('#updateDeviceModal').modal({
					dismissible: false,
					onOpenStart: function() {
						$('.label_update_device_name').addClass('active');
						if(device.device_serial_number != null){
							$('.label_update_device_serial_number').addClass('active');
						}
						if(device.device_trouble_description != null){
							$('.label_update_device_trouble_description').addClass('active');
						}
					},
					onCloseEnd: function() {
						//TO-DO: Rmeove al validations and clear the form
					}
				});
				$('#updateDeviceModal').modal('open');
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