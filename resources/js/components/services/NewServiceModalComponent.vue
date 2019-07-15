<template>
    <div id="newServiceModal" class="modal newServiceModal">
        <div class="modal-content">
            <h5>Nuevo servicio</h5><br>
            <div class="row">
                <form id="newServiceForm" class="col s12 no-padding" method="POST" action="services">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="row">
                        <div class="input-field col s8 m8 no-vertical-margin">
                            <input placeholder="" id="service_name" type="text" v-model="newServiceName" v-on:blur="validateServiceName" v-bind:class="{'valid': validServiceName, 'invalid': invalidServiceName}" data-length="50" maxlength="50" required>
                            <label for="service_name" class="valign-wrapper"><i class="material-icons">layers</i>&nbsp;&nbsp;Servicio *</label>
                            <span class="helper-text service_name_helper" data-success="Servicio validado."></span><br>
                        </div>
                        <div class="input-field col s4 m4 no-vertical-margin">
                            <input placeholder="" id="service_code" type="text" v-model="newServiceCode" data-length="50" maxlength="50">
                            <label for="service_code" class="valign-wrapper"><i class="material-icons">layers</i>&nbsp;&nbsp;Código de servicio *</label>
                            <span class="helper-text service_code_helper" data-success="Código de servicio validado."></span><br>
                        </div>
                        <div class="input-field col s12 m12 no-vertical-margin">
                            <input placeholder="" id="service_description" type="text" v-model="newServiceDescription" v-on:blur="validateServiceDescription" v-bind:class="{'valid': validServiceDescription, 'invalid': invalidServiceDescription}" data-length="50" maxlength="50" required>
                            <label for="service_description" class="valign-wrapper"><i class="material-icons">settings</i>&nbsp;&nbsp;Descripción *</label>
                            <span class="helper-text service_description_helper" data-success="Descripción del servicio validada."></span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button v-on:click="resetNewServiceInputs" class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></button>
            <button v-on:click="saveService" type="submit" v-bind:class="{'disabled': validateForm}" class="modal-action btn waves-effect submit_button">
                <b>Registrar</b>
            </button>
        </div>
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
            console.log('New service modal component mounted');
        },

        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                newServiceName: null,
                newServiceCode: null,
                newServiceDescription: null,
                validServiceName: false,
                invalidServiceName: false,
                validServiceDescription: false,
                invalidServiceDescription: false
            }
        },

        computed: {
            validateForm: function (e) {
                if(!this.validServiceName){
                    return true;
                }
            }
        },

        methods: {
            saveService: function(){
                var newService = {
                    service_id: '',
                    service_name: this.newServiceName,
                    service_code: this.newServiceCode,
                    service_description: this.newServiceDescription
                };

                axios.post('http://localhost:8000/services',{
                    service_name: this.newServiceName,
                    service_code: this.newServiceCode,
                    service_description: this.newServiceDescription
                })
                .then((res)=>{newService.service_id = res.data.service_id})
                .catch(function(err){
                    console.log(err);
                });

                this.$parent.services.push(newService);
                this.$parent.forceRerender();
                $('#newServiceModal').modal('close');
            },

            validateServiceName: function(e) {
                if(!this.newServiceName){
                    this.validServiceName = false;
                    this.invalidServiceName = true;
                    $('.service_name_helper').attr('data-error', 'Este campo no puede quedar vacío.');
                }
                else{
                    this.validServiceName = true;
                    this.invalidServiceName = false;
                }
            },

            validateServiceDescription: function(e) {
                if(!this.newServiceDescription){
                    this.validServiceDescription = false;
                    this.invalidServiceDescription = true;
                    $('.service_description_helper').attr('data-error', 'Este campo no puede quedar vacío.');
                }
                else{
                    this.validServiceDescription = true;
                    this.invalidServiceDescription = false;
                }
            },

            resetNewServiceInputs: function (e) {
                this.newServiceName= null;
                this.newServiceCode= null;
                this.newServiceDescription= null;
                this.validServiceName= false;
                this.invalidServiceName= false;
                this.validServiceDescription= false;
                this.invalidServiceDescription= false;
            }
        }
    }
</script>