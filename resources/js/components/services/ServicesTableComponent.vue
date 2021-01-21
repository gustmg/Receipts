<template>
    <v-row>
        <v-col cols="12">
            <v-card>
                <v-data-table
                    :headers="servicesTableHeaders"
                    :items="filteredServices"
                    show-select
                    item-key="service_id"
                    hide-default-footer
                >
                    <template v-slot:item.service_options="{ item }">
                        <edit-service-dialog-component :service="item"></edit-service-dialog-component>
                        <delete-service-dialog-component
                            :service-id="item.service_id"
                        ></delete-service-dialog-component>
                    </template>
                </v-data-table>
            </v-card>
        </v-col>
    </v-row>
</template>
<script>
    import { mapState, mapMutations, mapActions, mapGetters } from 'vuex'
    export default {
        data() {
            return {
                servicesTableHeaders: [
                    { text: 'Servicio', value: 'service_name' },
                    { text: 'Costo', value: 'service_cost' },
                    { text: 'Ganancia público en general', value: 'service_base_price_percentage' },
                    { text: 'Ganancia menudeo', value: 'service_retail_price_percentage' },
                    { text: 'Ganancia mayoreo', value: 'service_wholesale_price_percentage' },
                    { text: 'Opciones', value: 'service_options' },
                ],
            }
        },

        methods: {
            ...mapActions(['setServiceToUpdate', 'openModal']),

            updateService: function(service) {
                this.setServiceToUpdate(service)
                this.openModal($('#updateServiceModal'))
            },
        },

        computed: {
            ...mapState(['service_to_update']),
            ...mapGetters('services', {
                services: 'getServices',
                searchServiceValue: 'getSearchServiceValue',
            }),

            filteredServices: function() {
                return this.services.filter(service => {
                    return service.service_name.toLowerCase().indexOf(this.searchServiceValue.toLowerCase()) >= 0
                })
            },
        },
    }
</script>
