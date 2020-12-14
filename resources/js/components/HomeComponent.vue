<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <v-btn class="primary" v-on:click="createBackup()">Respaldar DB</v-btn>
                <v-snackbar v-model="backupSnackbar">
                    {{ backupMessage }}
                </v-snackbar>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
    export default {
        data() {
            return {
                backupSnackbar: false,
                backupMessage: '',
            }
        },

        methods: {
            createBackup: function() {
                axios
                    .post('createBackup')
                    .then(response => {
                        if (response.data == 1) {
                            this.backupMessage = 'La base de datos fue respaldada con éxito.'
                            this.backupSnackbar = true
                        }
                    })
                    .catch(error => console.log(error))
            },
        },
    }
</script>
