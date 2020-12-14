<template>
    <v-row>
        <v-col cols="10" offset-md="1">
            <v-text-field
                :value="searchProductValue"
                @input="updateSearchProduct"
                prepend-inner-icon="mdi-magnify"
                placeholder="Buscar producto"
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
            ...mapGetters('products', {
                searchProductValue: 'getSearchProductValue',
            }),
        },

        methods: {
            ...mapMutations('products', ['SET_SEARCH_PRODUCT_VALUE']),

            updateSearchProduct: function(event) {
                this.SET_SEARCH_PRODUCT_VALUE(event)
            },
        },
    }
</script>
