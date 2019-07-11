<template>
    <div class="row">
        <div class="col m9" style="padding-left:24px !important;">
            <sale-search-bar-component :search-value.sync="searchProduct"></sale-search-bar-component>
        </div>
        <div class="col m3" style="padding-left:24px !important;padding-top:8px !important;">
            <div class="row">
                <div class="col m12">
                    <b>Información de venta</b><br>
                    <div class="row">
                        <div class="col m12">
                            <div class="row">
                                <div class="col m12">
                                    <div class="switch">
                                        <label>
                                            <b>¿Cliente nuevo?</b>
                                            <input type="checkbox" v-model="newClientToggle" v-on:click="newClientToggleHandler">
                                            <span class="lever"></span>
                                        </label>
                                        <button v-on:click="showClientsList" class="btn waves-effect waves-light" :disabled="newClientToggle == true">Buscar cliente</button>
                                    </div><br>
                                </div>
                                <div class="col m12">
                                    <form class="row">
                                        <div class="input-field col s4">
                                            <input placeholder="" :value="clientId" @input="$emit('update:clientId', $event.target.value)" id="receipt_client_id" type="text" disabled>
                                            <label for="client_id">No. de cliente</label>
                                        </div>
                                        <div class="input-field col s8">
                                            <input placeholder="" :value="clientName" @input="$emit('update:clientName', $event.target.value)" id="receipt_client_name" type="text" :disabled="newClientToggle == false" v-on:blur="validateReceiptClientName" v-bind:class="{'valid': validClientName, 'invalid': invalidClientName}" data-length="50" maxlength="50" required>
                                            <label for="client_name">Nombre</label>
                                        </div>
                                        <div class="input-field col s8">
                                            <input placeholder="" :value="clientEmail" @input="$emit('update:clientEmail', $event.target.value)" id="receipt_client_email" type="email" :disabled="newClientToggle == false" v-on:blur="validateReceiptClientEmail" v-bind:class="{'valid': validClientEmail, 'invalid': invalidClientEmail}" data-length="40" maxlength="40">
                                            <label for="client_email">E-mail</label>
                                        </div>
                                        <div class="input-field col s4">
                                            <input placeholder="" :value="clientPhone" @input="$emit('update:clientPhone', $event.target.value)" id="receipt_client_phone" type="tel" :disabled="newClientToggle == false" v-on:blur="validateReceiptClientPhone" v-bind:class="{'valid': validClientPhone, 'invalid': invalidClientPhone}" data-length="10" minlength="10" maxlength="10">
                                            <label for="client_phone">Teléfono</label>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="input-field col s12 m12">
                            <select class="icons">
                                <option value="" data-icon="svg/baseline-attach_money-24px.svg">Efectivo</option>
                                <option value="" data-icon="svg/baseline-payment-24px.svg">Tarjeta de crédito / débito</option>
                            </select>
                            <label>Forma de pago</label>
                        </div>
                        <div class="col m8 switch">
                            <label>
                              Venta facturada
                              <input type="checkbox">
                              <span class="lever"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        mounted() {
            document.addEventListener('DOMContentLoaded', function() {
              var elems = document.querySelectorAll('select');
              var instances = M.FormSelect.init(elems);
            });
        },

        data() {
            return {
                searchProduct: '',
                componentKey: 0
            }
        },
    }
</script>
