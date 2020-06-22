export default {
    namespaced: true,

    state: {
        inventoryExits: [], //Lista de salidas de inventario
        productsToExit: [], //Lista de productos elegidos para registrar en salida
        productsExitDetail: [], //Lista de detalles de los productos a registrarse en la salida (Cantidad de productos y comentario de salida)
        currentInventoryExitDetail: null
    },

    mutations: {
        SET_INVENTORY_EXITS(state, inventory_exits) {
            state.inventoryExits= inventory_exits
        },

        SET_PRODUCTS_TO_EXIT(state, products) {
            if(state.productsToExit.length == 0){
                state.productsToExit = products

                products.forEach( product => {
                    var productExit = {
                        product_id: product.product_id,
                        checked: false,
                        product_exit_amount: null,
                        product_exit_justification: null
                    }
                    state.productsExitDetail.push(productExit);
                });
            }
            else{
                products.forEach( product => {
                    var isInList=0;

                    state.productsToExit.forEach(productToExit => {
                        if(productToExit.product_id == product.product_id){
                            isInList++;
                        }
                    })

                    if(isInList==0){
                        state.productsToExit.push(product)
                        var productExit = {
                            product_id: product.product_id,
                            checked: false,
                            product_exit_amount: null,
                            product_exit_justification: null
                        }
                        state.productsExitDetail.push(productExit)
                    }
                });
            }
            
        },

        UPDATE_PRODUCT_AMOUNT(state, newProductAmount) {
            state.productsExitDetail[newProductAmount.product_index].product_exit_amount = newProductAmount.newValue;
        },

        UPDATE_PRODUCT_EXIT_JUSTIFICATION(state, newProductExitJustification) {
            state.productsExitDetail[newProductExitJustification.product_index].product_exit_justification = newProductExitJustification.new_exit_justification;
        },

        SET_CURRENT_INVENTORY_EXIT_DETAIL(state, inventoryExitId) {
            var index= state.inventoryExits.findIndex(state_inventory_exit => state_inventory_exit.inventory_exit_id === inventoryExitId);
            state.currentInventoryExitDetail = state.inventoryExits[index];
        },

        RESET_INVENTORY_EXIT_MODAL(state) {
            state.productsToExit= [];
            state.productsExitDetail= [];
        }
    },

    actions: {
        fetchInventoryExits: function({commit}) {
            axios.get('/inventory_exits')
            .then(response => {commit('SET_INVENTORY_EXITS', response.data.inventory_exits)})
            .catch(function(error){
                console.log(error);
            });
        },

        setProductsToExit: function ({commit}, products) {
            commit('SET_PRODUCTS_TO_EXIT', products);
        },

        updateProductAmount: function({commit}, newProductAmount) {
            commit('UPDATE_PRODUCT_AMOUNT', newProductAmount);
        },

        updateProductExitJustification: function({commit}, newProductExitJustification) {
            commit('UPDATE_PRODUCT_EXIT_JUSTIFICATION', newProductExitJustification);
        },

        addInventoryExit: function({dispatch}) {
            axios.post('/inventory_exits')
            .then(function(){
                dispatch('addInventoryExitProducts');
            })
            .catch(function(error){
                console.log(error);
            });
        },

        addInventoryExitProducts: function(context) {
            axios.post('/inventory_exits_products', {
                products_exit_detail: context.state.productsExitDetail
            })
            .then(function(){
                context.dispatch('fetchInventoryExits');
                context.commit('RESET_INVENTORY_EXIT_MODAL');
            })
            .catch(function(error){
                console.log(error);
            });
        },

        setCurrentInventoryExitDetail: function({commit}, inventoryExitId) {
            commit('SET_CURRENT_INVENTORY_EXIT_DETAIL', inventoryExitId)
        }
    },
}