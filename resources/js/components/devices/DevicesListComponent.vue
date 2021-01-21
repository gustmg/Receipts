<template>
    <v-list class="elevation-1">
        <template v-for="(device, index) in devices">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title>
                        <v-container class="pa-0">
                            <v-row align="center">
                                <v-col cols="10">
                                    <div class="text-subtitle-1 font-weight-bold">
                                        {{ device.device_name }}
                                    </div>
                                    <div class="text-subtitle-2">SN: {{ device.device_serial_number }}</div>
                                    <v-chip
                                        small
                                        label
                                        :color="
                                            getChipColor(
                                                device.service_status[device.service_status.length - 1]
                                                    .service_status_id
                                            )
                                        "
                                        >{{
                                            device.service_status[device.service_status.length - 1].service_status_name
                                        }}</v-chip
                                    >
                                    <update-service-status-dialog-component
                                        v-if="
                                            device.service_status[device.service_status.length - 1].service_status_id <
                                                6
                                        "
                                        :service-status="device.service_status[device.service_status.length - 1]"
                                    ></update-service-status-dialog-component>
                                </v-col>
                                <v-col cols="2">
                                    <timeline-dialog-component
                                        :status-list="device.service_status"
                                    ></timeline-dialog-component>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-list-item-title>
                    <v-list-item-subtitle>
                        <div class="text-subtitle-1">{{ device.device_trouble_description }}</div>
                        <div class="text-subtitle-1">{{ device.service_status[0].device_service_commentary }}</div>
                    </v-list-item-subtitle>
                    <div class="text-caption text--secondary mt-2">Accesorios ({{ device.accessories.length }})</div>
                    <v-card outlined>
                        <v-list-item-content v-if="device.accessories.length != 0">
                            <v-list two-line>
                                <v-list-item
                                    v-for="(accessory, index) in device.accessories"
                                    v-bind:key="accessory.accessory_id"
                                    class="px-0"
                                >
                                    <v-list-item-avatar class="mr-1">
                                        <v-icon>mdi-keyboard</v-icon>
                                    </v-list-item-avatar>
                                    <v-list-item-content>
                                        <v-list-item-title>
                                            <div class="text-body-2">{{ accessory.accessory_name }}</div>
                                        </v-list-item-title>
                                        <v-list-item-subtitle>
                                            {{ getAccessorySerialNumber(accessory.accessory_serial_number) }}
                                        </v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list>
                        </v-list-item-content>
                    </v-card>
                </v-list-item-content>
            </v-list-item>
            <v-divider v-if="index < devices.length - 1"></v-divider>
        </template>
    </v-list>
</template>
<script>
    import { mapActions } from 'vuex'

    export default {
        props: {
            devices: {
                type: Array,
            },
        },

        computed: {
            filteredDevices: function() {
                return this.devices.filter(device => {
                    return device.device_name.toLowerCase().indexOf(this.$parent.searchDevice.toLowerCase()) >= 0
                })
            },
        },

        methods: {
            ...mapActions('devices', ['updateServiceStatus']),

            getAccessorySerialNumber: function(accessory_serial_number) {
                if (accessory_serial_number) {
                    return accessory_serial_number
                } else {
                    return 'S/N'
                }
            },

            triggerUpdateServiceStatus: async function(device) {
                await this.updateServiceStatus(device)
            },

            getChipColor: function(service_status_id) {
                switch (service_status_id) {
                    case 1:
                        return '#CFD8DC'
                    case 2:
                        return '#FFD600'
                    case 3:
                        return '#0091EA'
                    case 4:
                        return '#FF6E40'
                    case 5:
                        return '#EF5350'
                    case 6:
                        return '#00E676'
                }
            },
        },
    }
</script>
