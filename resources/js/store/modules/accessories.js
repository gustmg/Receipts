import Axios from 'axios'

export default {
    namespaced: true,

    state: {
        accessories: [],
    },

    getters: {
        getAccessories: state => {
            return state.accessories
        },
    },

    mutations: {
        ADD_ACCESSORY(state, accessory) {
            state.accessories.push(accessory)
        },

        REMOVE_ACCESSORY(state, accessoryIndex) {
            state.accessories.splice(accessoryIndex, 1)
        },

        RESET_ACCESSORIES(state) {
            state.accessories = []
        },
    },

    actions: {
        saveAccessories: async function({ commit }, device) {
            try {
                await Promise.all(
                    device.device_accessories.map(async accessory => {
                        console.log('Guardando accessorio...' + accessory.accessory_name)
                        await axios.post('accessories', {
                            accessory_name: accessory.accessory_name,
                            accessory_serial_number: accessory.accessory_serial_number,
                            accessory_device_id: device.device_id,
                        })
                        console.log('Accesorio ' + accessory.accessory_name + ' guardado...OK')
                    })
                )
            } catch (error) {
                console.log(error)
            }
        },
    },
}
