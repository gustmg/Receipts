<template>
    <div class="row">
        <inventory-exits-list-component></inventory-exits-list-component>
        <new-inventory-exit-button-component></new-inventory-exit-button-component>
        <new-inventory-exit-modal-component></new-inventory-exit-modal-component>
        <products-list-with-stocks-modal-component></products-list-with-stocks-modal-component>
        <inventory-exit-detail-modal-component :inventory-exit-detail="this.currentInventoryExitDetail"></inventory-exit-detail-modal-component>
    </div>
</template>
<style scoped>
</style>
<script>
    import {mapActions, mapState} from "vuex";
    export default {
        mounted() {
            this.setCurrentUsername(this.user.name);
        },

        computed: {
            ...mapState('inventoryExits', {
                currentInventoryExitDetail: state => state.currentInventoryExitDetail
            }),
        },

        props: {
            user: {
                type: Object
            }
        },

        methods: {
            ...mapActions(['setCurrentUsername']),
        }
    }
</script>