<template>
    <div id="newServiceModal" class="modal newServiceModal modal-fixed-footer">
        <div class="modal-content">
            <div class="row">
                <div class="col m12"><h6><b>Nuevo Servicio</b></h6></div>
            </div>
            <FormulateForm class="row" name="newServiceForm" v-model="newServiceForm">
                <input type="hidden" name="_token" :value="csrf">
                <FormulateInput
                    @validation="invalidServiceName = $event.hasErrors"
                    type="text"
                    name="service_name"
                    label="Nombre *"
                    validation="bail|required|min:5"
                    class="col m8"
                />
                <FormulateInput
                    type="text"
                    name="service_code"
                    label="Código interno"
                    class="col m4"
                />
                <FormulateInput
                    type="text"
                    name="service_description"
                    label="Descripción"
                    class="col m12"
                />
            </FormulateForm>
        </div>
        <div class="modal-footer">
            <button v-on:click="resetNewServiceForm" class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></button>
            <button v-on:click="saveService" type="submit" v-bind:class="{'disabled': validateForm}" class="modal-action btn waves-effect submit_button">
                <b>Registrar</b>
            </button>
        </div>
    </div>
</template>
<style scoped>
    .newServiceModal{
        width: 37%;
        max-height: 80%;
        height: 55%;
    }
    .money{
        height:84px;
    }
    .no-margin-bottom{
        margin-bottom: 0;
    }
</style>
<script>
    import {mapState, mapMutations, mapActions} from "vuex";
    export default {
        mounted() {
            console.log('New service modal component mounted');
        },

        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                newServiceForm: null,
                invalidServiceName: true,
                invalidServiceCost: false,
            }
        },

        computed: {
            validateForm: function (e) {
                if(this.invalidServiceName){
                    return true;
                }
                else{
                    return false;
                }
            }
        },

        methods: {
            ...mapActions('services',['addService', 'closeModal']),
            saveService: function(){
                this.addService(this.newServiceForm);
                $('#newServiceModal').modal('close');
                this.$formulate.reset('newServiceForm');
            },

            resetNewServiceForm: function (e) {
                this.$formulate.reset('newServiceForm');
            }
        }
    }
</script>