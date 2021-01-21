<template>
    <v-row>
        <v-col cols="8" class="pb-0" offset-md="2">
            <v-text-field
                :value="searchClientValue"
                @input="updateSearchClient"
                prepend-inner-icon="mdi-magnify"
                placeholder="Buscar recepción"
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
            ...mapGetters('clients', {
                searchClientValue: 'getSearchClientValue',
            }),
        },

        methods: {
            ...mapMutations('clients', ['SET_SEARCH_CLIENT_VALUE']),

            updateSearchClient: function(event) {
                this.SET_SEARCH_CLIENT_VALUE(event)
            },
        },
    }
</script>
