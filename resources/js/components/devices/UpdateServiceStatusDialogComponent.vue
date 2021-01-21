<template>
    <v-dialog v-model="updateServiceStatusDialog" width="480">
        <template v-slot:activator="{ on, attrs }">
            <v-btn small icon v-on="on" v-bind="attrs">
                <v-icon color="secondary">
                    mdi-debug-step-over
                </v-icon>
            </v-btn>
        </template>
        <v-card>
            <v-card-title class="font-weight-bold justify-center">Actualizar estatus de servicio</v-card-title>
            <v-card-text>
                <v-container>
                    <v-row align="center">
                        <v-col cols="12" align="center">
                            <div class="text-subtitle-2 mb-2">Siguiente status:</div>
                            <v-chip v-if="nextStatus" label :color="getChipColor">{{
                                nextStatus.service_status_name
                            }}</v-chip>
                        </v-col>
                        <v-col cols="12">
                            <v-textarea
                                label="Comentario (Opcional)"
                                rounded
                                filled
                                dense
                                no-resize
                                rows="4"
                                color="secondary"
                                v-model="service_status_commentary"
                            ></v-textarea>
                        </v-col>
                        <v-col cols="6">
                            <v-btn block text v-on:click="updateServiceStatusDialog = false">Cancelar</v-btn>
                        </v-col>
                        <v-col cols="6">
                            <v-btn block color="secondary" v-on:click="triggerUpdateServiceStatus()"
                                >Actualizar status</v-btn
                            >
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>
<script>
    import { mapGetters, mapActions } from 'vuex'

    export default {
        props: {
            serviceStatus: {
                type: Object,
            },
        },

        data() {
            return {
                updateServiceStatusDialog: false,
                service_status_commentary: '',
            }
        },

        computed: {
            ...mapGetters('receipts', {
                serviceStatusList: 'getServiceStatusList',
            }),

            nextStatus: function() {
                return this.serviceStatusList[this.serviceStatus.service_status_id]
            },

            getChipColor: function() {
                switch (this.serviceStatus.service_status_id + 1) {
                    case 2:
                        return 'blue'
                    case 3:
                        return 'green'
                    case 4:
                        return 'yellow'
                    case 5:
                        return 'red'
                }
            },
        },

        methods: {
            ...mapActions('devices', ['updateServiceStatus']),
            ...mapActions('receipts', ['fetchReceipts']),

            triggerUpdateServiceStatus: async function() {
                await this.updateServiceStatus({
                    device_id: this.serviceStatus.pivot.device_id,
                    service_status_id: this.nextStatus.service_status_id,
                    service_status_commentary: this.service_status_commentary,
                })
                await this.fetchReceipts()
                this.service_status_commentary = ''
                this.updateServiceStatusDialog = false
            },
        },
    }
</script>
