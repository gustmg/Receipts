<template>
    <v-dialog v-model="newAccessoryDialog" width="360">
        <template v-slot:activator="{ on, attrs }">
            <v-btn class="primary" fab v-bind="attrs" v-on="on"><v-icon>mdi-plus</v-icon></v-btn>
        </template>
        <v-card>
            <v-card-title class="justify-center">Accesorio de equipo</v-card-title>
            <v-card-text class="pb-0">
                <v-container fluid class="px-0">
                    <v-form v-model="newAccessoryForm" ref="newAccessoryForm">
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="newAccessoryName"
                                    label="Nombre *"
                                    :rules="requiredRule"
                                    filled
                                    rounded
                                    validate-on-blur
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="newAccessorySerialNumber"
                                    label="Número de serie"
                                    :rules="serialNumberRules"
                                    filled
                                    rounded
                                    validate-on-blur
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-container>
            </v-card-text>
            <v-card-actions class="py-0">
                <v-container>
                    <v-row>
                        <v-col cols="6">
                            <v-btn class="primary--text" block text v-on:click="resetNewAccessoryInputs">
                                Cancelar
                            </v-btn>
                        </v-col>
                        <v-col cols="6">
                            <v-btn class="primary" block :disabled="!newAccessoryForm" v-on:click="addAccessory">
                                Agregar
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
    import { mapMutations } from 'vuex'
    export default {
        data() {
            return {
                newAccessoryDialog: false,
                newAccessoryForm: false,
                newAccessoryName: '',
                newAccessorySerialNumber: '',
                requiredRule: [v => !!v || this.requiredFieldErrorMessage],
                serialNumberRules: [
                    v => {
                        if (!v || v.length == 0) return true
                        if (!v || v.length > 3) return true
                        return 'El número de serie debe contener al menos 4 caracteres.'
                    },
                ],
                requiredFieldErrorMessage: 'Este campo es requerido.',
            }
        },

        methods: {
            ...mapMutations('accessories', ['ADD_ACCESSORY']),

            addAccessory: function() {
                this.ADD_ACCESSORY({
                    accessory_name: this.newAccessoryName,
                    accessory_serial_number: this.newAccessorySerialNumber,
                })

                this.resetNewAccessoryInputs()
            },

            saveAccessory: function() {
                var newAccessory = {
                    accessory_id: '',
                    accessory_name: this.newAccessoryName,
                    accessory_serial_number: this.newAccessorySerialNumber,
                }

                axios
                    .post('http://localhost:8000/accessories', {
                        accessory_name: this.newAccessoryName,
                        accessory_serial_number: this.newAccessorySerialNumber,
                    })
                    .then(res => {
                        newAccessory.accessory_id = res.data.accessory_id
                    })
                    .catch(function(err) {
                        console.log(err)
                    })

                this.$parent.accessories.push(newAccessory)
                this.$parent.forceRerender()
                $('#newAccessoryModal').modal('close')
            },

            resetNewAccessoryInputs: function(e) {
                this.$refs.newAccessoryForm.reset()
                this.$refs.newAccessoryForm.resetValidation()
                this.newAccessoryDialog = false
            },
        },
    }
</script>
