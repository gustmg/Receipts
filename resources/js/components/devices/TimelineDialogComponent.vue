<template>
    <v-dialog v-model="deviceServiceTimelineDialog" width="480">
        <template v-slot:activator="{ on, attrs }">
            <v-btn icon v-on="on" v-bind="attrs">
                <v-icon color="secondary">mdi-timeline</v-icon>
            </v-btn>
        </template>
        <v-card>
            <v-card-title class="font-weight-bold justify-center">Historial de servicio a equipo</v-card-title>
            <v-card-text>
                <v-timeline>
                    <v-timeline-item
                        v-for="(service_status, index) in statusList"
                        :key="index"
                        :color="getChipColor(service_status.service_status_id)"
                    >
                        <div class="text-caption">{{ service_status.created_at }}</div>
                        <div class="text-subtitle-2 font-weight-bold">{{ service_status.service_status_name }}</div>
                    </v-timeline-item>
                </v-timeline>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>
<script>
    export default {
        props: {
            statusList: {
                type: Array,
            },
        },

        data() {
            return {
                deviceServiceTimelineDialog: false,
            }
        },

        methods: {
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
