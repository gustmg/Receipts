<template>
    <div class="row" style="margin-bottom: 0;">
        <div class="card hoverable col s10 offset-s1" style="float: none;">
            <div class="input-field valign-wrapper">
                <i class="material-icons prefix">search</i>
                <input
                    :value="searchProductValue"
                    @input="updateSearchProduct"
                    placeholder="Buscar producto"
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
            ...mapGetters('products', {
                searchProductValue: 'getSearchProductValue',
            }),
        },

        methods: {
            ...mapMutations('products', ['UPDATE_SEARCH_PRODUCT_VALUE']),

            updateSearchProduct: function(event) {
                this.UPDATE_SEARCH_PRODUCT_VALUE(event.target.value)
            },
        },
    }
</script>
