<template>
    <v-container>
        <inventory-entries-list-component></inventory-entries-list-component>
        <new-inventory-entry-modal-component></new-inventory-entry-modal-component>
    </v-container>
</template>
<script>
    import { mapActions, mapState } from 'vuex'
    export default {
        mounted() {
            this.setCurrentUsername(this.user.name)
            this.fetchInventoryEntries()
            this.fetchProducts()
        },

        computed: {
            ...mapState(['current_inventory_entry_detail']),
        },

        props: {
            user: {
                type: Object,
            },
        },

        methods: {
            ...mapActions(['setCurrentUsername']),
            ...mapActions('inventoryEntries', ['fetchInventoryEntries']),
            ...mapActions('products', ['fetchProducts']),
        },
    }
</script>
