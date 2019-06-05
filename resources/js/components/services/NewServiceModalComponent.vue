<template>
    <div id="newServiceModal" class="modal newServiceModal">
        <div class="modal-content">
            <h5>Nuevo servicio</h5>
            <div class="row">
                <form id="newServiceForm" class="col s12 no-padding" method="POST" action="services">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="row">
                        <div class="input-field col s12 m12 no-vertical-margin">
                            <i class="material-icons prefix">settings</i>
                            <input v-model="newServiceName" v-on:blur="validateServiceName" v-bind:class="{'valid': validServiceName, 'invalid': invalidServiceName}" id="service_name" type="text" data-length="50" maxlength="50" placeholder="Servicio*" required>
                            <span class="helper-text service_name_helper" data-success="Servicio validado."></span>
                        </div>
                        <div class="input-field col s12 m12 no-vertical-margin">
                            <i class="material-icons prefix">subject</i>
                            <input v-model="newServiceDescription" v-on:blur="validateServiceDescription" v-bind:class="{'valid': validServiceDescription, 'invalid': invalidServiceDescription}" id="service_description" type="text" data-length="50" minlength="8" maxlength="50" placeholder="Descripción del servicio">
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
                newServiceDescription: null,
                validServiceName: false,
                validServiceDescription: false,
                invalidServiceName: false,
                invalidServiceDescription: false,
            }
        },

        computed: {
            validateForm: function (e) {
                if(!this.validServiceName || this.invalidServiceDescription){
                    return true;
                }
            }
        },

        methods: {
            
        }
    }
</script>