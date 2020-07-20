<template>
    <div class="row" style="margin-bottom: 0;">
        <div class="card hoverable col s10 offset-s1" style="float: none;">
            <div class="input-field valign-wrapper">
                <i class="material-icons prefix">search</i>
                <input
                    :value="searchServiceValue"
                    @input="updateSearchService"
                    placeholder="Buscar servicio"
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
            ...mapGetters('services', {
                searchServiceValue: 'getSearchServiceValue',
            }),
        },

        methods: {
            ...mapMutations('services', ['UPDATE_SEARCH_SERVICE_VALUE']),

            updateSearchService: function(event) {
                this.UPDATE_SEARCH_SERVICE_VALUE(event.target.value)
            },
        },
    }
</script>
