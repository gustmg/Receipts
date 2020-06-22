<template>
	<div id="updateServiceModal" class="modal updateServiceModal modal-fixed-footer">
		<div class="modal-content">
            <div class="row no-margin-bottom">
                <div class="col m12"><h6><b>Editar Services</b></h6></div>
            </div>
            <FormulateForm class="row" name="updateServiceForm" v-model="updateServiceForm">
                <input type="hidden" name="_token" :value="csrf">
                <FormulateInput
                    type="hidden"
                    name="service_id"
                    v-model="serviceToUpdate.service_id"
                />
                <blockquote class="col s12"><b>Información principal</b></blockquote>                 
                <FormulateInput
                    @validation="invalidServiceName = $event.hasErrors"
                    type="text"
                    name="service_name"
                    label="Nombre *"
                    validation="bail|required|min:5"
                    class="col m12"
                    v-model="serviceToUpdate.service_name"
                />
                <FormulateInput
                    type="text"
                    name="service_description"
                    label="Descripción"
                    class="col m12"
                    v-model="serviceToUpdate.service_description"
                />
                <FormulateInput
                    type="text"
                    name="service_code"
                    label="Código interno"
                    class="col m6"
                    v-model="serviceToUpdate.service_code"
                />
                <FormulateInput
                    @validation="invalidServiceCost = $event.hasErrors"
                    type="text"
                    name="service_cost"
                    label="Costo ($)"
                    class="col m6"
                    validation="bail|min:0, value"
                    v-model="serviceToUpdate.service_cost"
                    v-on:blur="validateSalePrice(serviceToUpdate.service_cost, serviceToUpdate_prev_cost)"
                    v-currency
                />
                <blockquote class="col s12"><b>Porcentajes de ganancia por tipo de venta</b></blockquote>
                <FormulateInput
                    @validation="invalidServiceBasePricePercentage = $event.hasErrors"
                    type="number"
                    name="service_base_price_percentage"
                    label="Público en general"
                    class="col m4"
                    help="Precio de venta estimado: $1230.00"
                    validation="min:0, value"
                    min="0"
                    v-model="serviceToUpdate.service_base_price_percentage"
                />
                <FormulateInput
                    @validation="invalidServiceRetailPricePercentage = $event.hasErrors"
                    type="number"
                    name="service_retail_price_percentage"
                    label="Menudeo"
                    class="col m4"
                    help="Precio de venta estimado: $1230.00"
                    validation="min:0, value"
                    min="0"
                    v-model="serviceToUpdate.service_retail_price_percentage"
                />
                <FormulateInput
                    @validation="invalidServiceWholesalePricePercentage = $event.hasErrors"
                    type="number"
                    name="service_wholesale_price_percentage"
                    label="Mayoreo"
                    class="col m4"
                    help="Precio de venta estimado: $1230.00"
                    validation="min:0, value"
                    min="0"
                    v-model="serviceToUpdate.service_wholesale_price_percentage"
                />
            </FormulateForm>
        </div>
        <div class="modal-footer">
            <button v-on:click="resetUpdateServiceForm" class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></button>
            <button v-on:click="saveService" type="submit" v-bind:class="{'disabled': validateForm}" class="modal-action btn waves-effect submit_button">
                <b>Editar</b>
            </button>
        </div>
	</div>
</template>
<style type="text/css">
    .updateServiceModal{
        width: 37%;
        max-height: 80%;
        height: 80%;
    }
	.delete-button{
		margin-left: 10px;
		margin-top: 10px;
	}
	.inline-icon-large {
	   vertical-align: bottom;
	   font-size: 48px !important;
	}
	.inline-icon-small {
	   vertical-align: bottom;
	   font-size: 20px !important;
	}
	.no-vertical-margin{
		margin-top: 0;
		margin-bottom: 0;
	}
	.helper-text{
		min-height: 0 !important;
    }
    .no-margin-bottom{
        margin-bottom:0;
    }
</style>
<script>
    import {mapState, mapMutations, mapActions} from "vuex";

	export default {
	    mounted() {
	        console.log('Update Service Modal Component Mounted');
	    },

	    data(){
	    	return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                updateServiceForm: null,
                invalidServiceName: true,
                invalidServiceCost: false,
                invalidServiceBasePricePercentage: false,
                invalidServiceRetailPricePercentage: false,
                invalidServiceWholesalePricePercentage: false
	    	}
        },
        
        computed:{
            ...mapState('services',[
                'serviceToUpdate', 'serviceToUpdatePrevCost'
            ]),

            validateForm: function (e) {
                if(this.invalidServiceName || this.invalidServiceCost || this.invalidServiceBasePricePercentage || this.invalidServiceRetailPricePercentage || this.invalidServiceWholesalePricePercentage){
                    return true;
                }
                else{
                    return false;
                }
            },

            serviceCost: function(e) {
                return this.$parseCurrency(this.updateServiceForm.service_cost)
            }
        },

	    methods: {
            ...mapActions('services', [
                'updateService'
            ]),
	    	saveService: function(){
                this.updateServiceForm.service_cost=this.serviceCost;
                this.updateService(this.updateServiceForm);
                this.$formulate.reset('updateServiceForm');
                $('#updateServiceModal').modal('close');
	    	},

    		resetUpdateServiceForm: function(e) {
    			this.$formulate.reset('updateServiceForm');
            },

            validateSalePrice: function (salePrice, cost) {
                if(salePrice < cost && salePrice != ''){
                    ('#warningServiceCostModal').modal('open');
                }
            }
	    },
	}
</script>