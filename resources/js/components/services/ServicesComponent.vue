<template>
    <v-container>
        <service-search-bar-component></service-search-bar-component>
        <services-table-component></services-table-component>
        <new-service-modal-component></new-service-modal-component>
    </v-container>
</template>
<script>
    import { mapActions, mapGetters, mapMutations } from 'vuex'
    export default {
        mounted() {
            this.fetchServices()
        },

        computed: {
            ...mapGetters('services', ['getServices']),
        },

        methods: {
            ...mapActions('services', ['fetchServices']),
        },
    }
</script>
