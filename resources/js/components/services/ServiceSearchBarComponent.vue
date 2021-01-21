<template>
    <v-row>
        <v-col cols="10" offset-md="1">
            <v-text-field
                :value="searchServiceValue"
                @input="updateSearchService"
                prepend-inner-icon="mdi-magnify"
                placeholder="Buscar servicio"
                type="text"
                solo
            ></v-text-field>
        </v-col>
    </v-row>
</template>
<style></style>
<script>
    import { mapGetters, mapMutations } from 'vuex'
    export default {
        computed: {
            ...mapGetters('services', {
                searchServiceValue: 'getSearchServiceValue',
            }),
        },

        methods: {
            ...mapMutations('services', ['SET_SEARCH_SERVICE_VALUE']),

            updateSearchService: function(event) {
                this.SET_SEARCH_SERVICE_VALUE(event)
            },
        },
    }
</script>
