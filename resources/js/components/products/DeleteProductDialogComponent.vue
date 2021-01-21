<template>
    <v-dialog v-model="deleteProductDialog" width="480">
        <template v-slot:activator="{ on, attrs }">
            <v-btn icon v-on="on" v-bind="attrs">
                <v-icon>mdi-delete</v-icon>
            </v-btn>
        </template>
        <v-card>
            <v-card-title class="font-weight-bold justify-center">Eliminar producto</v-card-title>
            <v-card-text>
                Los registros relacionados con este producto serán eliminados.
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn class="secondary--text px-4" text v-on:click="deleteProductDialog = false">Cancelar</v-btn>
                <v-btn class="error white--text px-4" v-on:click="triggerDeleteProduct()">
                    Eliminar
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<style></style>
<script>
    import { mapActions } from 'vuex'

    export default {
        props: {
            productId: {
                type: Number,
            },
        },

        data() {
            return {
                deleteProductDialog: false,
            }
        },

        methods: {
            ...mapActions('products', ['deleteProduct', 'fetchProducts']),

            triggerDeleteProduct: async function() {
                await this.deleteProduct(this.productId)
                await this.fetchProducts()
                this.deleteProductDialog = false
            },
        },
    }
</script>
