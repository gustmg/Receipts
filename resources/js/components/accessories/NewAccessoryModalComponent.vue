<template>
	<div id="newAccessoryModal" class="modal newAccessoryModal">
		<div class="modal-content">
			<h5>Nuevo accesorio</h5><br>
			<div class="row">
				<form id="newAccessoryForm" class="col s12 no-padding" method="POST" action="accessories">
					<input type="hidden" name="_token" :value="csrf">
					<div class="row">
						<div class="input-field col s12 m8 no-vertical-margin">
							<input placeholder="" id="accessory_name" type="text" v-model="newAccessoryName" v-on:blur="validateAccessoryName" v-bind:class="{'valid': validAccessoryName, 'invalid': invalidAccessoryName}" data-length="50" maxlength="50" required>
							<label for="accessory_name" class="valign-wrapper"><i class="material-icons">computer</i>&nbsp;&nbsp;Nombre del accesorio*</label>
							<span class="helper-text accessory_name_helper" data-success="Nombre validado."></span><br>
				        </div>
				        <div class="input-field col s12 m4 no-vertical-margin">
				        	<input placeholder="" id="accessory_serial_number" type="tel" v-model="newAccessorySerialNumber" v-on:blur="validateAccessorySerialNumber" v-bind:class="{'valid': validAccessorySerialNumber, 'invalid': invalidAccessorySerialNumber}" data-length="4" minlength="4" maxlength="4">
							<label for="accessory_serial_number" class="valign-wrapper"><i class="material-icons">local_offer</i>&nbsp;&nbsp;Número de serie</label>
							<span class="helper-text accessory_serial_number_helper" data-success="Número de serie validado."></span>
				        </div>
			        </div>
				</form>
			</div>
		</div>
		<div class="modal-footer">
			<button v-on:click="resetNewAccessoryInputs" class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></button>
			<button v-on:click="saveAccessory" type="submit" v-bind:class="{'disabled': validateForm}" class="modal-action btn waves-effect submit_button">
				<b>Registrar</b>
			</button>
		</div>
	</div>
</template>
<style type="text/css">
	.inline-icon-large {
	   vertical-align: bottom;
	   font-size: 48px !important;
	}
	.inline-icon-small {
	   vertical-align: bottom;
	   font-size: 20px !important;
	}
	.helper-text{
		min-height: 0 !important;
	}
	.no-vertical-margin{
		margin-top: 0;
		margin-bottom: 0;
	}
</style>
<script>
	export default {
	    mounted() {
	        console.log('New accessory modal mounted.');
	    },

	    data(){
	    	return {
	    		csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
	    		newAccessoryName: null,
	    		newAccessorySerialNumber: null,
	    		validAccessoryName: false,
	    		invalidAccessoryName: false,
	    		validAccessorySerialNumber: false,
	    		invalidAccessorySerialNumber: false,
	    	}
	    },

	    computed: {
	    	validateForm: function(e) {
	    		if(!this.validAccessoryName || this.invalidAccessorySerialNumber){
	    			return true;
	    		}
	    	}
	    },

	    methods: {
	    	saveAccessory: function(){
	    		var newAccessory = {
		    		accessory_id: '',
		    		accessory_name: this.newAccessoryName,
		    		accessory_serial_number: this.newAccessorySerialNumber
		    	};

	    		axios.post('http://localhost:8000/accessories',{
	    			accessory_name: this.newAccessoryName,
	    			accessory_serial_number: this.newAccessorySerialNumber
	    		})
	    		.then((res)=>{newAccessory.accessory_id = res.data.accessory_id})
	    		.catch(function(err){
	    			console.log(err);
	    		});

	    		this.$parent.accessorys.push(newAccessory);
	    		this.$parent.forceRerender();
	    		$('#newAccessoryModal').modal('close');
	    	},

	    	validateAccessoryName: function(e) {
	    		if(!this.newAccessoryName){
	    			this.validAccessoryName = false;
	    			this.invalidAccessoryName = true;
	    			$('.accessory_name_helper').attr('data-error', 'Este campo no puede quedar vacío.');
	    		}
	    		else{
	    			this.validAccessoryName = true;
	    			this.invalidAccessoryName = false;
	    		}
    		},
            
    		resetNewAccessoryInputs: function (e) {
    			this.newAccessoryName=null;
    			this.newAccessorySerialNumber=null;
    			this.validAccessoryName= false;
    			this.invalidAccessoryName=false;
    			this.validAccessorySerialNumber=false;
    			this.invalidAccessorySerialNumber=false;
    		}
	    }
	}
</script>