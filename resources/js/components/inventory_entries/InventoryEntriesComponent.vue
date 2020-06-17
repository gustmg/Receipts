<template>
    <div class="row">
        <inventory-entries-list-component></inventory-entries-list-component>
        <new-inventory-entry-button-component></new-inventory-entry-button-component>
        <new-inventory-entry-modal-component></new-inventory-entry-modal-component>
        <products-list-with-stocks-modal-component></products-list-with-stocks-modal-component>
        <inventory-entry-detail-modal-component :inventory-entry-detail="this.current_inventory_entry_detail"></inventory-entry-detail-modal-component>
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
            ...mapState(['current_inventory_entry_detail'])
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