<template>
    <v-dialog v-model="newProductDialog" width="480">
        <template v-slot:activator="{ on, attrs }">
            <v-speed-dial fixed bottom right>
                <template v-slot:activator>
                    <v-btn class="primary white--text" v-bind="attrs" v-on="on" fab>
                        <v-icon>mdi-plus</v-icon>
                    </v-btn>
                </template>
            </v-speed-dial>
        </template>
        <v-card>
            <v-card-title class="justify-center">Nuevo producto</v-card-title>
            <v-card-text>
                <v-container>
                    <v-form v-model="newProductForm">
                        <v-row>
                            <v-col cols="7">
                                <v-text-field
                                    label="Nombre"
                                    v-model="newProduct.product_name"
                                    filled
                                    rounded
                                ></v-text-field>
                            </v-col>
                            <v-col cols="5">
                                <v-text-field
                                    label="Código interno"
                                    v-model="newProduct.product_code"
                                    filled
                                    rounded
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    label="Descripción"
                                    v-model="newProduct.product_description"
                                    filled
                                    rounded
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn class="primary--text px-4" text v-on:click="closeProductDialog()">Cancelar</v-btn>
                <v-btn class="primary white--text px-4" :disabled="!newProductForm" v-on:click="triggerSaveProduct()">
                    Registrar
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<style scoped>
    .newProductModal {
        width: 37%;
        max-height: 80%;
        height: 55%;
    }
    .money {
        height: 84px;
    }
    .no-margin-bottom {
        margin-bottom: 0;
    }
</style>
<script>
    import { mapState, mapMutations, mapActions } from 'vuex'
    export default {
        mounted() {},

        data() {
            return {
                newProductDialog: false,
                newProductForm: false,
                newProduct: {
                    product_name: '',
                    product_code: '',
                    product_description: '',
                },
            }
        },

        methods: {
            ...mapActions('products', ['saveProduct', 'fetchProducts']),

            triggerSaveProduct: async function() {
                await this.saveProduct(this.newProduct)
                await this.fetchProducts()
                this.closeProductDialog()
            },

            closeProductDialog: function() {
                this.newProductDialog = false
                this.resetNewProductForm()
            },

            resetNewProductForm: function(e) {
                this.newProduct.product_name = ''
                this.newProduct.product_code = ''
                this.newProduct.product_description = ''
            },
        },
    }
</script>
