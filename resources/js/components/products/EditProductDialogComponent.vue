<template>
    <v-dialog v-model="editProductDialog" width="480">
        <template v-slot:activator="{ on, attrs }">
            <v-btn icon v-on="on" v-bind="attrs"><v-icon>mdi-pencil</v-icon></v-btn>
        </template>
        <v-card>
            <v-card-title class="font-weight-bold justify-center">Editar producto</v-card-title>
            <v-card-text>
                <v-container>
                    <v-form v-model="editProductForm" ref="editProductForm">
                        <v-row>
                            <v-col cols="7">
                                <v-text-field
                                    label="Nombre"
                                    color="secondary"
                                    v-model="product_name"
                                    filled
                                    rounded
                                ></v-text-field>
                            </v-col>
                            <v-col cols="5">
                                <v-text-field
                                    label="Código interno"
                                    color="secondary"
                                    v-model="product_code"
                                    filled
                                    rounded
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    label="Descripción"
                                    color="secondary"
                                    v-model="product_description"
                                    filled
                                    rounded
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    label="Costo"
                                    color="secondary"
                                    type="number"
                                    min="0"
                                    v-model="product_cost"
                                    :rules="costRules"
                                    filled
                                    rounded
                                    validate-on-blur
                                ></v-text-field>
                                <v-expand-transition>
                                    <v-alert v-if="lowerCost" color="warning">
                                        <div class="text-subtitle-2">
                                            El costo ingresado es menor que el costo previamente registrado. Esto puede
                                            ocasionar pérdidas en sus ventas.
                                        </div>
                                    </v-alert>
                                </v-expand-transition>
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
                                    v-model="product_base_price_percentage"
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
                                    v-model="product_retail_price_percentage"
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
                                    v-model="product_wholesale_price_percentage"
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
                <v-btn class="secondary--text px-4" text v-on:click="editProductDialog = false">Cancelar</v-btn>
                <v-btn
                    class="secondary primary--text px-4"
                    :disabled="!editProductForm"
                    v-on:click="triggerUpdateProduct()"
                >
                    Editar
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<style></style>
<script>
    import { mapActions } from 'vuex'

    export default {
        mounted() {
            this.product_name = this.product.product_name
            this.product_code = this.product.product_code
            this.product_description = this.product.product_description
            this.product_cost = this.product.product_cost
            this.product_base_price_percentage = this.product.product_base_price_percentage
            this.product_retail_price_percentage = this.product.product_retail_price_percentage
            this.product_wholesale_price_percentage = this.product.product_wholesale_price_percentage
        },

        props: {
            product: {
                type: Object,
            },
        },

        data() {
            return {
                editProductDialog: false,
                editProductForm: false,
                lowerCost: false,
                product_name: '',
                product_code: '',
                product_description: '',
                product_cost: 0,
                product_base_price_percentage: 0,
                product_retail_price_percentage: 0,
                product_wholesale_price_percentage: 0,

                productNameRules: [v => !!v || 'Este campo es requerido.'],
                percentageRules: [v => (v >= 0 && v <= 100) || 'Porcentaje no válido.'],
                costRules: [v => v >= 0 || 'El costo ingresado no es válido', v => !!v || 'Este campo es requerido'],
            }
        },

        watch: {
            product_cost: function(newCost) {
                if (newCost < this.product.product_cost) {
                    this.lowerCost = true
                } else this.lowerCost = false
            },
        },

        methods: {
            ...mapActions('products', ['updateProduct', 'fetchProducts']),

            triggerUpdateProduct: async function() {
                await this.updateProduct({
                    product_id: this.product.product_id,
                    product_name: this.product_name,
                    product_code: this.product_code,
                    product_description: this.product_description,
                    product_cost: this.product_cost,
                    product_base_price_percentage: this.product_base_price_percentage,
                    product_retail_price_percentage: this.product_retail_price_percentage,
                    product_wholesale_price_percentage: this.product_wholesale_price_percentage,
                })
                await this.fetchProducts()
                this.$refs.editProductForm.resetValidation()
                this.editProductDialog = false
            },
        },
    }
</script>
