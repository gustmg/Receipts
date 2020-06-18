<template>
	<div class="row">
        <div class="col m12">
            <table v-if="this.products.length != 0" class="centered">
                <thead>
                    <tr>
                        <th class="product-checkbox-header">
                            <FormulateInput
                                type="checkbox"
                                class="valign-wrapper"
                            />
                        </th>
                        <th class="product-header">Producto</th>
                        <th class="product-stock-header">Existencias</th>
                        <th class="product-cost-header">Costo</th>
                        <th class="product-base-price-percentage-header">Ganancia público en general</th>
                        <th class="product-retail-price-percentage-header">Ganancia menudeo</th>
                        <th class="product-wholesale-price-percentage-header">Ganancia mayoreo</th>
                        <th class="product-options-header">Opciones</th>
                    </tr>
                </thead>
                <tbody v-show="products.length > 0">
                    <tr v-for="product in filteredProducts" v-bind:key="product.product_id">
                        <td>
                            <FormulateInput
                                type="checkbox"
                                class="valign-wrapper"
                            />
                        </td>
                        <td class="left-al">
                            <span class="valign-wrapper">{{product.product_name}}</span>
                            <span class="valign-wrapper">{{product.product_description}}</span>
                        </td>
                        <td>{{product.product_stock}}</td>
                        <td>$ {{product.product_cost}}</td>
                        <td>{{product.product_base_price_percentage}}%</td>
                        <td>{{product.product_retail_price_percentage}}%</td>
                        <td>{{product.product_wholesale_price_percentage}}%</td>
                        <td>
                            <button v-on:click="updateProduct(product)" class="waves-effect btn-flat"><i class="material-icons">edit</i></button>
                            <button class="waves-effect btn-flat"><i class="material-icons">delete</i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
		<div class="col s12">
			<h5 
				v-show="filteredProducts.length == 0 && this.searchProductValue != '' " 
				class="center grey-text">
				Búsqueda sin resultados.
			</h5>
			<h5 v-show="products.length == 0 && this.searchProductValue == ''" class="center grey-text">No hay productos registrados.</h5>
		</div>
        <update-product-modal-component></update-product-modal-component>
	</div>
</template>
<style scoped>
	.product-checkbox-header{
        width: 4%;
    }
    .product-cost-header,
    .product-stock-header,
    .product-base-price-percentage-header,
    .product-retail-price-percentage-header,
    .product-wholesale-price-percentage-header,
    .product-options-header{
        width: 10%;
    }
    .product-header{
        width: 30%;
    }
	.hoverable-card:hover{
		background-color: #eeeeee;
		transition: .1s;
	}
    .left-al{
        text-align: left;
    }
	.selectable{
		cursor: pointer;
	}
</style>
<script>
    import {mapState, mapMutations, mapActions} from "vuex";
	export default {
		mounted(){
            this.fetchProducts();
        },

		data() {
			return {
                productIndex: null,
			}
		},

		methods: {
            ...mapActions(['fetchProducts', 'setProductToUpdate', 'openModal']),
            
            updateProduct: function(product) {
                this.setProductToUpdate(product);
                this.openModal($('#updateProductModal'));
            }
		},

		computed: {
            ...mapState(['products', 'product_to_update', 'searchProductValue']),

			filteredProducts: function() {
				return this.products.filter((product)=>{
					return product.product_name.toLowerCase().indexOf(this.searchProductValue.toLowerCase()) >= 0;
					// || product.product_phone.indexOf(this.searchProduct) >= 0
				});   		
            }
		}
	}
</script>