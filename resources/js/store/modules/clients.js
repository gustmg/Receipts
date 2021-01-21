export default {
    namespaced: true,

    state: {
        clients: [],
        searchClientValue: '',
        lastClientId: 0,
    },

    getters: {
        getClients: state => {
            return state.clients
        },

        getSearchClientValue: state => {
            return state.searchClientValue
        },

        getNewClientId: state => {
            return state.lastClientId + 1
        },
    },

    mutations: {
        SET_CLIENTS(state, clients) {
            state.clients = clients
        },

        SET_LAST_CLIENT_ID(state, lastClientId) {
            state.lastClientId = lastClientId
        },

        SET_SEARCH_CLIENT_VALUE(state, updateSearchClientValue) {
            state.searchClientValue = updateSearchClientValue
        },
    },

    actions: {
        fetchClients: function({ commit }) {
            axios
                .post('fetchClients')
                .then(response => {
                    commit('SET_CLIENTS', response.data.clients)
                })
                .catch(function(error) {
                    console.log(error)
                })
        },

        fetchLastClientId: function({ commit }) {
            axios
                .post('fetchLastClientId')
                .then(response => {
                    commit('SET_LAST_CLIENT_ID', response.data.last_client_id)
                })
                .catch(function(error) {
                    console.log(error)
                })
        },

        saveClient: async function({ commit, dispatch }, client) {
            try {
                await axios.post('clients', client)
            } catch (error) {
                console.log(error)
            }
        },

        updateClient: async function({ commit }, client) {
            try {
                await axios.put('clients/' + client.client_id, client)
            } catch (error) {
                console.log(error)
            }
        },

        deleteClient: async function({ commit }, client_id) {
            try {
                await axios.delete('clients/' + client_id)
            } catch (error) {
                console.log(error)
            }
        },
    },
}
