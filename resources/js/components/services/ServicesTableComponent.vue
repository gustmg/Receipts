<template>
	<div class="row">
        <div class="col m12">
            <table v-if="this.services.length != 0" class="centered">
                <thead>
                    <tr>
                        <th class="service-checkbox-header">
                            <FormulateInput
                                type="checkbox"
                                class="valign-wrapper"
                            />
                        </th>
                        <th class="service-header">Services</th>
                        <th class="service-cost-header">Costo</th>
                        <th class="service-base-price-percentage-header">Ganancia público en general</th>
                        <th class="service-retail-price-percentage-header">Ganancia menudeo</th>
                        <th class="service-wholesale-price-percentage-header">Ganancia mayoreo</th>
                        <th class="service-options-header">Opciones</th>
                    </tr>
                </thead>
                <tbody v-show="services.length > 0">
                    <tr v-for="service in filteredServices" v-bind:key="service.service_id">
                        <td>
                            <FormulateInput
                                type="checkbox"
                                class="valign-wrapper"
                            />
                        </td>
                        <td class="left-al">
                            <span class="valign-wrapper">{{service.service_name}}</span>
                            <span class="valign-wrapper">{{service.service_description}}</span>
                        </td>
                        <td>$ {{service.service_cost}}</td>
                        <td>{{service.service_base_price_percentage}}%</td>
                        <td>{{service.service_retail_price_percentage}}%</td>
                        <td>{{service.service_wholesale_price_percentage}}%</td>
                        <td>
                            <button v-on:click="updateService(service)" class="waves-effect btn-flat"><i class="material-icons">edit</i></button>
                            <button class="waves-effect btn-flat"><i class="material-icons">delete</i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
		<div class="col s12">
			<h5 
				v-show="filteredServices.length == 0 && this.searchServiceValue != '' " 
				class="center grey-text">
				Búsqueda sin resultados.
			</h5>
			<h5 v-show="services.length == 0 && this.searchServiceValue == ''" class="center grey-text">No hay servicios registrados.</h5>
		</div>
        <update-service-modal-component></update-service-modal-component>
	</div>
</template>
<style scoped>
	.service-checkbox-header{
        width: 4%;
    }
    .service-cost-header,
    .service-stock-header,
    .service-base-price-percentage-header,
    .service-retail-price-percentage-header,
    .service-wholesale-price-percentage-header,
    .service-options-header{
        width: 10%;
    }
    .service-header{
        width: 30%;
    }
	.hoverable-card:hover{
		background-color: #eeeeee;
		transition: .1s;
	}
    .left-al{
        text-align: left;
    }
	.selectable{
		cursor: pointer;
	}
</style>
<script>
    import {mapState, mapMutations, mapActions} from "vuex";
	export default {
		mounted(){
            this.fetchServices();
        },

		data() {
			return {
                serviceIndex: null,
			}
		},

		methods: {
            ...mapActions('services',[
                'fetchServices', 'setServiceToUpdate'
            ]),
            
            updateService: function(service) {
                this.setServiceToUpdate(service);
                $('#updateServiceModal').modal('open');
            }
		},

		computed: {
            ...mapState('services', [
                'services', 'serviceToUpdate', 'searchServiceValue'
            ]),

			filteredServices: function() {
				return this.services.filter((service)=>{
					return service.service_name.toLowerCase().indexOf(this.searchServiceValue.toLowerCase()) >= 0;
					// || service.service_phone.indexOf(this.searchService) >= 0
				});   		
            }
		}
	}
</script>