export default {
    namespaced: true,

    state: {
        devices: [],
    },

    getters: {
        getDevices: state => {
            return state.devices
        },
    },

    mutations: {
        ADD_DEVICE_TO_LIST(state, device) {
            state.devices.push(device)
        },

        REMOVE_DEVICE(state, deviceIndex) {
            state.devices.splice(deviceIndex, 1)
        },

        RESET_DEVICES(state) {
            state.devices = []
        },

        SET_DEVICES(state, devices) {
            state.devices = devices
        },
    },

    actions: {
        fetchDevices: async function({ commit }) {
            await axios
                .post('fetchDevices')
                .then(response => {
                    commit('SET_DEVICES', response.data.devices)
                })
                .catch(function(error) {
                    console.log(error)
                })
        },

        saveDevices: async function(context, receiptId) {
            try {
                await Promise.all(
                    context.state.devices.map(async device => {
                        console.log('Guardando device: ' + device.device_name)
                        await axios
                            .post('devices', {
                                device_name: device.device_name,
                                device_serial_number: device.device_serial_number,
                                device_trouble_description: device.device_trouble_description,
                                device_commentary: device.device_commentary,
                                device_receipt_id: receiptId,
                            })
                            .then(async response => {
                                await context.dispatch(
                                    'accessories/saveAccessories',
                                    {
                                        device_id: response.data.device_id,
                                        device_accessories: device.device_accessories,
                                    },
                                    { root: true }
                                )
                            })
                            .catch(error => {
                                console.log(error)
                            })
                        console.log('Device ' + device.device_name + ' guardado...OK')
                    })
                )
            } catch (error) {
                console.log(error)
            }
        },

        updateServiceStatus: async function({ commit }, serviceStatus) {
            try {
                await axios.put('devices/' + serviceStatus.device_id, serviceStatus)
            } catch (error) {
                console.log(error)
            }
        },
    },
}
