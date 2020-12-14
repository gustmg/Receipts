<template>
    <v-row>
        <v-col cols="10" offset-md="1">
            <v-text-field
                :value="searchReceiptValue"
                @input="updateSearchReceipt"
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
            ...mapGetters('receipts', {
                searchReceiptValue: 'getSearchReceiptValue',
            }),
        },

        methods: {
            ...mapMutations('receipts', ['SET_SEARCH_RECEIPT_VALUE']),

            updateSearchReceipt: function(event) {
                this.SET_SEARCH_RECEIPT_VALUE(event)
            },
        },
    }
</script>
