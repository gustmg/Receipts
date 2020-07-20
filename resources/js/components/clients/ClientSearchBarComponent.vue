<template>
    <div class="row" style="margin-bottom: 0;">
        <div class="card hoverable col s10 offset-s1" style="float: none;">
            <div class="input-field valign-wrapper">
                <i class="material-icons prefix">search</i>
                <input
                    :value="searchClientValue"
                    @input="updateSearchClient"
                    placeholder="Buscar cliente"
                    type="text"
                    style="border-bottom: none!important;box-shadow: none!important;margin-bottom: 0;"
                />
            </div>
        </div>
    </div>
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
                this.SET_SEARCH_CLIENT_VALUE(event.target.value)
            },
        },
    }
</script>
