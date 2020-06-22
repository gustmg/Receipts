export default {
    namespaced: true,

    state: {
        services: [],
        serviceToUpdate: {},
        serviceToUpdatePrevCost: 0,
        searchServiceValue: '',
    },

    mutations: {
        SET_SERVICES(state, services) {
            state.services = services
        },
        ADD_SERVICE(state, service) {
            state.services.push(service)
        },
        UPDATE_SERVICE(state, service) {
            var index= state.services.findIndex(state_service => state_service.service_id === service.service_id);
            state.services[index].service_name = service.service_name;
            state.services[index].service_description = service.service_description;
            state.services[index].service_code = service.service_code;
            state.services[index].service_cost = service.service_cost;
            state.services[index].service_base_price_percentage = service.service_base_price_percentage;
            state.services[index].service_retail_price_percentage = service.service_retail_price_percentage;
            state.services[index].service_wholesale_price_percentage = service.service_wholesale_price_percentage;
        },
        SET_SERVICE_TO_UPDATE(state, service) {
            state.serviceToUpdate = service
            state.serviceToUpdate_prev_cost = service.service_cost
        },
        UPDATE_SEARCH_SERVICE_VALUE(state, updateSearchServiceValue) {
            state.searchServiceValue = updateSearchServiceValue
        },
    },

    actions: {
        fetchServices: function({commit}) {
            axios.get('/services')
            .then(response => {commit('SET_SERVICES', response.data.services)})
            .catch(function (error){
                console.log(error);
            });
        },

        addService: function({commit}, service) {
            axios.post('/services',{
                service_name: service.service_name,
                service_description: service.service_description,
                service_code: service.service_code,
            })
            .then(response=>{commit('ADD_SERVICE', response.data.service)})
            .catch(function(error){
                console.log(error);
            });
        },

        updateService: function({commit}, service) {
            axios.put('/services/'+service.service_id,{
                service_name: service.service_name,
                service_description: service.service_description,
                service_code: service.service_code,
                service_cost: service.service_cost,
                service_base_price_percentage: service.service_base_price_percentage,
                service_retail_price_percentage: service.service_retail_price_percentage,
                service_wholesale_price_percentage: service.service_wholesale_price_percentage,
            })
            .then(response => {commit('UPDATE_SERVICE', response.data.service)})
            .catch(function(err){
                console.log(err);
            });
        },

        setServiceToUpdate: function({commit}, service) {
            var service_to_update = _.cloneDeep(service)
            commit('SET_SERVICE_TO_UPDATE', service_to_update)
        },

        updateSearchServiceValue: function({commit}, updateSearchServiceValue) {
            commit('UPDATE_SEARCH_SERVICE_VALUE', updateSearchServiceValue)
        }
    },
}