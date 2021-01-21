<template>
    <v-container>
        <client-search-bar-component></client-search-bar-component>
        <clients-table-component></clients-table-component>
        <new-client-modal-component></new-client-modal-component>
    </v-container>
</template>
<script>
    import { mapActions, mapGetters, mapMutations } from 'vuex'

    export default {
        mounted() {
            this.fetchClients()
        },

        computed: {
            ...mapGetters('clients', ['getClients']),
        },

        methods: {
            ...mapActions('clients', ['fetchClients']),
        },
    }
</script>
