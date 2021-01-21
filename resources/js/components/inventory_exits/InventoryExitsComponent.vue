<template>
    <v-container>
        <inventory-exits-list-component></inventory-exits-list-component>
        <new-inventory-exit-modal-component></new-inventory-exit-modal-component>
    </v-container>
</template>
<script>
    import { mapActions, mapState } from 'vuex'
    export default {
        mounted() {
            this.setCurrentUsername(this.user.name)
            this.fetchInventoryExits()
            this.fetchProducts()
        },

        computed: {
            ...mapState(['current_inventory_exit_detail']),
        },

        props: {
            user: {
                type: Object,
            },
        },

        methods: {
            ...mapActions(['setCurrentUsername']),
            ...mapActions('inventoryExits', ['fetchInventoryExits']),
            ...mapActions('products', ['fetchProducts']),
        },
    }
</script>
