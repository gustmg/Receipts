<template>
    <div class="row">
        <div class="col s12 m3" v-show="clients.length > 0" v-for="(client, index) in filteredClients">
            <div v-on:click="updateClient(client, index)" class="card hoverable hoverable-card selectable">
                <div class="card-content center-align">
                    <span class="card-title">
                        <i class="material-icons inline-icon-large">person</i><br />
                        <b v-if="client.client_name">{{ client.client_name }}</b>
                    </span>
                    <p>
                        <i class="material-icons inline-icon-small">phone</i>
                        <span v-if="client.client_phone">{{ client.client_phone }}</span>
                        <span v-else class="grey-text">Teléfono no registrado</span>
                    </p>
                    <p>
                        <i class="material-icons inline-icon-small">email</i>
                        <span v-if="client.client_email">{{ client.client_email }}</span>
                        <span v-else class="grey-text">Email no registrado</span>
                    </p>
                </div>
            </div>
        </div>
        <div>
            <h5 v-show="filteredClients.length == 0 && this.$parent.searchClient != ''" class="center grey-text">
                Búsqueda sin resultados.
            </h5>
            <h5 v-show="clients.length == 0 && this.$parent.searchClient == ''" class="center grey-text">
                No hay clientes registrados.
            </h5>
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

    .hoverable-card:hover {
        background-color: #eeeeee;
        transition: 0.1s;
    }

    .selectable {
        cursor: pointer;
    }
</style>
<script>
    export default {
        mounted() {},

        props: {
            clients: {
                type: Array,
            },
        },

        data() {
            return {
                clientIndex: null,
                clientId: '',
                clientName: '',
                clientPhone: '',
                clientEmail: '',
            }
        },

        methods: {
            updateClient: function(client, index) {
                this.clientIndex = index
                this.clientId = client.client_id
                this.clientName = client.client_name
                this.clientPhone = client.client_phone
                this.clientEmail = client.client_email
                $('#update_client_name,#update_client_phone,#update_client_email').characterCounter()
                $('#updateClientModal').modal({
                    dismissible: false,
                    onOpenStart: function() {
                        $('.label_update_client_name').addClass('active')
                        if (client.client_phone != null) {
                            $('.label_update_client_phone').addClass('active')
                        }
                        if (client.client_email != null) {
                            $('.label_update_client_email').addClass('active')
                        }
                    },
                    onCloseEnd: function() {
                        //TO-DO: Rmeove al validations and clear the form
                    },
                })
                $('#updateClientModal').modal('open')
            },
        },

        computed: {
            filteredClients: function() {
                return this.clients.filter(client => {
                    return client.client_name.toLowerCase().indexOf(this.$parent.searchClient.toLowerCase()) >= 0
                    // || client.client_phone.indexOf(this.searchClient) >= 0
                    // || client.client_email.indexOf(this.searchClient) >= 0;
                })
            },
        },
    }
</script>
