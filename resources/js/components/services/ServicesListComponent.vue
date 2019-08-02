<template>
	<div class="row">
		<div class="col s12 m3" v-show="services.length > 0" v-for="(service, index) in filteredServices">
			<div v-on:click="updateService(service, index)" class="card hoverable hoverable-card selectable">
		        <div class="card-content center-align">
					<span class="card-title">
						<i class="material-icons inline-icon-large">layers</i><br>
						<b v-if="service.service_name">{{service.service_name}}</b>
					</span>
					<p><i class="material-icons inline-icon-small">settings</i>
						<span v-if="service.service_description">{{service.service_description}}</span>
						<span v-else class="grey-text">Servicio sin descripción</span>
					</p>
		        </div>
		    </div>
		</div>
		<div>
			<h5 
				v-show="filteredServices.length == 0 && this.$parent.searchService != '' " 
				class="center grey-text">
				Búsqueda sin resultados.
			</h5>
			<h5 v-show="services.length == 0 && this.$parent.searchService == ''" class="center grey-text">No hay servicios registrados.</h5>
		</div>
		<update-service-modal-component :service-id="serviceId.toString()" :service-name="serviceName" :service-code="serviceCode" :service-description="serviceDescription"></update-service-modal-component>
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
			
		},

		props:{
			services: {
				type: Array
			},
		},

		data() {
			return {
				serviceIndex: null,
				serviceId: '',
				serviceName: '',
				serviceCode: '',
				serviceDescription: ''
			}
		},

		methods: {
			updateService: function(service, index) {
				this.serviceIndex = index;
				this.serviceId=service.service_id;
				this.serviceName=service.service_name;
				this.serviceCode=service.service_code;
				this.serviceDescription=service.service_description;
				$('#update_service_name,#update_service_description').characterCounter();
				$('#updateServiceModal').modal({
					dismissible: false,
					onOpenStart: function() {
						$('.label_update_service_name').addClass('active');
						if(service.service_phone != null){
							$('.label_update_service_description').addClass('active');
						}
					},
					onCloseEnd: function() {
						//TO-DO: Rmeove al validations and clear the form
					}
				});
				$('#updateServiceModal').modal('open');
			}
		},

		computed: {
			filteredServices: function() {
				return this.services.filter((service)=>{
					return service.service_name.toLowerCase().indexOf(this.$parent.searchService.toLowerCase()) >= 0;
					// || service.service_phone.indexOf(this.searchService) >= 0
				});   		
			}
		}
	}
</script>