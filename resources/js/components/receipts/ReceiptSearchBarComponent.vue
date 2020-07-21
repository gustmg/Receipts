<template>
    <div class="row" style="margin-bottom: 0;">
        <div class="card hoverable col s10 offset-s1" style="float: none;">
            <div class="input-field valign-wrapper">
                <i class="material-icons prefix">search</i>
                <input
                    :value="searchReceiptValue"
                    @input="updateSearchReceipt"
                    placeholder="Buscar receipte"
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
            ...mapGetters('receipts', {
                searchReceiptValue: 'getSearchReceiptValue',
            }),
        },

        methods: {
            ...mapMutations('receipts', ['SET_SEARCH_RECEIPT_VALUE']),

            updateSearchReceipt: function(event) {
                this.SET_SEARCH_RECEIPT_VALUE(event.target.value)
            },
        },
    }
</script>
