<template>
    <v-list class="elevation-1">
        <template v-for="(device, index) in devices">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title>
                        {{ device.device_name }}
                        <div class="text-caption">SN: {{ device.device_serial_number }}</div>
                    </v-list-item-title>
                    <v-list-item-subtitle>
                        {{ device.device_trouble_description }}
                    </v-list-item-subtitle>
                    <div class="text-caption text--secondary mt-2">Accesorios ({{ device.accessories.length }})</div>
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
                </v-list-item-content>
            </v-list-item>
            <v-divider v-if="index < devices.length - 1"></v-divider>
        </template>
    </v-list>
</template>
<script>
    export default {
        props: {
            devices: {
                type: Array,
            },
        },

        methods: {
            getAccessorySerialNumber: function(accessory_serial_number) {
                if (accessory_serial_number) {
                    return accessory_serial_number
                } else {
                    return 'S/N'
                }
            },
        },

        computed: {
            filteredDevices: function() {
                return this.devices.filter(device => {
                    return device.device_name.toLowerCase().indexOf(this.$parent.searchDevice.toLowerCase()) >= 0
                })
            },
        },
    }
</script>
