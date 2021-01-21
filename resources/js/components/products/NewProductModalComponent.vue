<template>
    <v-dialog v-model="newProductDialog" width="480">
        <template v-slot:activator="{ on, attrs }">
            <v-speed-dial fixed bottom right>
                <template v-slot:activator>
                    <v-btn class="secondary primary--text" v-bind="attrs" v-on="on" fab>
                        <v-icon>mdi-plus</v-icon>
                    </v-btn>
                </template>
            </v-speed-dial>
        </template>
        <v-card>
            <v-card-title class="justify-center">Nuevo producto</v-card-title>
            <v-card-text>
                <v-container>
                    <v-form v-model="newProductForm" ref="newProductForm">
                        <v-row>
                            <v-col cols="7">
                                <v-text-field
                                    label="Nombre"
                                    color="secondary"
                                    v-model="newProduct.product_name"
                                    :rules="productNameRules"
                                    filled
                                    rounded
                                ></v-text-field>
                            </v-col>
                            <v-col cols="5">
                                <v-text-field
                                    label="Código interno"
                                    color="secondary"
                                    v-model="newProduct.product_code"
                                    filled
                                    rounded
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    label="Descripción"
                                    color="secondary"
                                    v-model="newProduct.product_description"
                                    filled
                                    rounded
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <div class="text-subtitle-2">Porcentaje de ganancias</div>
                            </v-col>
                            <v-col cols="4">
                                <v-text-field
                                    label="PEG"
                                    color="secondary"
                                    type="number"
                                    min="0"
                                    max="100"
                                    :rules="percentageRules"
                                    v-model="newProduct.product_base_price_percentage"
                                    filled
                                    rounded
                                    validate-on-blur
                                ></v-text-field>
                            </v-col>
                            <v-col cols="4">
                                <v-text-field
                                    label="Menudeo"
                                    color="secondary"
                                    type="number"
                                    min="0"
                                    max="100"
                                    :rules="percentageRules"
                                    v-model="newProduct.product_retail_price_percentage"
                                    filled
                                    rounded
                                    validate-on-blur
                                ></v-text-field>
                            </v-col>
                            <v-col cols="4">
                                <v-text-field
                                    label="Mayoreo"
                                    color="secondary"
                                    type="number"
                                    min="0"
                                    max="100"
                                    :rules="percentageRules"
                                    v-model="newProduct.product_wholesale_price_percentage"
                                    filled
                                    rounded
                                    validate-on-blur
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn class="secondary--text px-4" text v-on:click="closeProductDialog()">Cancelar</v-btn>
                <v-btn
                    class="secondary primary--text px-4"
                    :disabled="!newProductForm"
                    v-on:click="triggerSaveProduct()"
                >
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
                    product_base_price_percentage: 0,
                    product_retail_price_percentage: 0,
                    product_wholesale_price_percentage: 0,
                },

                productNameRules: [v => !!v || 'Este campo es requerido.'],
                percentageRules: [v => (v >= 0 && v <= 100) || 'Porcentaje no válido.'],
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
                this.newProduct.product_base_price_percentage = 0
                this.newProduct.product_retail_price_percentage = 0
                this.newProduct.product_wholesale_price_percentage = 0
                this.$refs.newProductForm.resetValidation()
            },
        },
    }
</script>
